<?php
        	
namespace Addons\ChouJiangH\Model;
use Home\Model\WeixinModel;
        	
/**
 * ChouJiangH的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'ChouJiangH' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	