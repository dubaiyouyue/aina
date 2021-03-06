<?php

namespace Addons\Message;
use Common\Controller\Addon;

/**
 * 建议留言插件
 * @author 南宁共振设计
 */

    class MessageAddon extends Addon{

        public $info = array(
            'name'=>'Message',
            'title'=>'建议留言',
            'description'=>'建议留言。',
            'status'=>1,
            'author'=>'南宁共振设计',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Message/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Message/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }