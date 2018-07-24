<?php
        	
namespace Addons\Zffbcopy\Model;
use Home\Model\WeixinModel;
        	
/**
 * Zffbcopy的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Zffbcopy' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	