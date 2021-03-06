<?php

namespace Addons\WeiSite\Controller;

use Addons\WeiSite\Controller\BaseController;

class CmsController extends BaseController {
	var $model;
	function _initialize() {
		$this->model = $this->getModel ( 'custom_reply_news' );
		parent::_initialize ();
	}
	// 通用插件的列表模型
	public function lists() {
		// 使用提示
		$normal_tips = '文章的数据来源官方自定义回复插件中的图文回复，如有异常请确认自定义回复插件是否已经安装';
		$this->assign ( 'normal_tips', $normal_tips );

		$map ['token'] = get_token ();
		session ( 'common_condition', $map );

		$list_data = $this->_get_model_list ( $this->model );

		// 分类数据
		$map ['is_show'] = 1;
		$list = M ( 'weisite_category' )->where ( $map )->field ( 'id,title' )->select ();
		$cate [0] = '';
		foreach ( $list as $vo ) {
			$cate [$vo ['id']] = $vo ['title'];
		}

		foreach ( $list_data ['list_data'] as &$vo ) {
			$vo ['cate_id'] = intval ( $vo ['cate_id'] );
			$vo ['cate_id'] = $cate [$vo ['cate_id']];
		}
		$this->assign ( $list_data );
		// dump ( $list_data );

		$templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
		$this->display ( $templateFile );
	}
	// 通用插件的编辑模型
	public function edit() {
		$model = $this->model;
		$id = I ( 'id' );

		if (IS_POST) {
			$Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $model ['id'] );
			if($_POST['tu_huan']){
					foreach ($_POST['tu_huan'] as $k => $v) {
						if(!$k) $_POST['tu_huan']=$v;
						else $_POST['tu_huan'].=','.$v;
					}

			}
			else $_POST['tu_huan']=0;
			if ($Model->create () && $Model->save ()) {
				D ( 'Common/Keyword' )->set ( $_POST ['keyword'], _ADDONS, $id, $_POST ['keyword_type'], 'custom_reply_news' );

				$this->success ( '保存' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'] ) );
			} else {
				//dump($_POST);exit;
				$this->error ( $Model->getError () );
			}
		} else {
			$fields = get_model_attribute ( $model ['id'] );

			$extra = $this->getCateData ();

			if (! empty ( $extra )) {
				foreach ( $fields as &$vo ) {
					if ($vo ['name'] == 'cate_id') {
						$vo ['extra'] .= "\r\n" . $extra;
					}
				}
			}

			// 获取数据
			$data = M ( get_table_name ( $model ['id'] ) )->find ( $id );
				//dump($data);
				if($data['tu_huan']){
					//foreach ($data['tu_huan'] as $k => $v) {
						$data['tu_huan']=explode(',',$data['tu_huan']);
					//}
				}
			$data || $this->error ( '数据不存在！' );

		$token = get_token ();
		if (isset ( $data ['token'] ) && $token != $data ['token'] && defined ( 'ADDON_PUBLIC_PATH' )) {
			$this->error ( '非法访问！' );
		}

			$this->assign ( 'fields', $fields );
			$this->assign ( 'data', $data );
			$this->meta_title = '编辑' . $model ['title'];

			$this->display ();
		}
	}

	// 通用插件的增加模型
	public function add() {
		$model = $this->model;
		$Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );

		if (IS_POST) {
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $model ['id'] );
			if($_POST['tu_huan']){
					foreach ($_POST['tu_huan'] as $k => $v) {
						if(!$k) $_POST['tu_huan']=$v;
						else $_POST['tu_huan'].=','.$v;
					}

			}
			if ($Model->create () && $id = $Model->add ()) {
				D ( 'Common/Keyword' )->set ( $_POST ['keyword'], _ADDONS, $id, $_POST ['keyword_type'], 'custom_reply_news' );

				$this->success ( '添加' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'] ) );
			} else {
				$this->error ( $Model->getError () );
			}
		} else {
			$fields = get_model_attribute ( $model ['id'] );

			$extra = $this->getCateData ();
			if (! empty ( $extra )) {
				foreach ( $fields as &$vo ) {
					if ($vo ['name'] == 'cate_id') {
						$vo ['extra'] .= "\r\n" . $extra;
					}
				}
			}

			$this->assign ( 'fields', $fields );
			$this->meta_title = '新增' . $model ['title'];

			$this->display ();
		}
	}

	// 通用插件的删除模型
	public function del() {
		parent::common_del ( $this->model );
	}

	// 获取所属分类
	function getCateData() {
		$map ['is_show'] = 1;
		$map ['token'] = get_token ();
		$list = M ( 'weisite_category' )->where ( $map )->select ();
		foreach ( $list as $v ) {
			$extra .= $v ['id'] . ':' . $v ['title'] . "\r\n";
		}
		return $extra;
	}
}
