<?php

namespace Addons\Shouhuodizi;
use Common\Controller\Addon;

/**
 * 收货地址插件
 * @author 南宁共振设计
 */

    class ShouhuodiziAddon extends Addon{

        public $info = array(
            'name'=>'Shouhuodizi',
            'title'=>'收货地址',
            'description'=>'会员收货地址管理',
            'status'=>1,
            'author'=>'南宁共振设计',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Shouhuodizi/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Shouhuodizi/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }