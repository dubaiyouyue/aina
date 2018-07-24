<?php
        	
namespace Addons\choujiang\Model;
use Home\Model\WeixinModel;
        	
/**
 * choujiang的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'choujiang' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	