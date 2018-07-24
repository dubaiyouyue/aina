<?php

namespace Addons\dingdancopy;
use Common\Controller\Addon;

/**
 * 订单副本插件
 * @author 无名
 */

    class dingdancopyAddon extends Addon{

        public $info = array(
            'name'=>'dingdancopy',
            'title'=>'订单副本',
            'description'=>'记录所有产生的订单副本。',
            'status'=>1,
            'author'=>'无名',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/dingdancopy/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/dingdancopy/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }