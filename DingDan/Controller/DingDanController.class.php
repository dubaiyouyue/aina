<?php

namespace Addons\DingDan\Controller;
use Home\Controller\AddonsController;

class DingDanController extends AddonsController{
	var $model;
	function _initialize() {
		$this->model = $this->getModel ( 'dingdan' );
		parent::_initialize ();
		$act = strtolower ( _ACTION );
		$type = I ( 'type' );
		
		$res ['title'] = '订单管理';
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
		$nav [] = $res;
		
		$this->assign ( 'nav', $nav );
	}
	/**
		* 导出数据为excel表格
		*@param $data    一个二维数组,结构如同从数据库查出来的数组
		*@param $title   excel的第一行标题,一个数组,如果为空则没有标题
		*@param $filename 下载的文件名
		*@examlpe 
		$stu = M ('User');
		$arr = $stu -> select();
		exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
	*/

	function dc(){
			if (! is_login ()) {
				redirect ( U ( 'home/user/login', array (
						'from' => 2 
				) ) );
			}
		$stu = M ('dingdan');
		$arr = $stu->field('ctime,dingdanbianhao,shouhuodz,bdddbz,daijinquan,goumaisp,fuk,zhuantai,beizhu,qrdd,viphy,youfei,peissfaina')->order('id desc')-> select();
		foreach($arr as $k=>&$v){
			$v['goumaisp']=str_ireplace("<br>"," ",$v['goumaisp']);
			//$v['tel']='电话：'.$v['tel'];
			//$v['transaction_id']='单号：'.$v['transaction_id'];
			$v['ctime']=date('Y-m-d',$v['ctime']);
			
			$v['dingdanbianhao']=str_ireplace("ainastea-","",$v['dingdanbianhao']);
			$v['shouhuodz']=str_ireplace("广西壮族自治区","",$v['shouhuodz']);
			
			if(!$v['fuk']) $v['fuk']='未付款';
			
			
			if($v['peissfaina']==1) $v['peissfaina']='艾娜配送';
			else $v['peissfaina']='站点自提';
			
			if($v['zhuantai']) $v['zhuantai']='已发货';
			else $v['zhuantai']='未发货';
			
			if($v['qrdd']==2) $v['qrdd']='确认';
			if($v['qrdd']==1) $v['qrdd']='等待';
			//if($v['bank_type']==1) $v['bank_type']='微信支付';
			//if($v['leixin']==1) $v['leixin']='购买';
			//else $v['leixin']='充值';
		}

		$this->exportexcel($arr,array('时间','订单号','地址','订单备注(祝福语)','代金券','商品','付款状态','状态','配送人员','订单状态','VIP优惠','邮费','配送'),'DingDan-'.date('Y-m-d'));
	}
	function exportexcel($data=array(),$title=array(),$filename='report'){
		header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Content-type:application/vnd.ms-excel");  
		header("Content-Disposition:attachment;filename=".$filename.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//导出xls 开始
		//echo '<style>br {mso-data-placement:same-cell;} </style>';
		if (!empty($title)){
			foreach ($title as $k => $v) {
				$title[$k]=iconv("UTF-8", "GBK",$v);
			}
			$title= implode("\t", $title);
			echo "$title\n";
		}
		if (!empty($data)){
			foreach($data as $key=>$val){
				foreach ($val as $ck => $cv) {
					$data[$key][$ck]=iconv("UTF-8", "GBK", $cv);
				}
				$data[$key]=implode("\t", $data[$key]);
				
			}
			echo implode("\n",$data);
		}
	}
	
	
	
	
	
public function del() {

	}public function add() {

	}
	
	
	
	
	
	
	// 通用插件的列表模型
	public function lists() {
		$map ['token'] = get_token ();
		$list_data = $this->_get_model_list ( $this->model );
		$this->assign ( $list_data );
		$templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
		$this->display ( $templateFile );
	}
}
