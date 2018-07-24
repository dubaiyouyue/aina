<?php
        	
namespace Addons\LuckDraw\Model;
use Home\Model\WeixinModel;
        	
/**
 * LuckDraw的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'LuckDraw' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	