<?php
        	
namespace Addons\Hcjhd\Model;
use Home\Model\WeixinModel;
        	
/**
 * Hcjhd的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Hcjhd' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	