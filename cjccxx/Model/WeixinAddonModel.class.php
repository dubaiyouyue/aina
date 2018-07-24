<?php
        	
namespace Addons\cjccxx\Model;
use Home\Model\WeixinModel;
        	
/**
 * cjccxx的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'cjccxx' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	