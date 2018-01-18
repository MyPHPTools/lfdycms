<?php
namespace Home\Controller;
class NewsController extends HomeController {
    public function index(){
		$id=I('id');
		$info=D("News")->detail($id);
		if(!$info){
			$error = D("News")->getError();
        	$this->error(empty($error) ? '未知错误！' : $error);
		}
		$info=D("Tag")->movieChange($info,'news',1);
		$tpl=D("Category")->getTpl($info['cid'],'template_detail');
		if(!$tpl){
			$error = D("Category")->getError();
        	$this->error(empty($error) ? '未知错误！' : $error);
		}
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
		$this->assign('pos',1);
		$this->assign($info);
        $this->display(".".$this->tplpath."/".$tpl);
    }

	public function hist(){
		$this->ajaxReturn(D('News')->hits(I('id')));
	}
	
	public function digg(){
		if(!cookie('news_digg'.I('id'))){
			cookie('news_digg'.I('id'),true);
			$this->ajaxReturn(D('News')->digg(I('id')));
		}else{
			$this->ajaxReturn(array('error'=>'已经点过了'));
		}
	}
}