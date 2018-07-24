<?php

namespace Addons\ChouJiangH;
use Common\Controller\Addon;

/**
 * 抽奖活动插件
 * @author 南宁共振设计
 */

    class ChouJiangHAddon extends Addon{

        public $info = array(
            'name'=>'ChouJiangH',
            'title'=>'抽奖活动',
            'description'=>'抽奖活动。',
            'status'=>1,
            'author'=>'南宁共振设计',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/ChouJiangH/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/ChouJiangH/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }