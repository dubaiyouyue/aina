<?php

namespace Addons\Zffbcopy\Controller;
use Home\Controller\AddonsController;

class ZffbcopyController extends AddonsController{
	var $model;
	function _initialize() {
		$this->model = $this->getModel ( 'finance_copy' );
		parent::_initialize ();
		$act = strtolower ( _ACTION );
		$type = I ( 'type' );
		
		/*$res ['title'] = '订单管理';
		$res ['url'] = addons_url ( 'DingDan://DingDan/lists' );
		$res ['class'] = $act == 'lists' || $type == 'text' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '关闭配送';
		$res ['url'] = addons_url ( 'DingDan://DingDan/config' );
		$res ['class'] = $act == 'config' || $type == 'config' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '导出订单';
		$res ['url'] = addons_url ( 'DingDan://DingDan/dc' );
		$res ['class'] = $act == 'dc' || $type == 'dc' ? 'current' : '';
		$nav [] = $res;*/
		
		$this->assign ( 'nav', $nav );
	}
	// 通用插件的列表模型
	public function lists() {
		$map ['token'] = get_token ();
		$list_data = $this->_get_model_list ( $this->model );
		$this->assign ( $list_data );
		$templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
		$this->display ( $templateFile );
	}
	
	public function add() {

	}
	public function edit() {

	}
	public function del() {

	}
	
	
	
	
}