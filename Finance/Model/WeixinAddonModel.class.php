<?php
        	
namespace Addons\Finance\Model;
use Home\Model\WeixinModel;
        	
/**
 * Finance的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Finance' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	