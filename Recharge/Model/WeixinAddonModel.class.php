<?php
        	
namespace Addons\Recharge\Model;
use Home\Model\WeixinModel;
        	
/**
 * Recharge的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Recharge' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	