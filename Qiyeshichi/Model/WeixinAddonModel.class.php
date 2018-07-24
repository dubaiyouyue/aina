<?php
        	
namespace Addons\Qiyeshichi\Model;
use Home\Model\WeixinModel;
        	
/**
 * Qiyeshichi的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Qiyeshichi' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	