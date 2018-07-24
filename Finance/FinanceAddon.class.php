<?php

namespace Addons\Finance;
use Common\Controller\Addon;

/**
 * 财务明细插件
 * @author 南宁共振设计
 */

    class FinanceAddon extends Addon{

        public $info = array(
            'name'=>'Finance',
            'title'=>'财务明细',
            'description'=>'财务明细报表。',
            'status'=>1,
            'author'=>'南宁共振设计',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Finance/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Finance/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }