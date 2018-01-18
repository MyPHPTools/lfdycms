<?php
namespace Home\Controller;
class SearchController extends HomeController {
    public function index(){
		$this->keyword=I('keyword');
		$this->count=D('Tag')->searchCount();
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display(".".$this->tplpath."/search.html");
    }
}