<?php

namespace Addons\Runcodee;
use Common\Controller\Addon;

/**
 * 运行记录插件
 * @author 无名
 */

    class RuncodeeAddon extends Addon{

        public $info = array(
            'name'=>'Runcodee',
            'title'=>'运行记录',
            'description'=>'记录所有运行记录操作副本。',
            'status'=>1,
            'author'=>'无名',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Runcodee/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Runcodee/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }