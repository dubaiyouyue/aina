<?php

namespace Addons\Huiyuan;
use Common\Controller\Addon;

/**
 * 会员插件
 * @author 无名
 */

    class HuiyuanAddon extends Addon{
		//public $custom_config = 'config.html';
        public $info = array(
            'name'=>'Huiyuan',
            'title'=>'会员',
            'description'=>'网站注册会员。',
            'status'=>1,
            'author'=>'南宁共振设计',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Huiyuan/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Huiyuan/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }