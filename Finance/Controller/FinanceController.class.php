<?php

namespace Addons\Finance\Controller;
use Home\Controller\AddonsController;

class FinanceController extends AddonsController{
	function _initialize() {
		$act = strtolower ( _ACTION );
		$type = I ( 'type' );
		
		$res ['title'] = '财务明细';
		$res ['url'] = addons_url ( 'Finance://Finance/lists' );
		$res ['class'] = $act == 'lists' || $type == 'text' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '导出列表';
		$res ['url'] = addons_url ( 'Finance://Finance/dc' );
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
		$stu = M ('Finance');
		$arr = $stu ->field('tel,jine,zsyue,leixin,ok,bank_type,transaction_id,ctime')->order('id desc')-> select();
		foreach($arr as $k=>&$v){
			$v['tel']='电话：'.$v['tel'];
			$v['transaction_id']='单号：'.$v['transaction_id'];
			$v['ctime']=date('Y-m-d',$v['ctime']);
			if($v['ok']) $v['ok']='已付款';
			if($v['bank_type']==1) $v['bank_type']='微信支付';
			if($v['leixin']==1) $v['leixin']='购买';
			else $v['leixin']='充值';
		}

		$this->exportexcel($arr,array('电话','金额','赠送余额','类型','是否付款','付款类型','交易单号','时间'),'Finance-'.date('Y-m-d'));
	}
	function exportexcel($data=array(),$title=array(),$filename='report'){
		header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Content-type:application/vnd.ms-excel");  
		header("Content-Disposition:attachment;filename=".$filename.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//导出xls 开始
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
}
