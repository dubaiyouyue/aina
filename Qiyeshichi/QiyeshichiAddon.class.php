<?php

namespace Addons\Qiyeshichi;
use Common\Controller\Addon;

/**
 * 企业试吃插件
 * @author 共振
 */

    class QiyeshichiAddon extends Addon{

        public $info = array(
            'name'=>'Qiyeshichi',
            'title'=>'企业试吃',
            'description'=>'企业试吃报名活动表。',
            'status'=>1,
            'author'=>'共振',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Qiyeshichi/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Qiyeshichi/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }