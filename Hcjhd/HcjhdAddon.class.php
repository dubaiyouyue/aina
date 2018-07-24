<?php

namespace Addons\Hcjhd;
use Common\Controller\Addon;

/**
 * 会员抽奖活动插件
 * @author 共振
 */

    class HcjhdAddon extends Addon{

        public $info = array(
            'name'=>'Hcjhd',
            'title'=>'会员抽奖活动',
            'description'=>'会员抽奖活动。',
            'status'=>1,
            'author'=>'共振',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Hcjhd/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Hcjhd/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }