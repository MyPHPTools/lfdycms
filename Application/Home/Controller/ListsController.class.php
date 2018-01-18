<?php
namespace Home\Controller;
class ListsController extends HomeController{
    public function index(){
		$id=I('id');
		$info=D("Category")->info($id);		
		$this->cid=intval($info["id"]);
		$this->pid=$info["pid"];
		$this->ctitle=$info["title"];
		$this->cname=$info["name"];
		$this->list_webtitle=empty($info["meta_title"]) ? C("WEB_SITE_TITLE") : $info["meta_title"];
		$this->list_keywords=empty($info["keywords"]) ? C("WEB_SITE_KEYWORD") : $info["keywords"];
		$this->list_description=empty($info["description"]) ? C("WEB_SITE_DESCRIPTION") :$info["description"];
		if($info["pid"]>0){
			$this->assign('pos',1);
		}else{
			$this->assign('pos',2);
		}
		$tpl=D("Category")->getTpl($id,'template_index');
		if(!$tpl){
			$error = D("Category")->getError();
        	$this->error(empty($error) ? '未知错误！' : $error);
		}
		if($info["type"]==1){
			$this->count=D('Tag')->listCount($id);
		}else{
			$this->count=D('Tag')->newsCount($id);
		}
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display(".".$this->tplpath."/".$tpl);
    }
	
	 public function lists(){
	 	define("RUN_MODE", 1);
		$id=I('id');
		$info=D("Category")->info($id);		
		$this->cid=intval($info["id"]);
		$this->pid=$info["pid"];
		$this->ctitle=$info["title"];
		$this->cname=$info["name"];
		$this->cyear=I('year');
		$this->carea=I("area");
		$this->clanguage=I("language");
		$this->order=I("order");
		$this->model="lists";
		$this->list_webtitle=empty($info["meta_title"]) ? C("WEB_SITE_TITLE") : $info["meta_title"];
		$this->list_keywords=empty($info["keywords"]) ? C("WEB_SITE_KEYWORD") : $info["keywords"];
		$this->list_description=empty($info["description"]) ? C("WEB_SITE_DESCRIPTION") :$info["description"];
		$tpl=D("Category")->getTpl($id,'template_type');
		if(!$tpl){
			$tpl='lists.html';
		}
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
		$this->count=D('Tag')->listCount($id);
        $this->display(".".$this->tplpath."/".$tpl);
    }
}