<?php
namespace Home\Controller;
class OtherController extends HomeController {
    public function index(){
		$tpl=I('tpl').".html";
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display(".".$this->tplpath."/".$tpl);
    }
}