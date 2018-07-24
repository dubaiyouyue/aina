<?php
        	
namespace Addons\DingDan\Model;
use Home\Model\WeixinModel;
        	
/**
 * DingDan的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'DingDan' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	