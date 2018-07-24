<?php
        	
namespace Addons\DdCopy\Model;
use Home\Model\WeixinModel;
        	
/**
 * DdCopy的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'DdCopy' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	