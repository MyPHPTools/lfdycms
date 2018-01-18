<?php
namespace Admin\Controller;

/**
 * 后台配置控制器
 */
class CardController extends AdminController {
	
    public function index(){
        $this->meta_title = '充值卡管理';
        $this->display();
    }
}
