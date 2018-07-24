<?php

namespace Addons\cjccxx\Controller;
use Home\Controller\AddonsController;

class cjccxxController extends AddonsController{
    var $model;
    function _initialize() {
        $this->model = $this->getModel ( 'dingdan' );
        parent::_initialize ();
    }
    // 通用插件的列表模型
    public function lists() {
		echo 'dfasfds';exit;
        $map ['token'] = get_token ();
        $list_data = $this->_get_model_list ( $this->model );
        $this->assign ( $list_data );
        $templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
        $this->display ( $templateFile );
    }
}
