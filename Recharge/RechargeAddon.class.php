<?php

namespace Addons\Recharge;
use Common\Controller\Addon;

/**
 * 会员余额插件
 * @author 无名
 */

    class RechargeAddon extends Addon{

        public $info = array(
            'name'=>'Recharge',
            'title'=>'会员余额',
            'description'=>'网站会员充值余额查看查询管理。',
            'status'=>1,
            'author'=>'无名',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Recharge/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Recharge/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }