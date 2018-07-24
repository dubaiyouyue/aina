<?php
        	
namespace Addons\Runcodee\Model;
use Home\Model\WeixinModel;
        	
/**
 * Runcodee的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Runcodee' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	