<?php
        	
namespace Addons\Cjjll\Model;
use Home\Model\WeixinModel;
        	
/**
 * Cjjll的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Cjjll' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	