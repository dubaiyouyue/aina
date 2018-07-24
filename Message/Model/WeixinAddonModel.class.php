<?php
        	
namespace Addons\Message\Model;
use Home\Model\WeixinModel;
        	
/**
 * Message的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Message' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	