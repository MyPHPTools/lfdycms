<?php
namespace Home\Controller;

class IndexController extends HomeController {

	//系统首页
    public function index(){
    	Cookie('__forward__',$_SERVER['REQUEST_URI']);
		$this->assign('pos',4);
        $this->display(".".$this->tplpath."/index.html");
    }
}