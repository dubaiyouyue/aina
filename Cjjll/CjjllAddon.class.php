<?php

namespace Addons\Cjjll;
use Common\Controller\Addon;

/**
 * 抽奖记录插件
 * @author 南宁共振设计
 */

    class CjjllAddon extends Addon{

        public $info = array(
            'name'=>'Cjjll',
            'title'=>'抽奖记录',
            'description'=>'抽奖记录。会员奖品兑换，请输入兑换码查询奖品是否存在以及是否已经被兑换领取。',
            'status'=>1,
            'author'=>'南宁共振设计',
            'version'=>'0.1',
            'has_adminlist'=>1
        );

	public function install() {
		$install_sql = './Addons/Cjjll/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Cjjll/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }