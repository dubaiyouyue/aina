<?php
        	
namespace Addons\Shouhuodizi\Model;
use Home\Model\WeixinModel;
        	
/**
 * Shouhuodizi的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Shouhuodizi' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	