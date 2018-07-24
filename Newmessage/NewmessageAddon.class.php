<?php

namespace Addons\Newmessage;
use Common\Controller\Addon;

/**
 * 艾娜建议留言插件
 * @author 南宁共振设计
 */

    class NewmessageAddon extends Addon{

        public $info = array(
            'name'=>'Newmessage',
            'title'=>'艾娜建议留言',
            'description'=>'艾娜微官网建议留言。',
            'status'=>1,
            'author'=>'南宁共振设计',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Newmessage/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Newmessage/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }