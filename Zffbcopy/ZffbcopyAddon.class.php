<?php

namespace Addons\Zffbcopy;
use Common\Controller\Addon;

/**
 * 支付副本插件
 * @author 无名
 */

    class ZffbcopyAddon extends Addon{

        public $info = array(
            'name'=>'Zffbcopy',
            'title'=>'支付副本',
            'description'=>'记录支付记录副本。',
            'status'=>1,
            'author'=>'无名',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Zffbcopy/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Zffbcopy/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }