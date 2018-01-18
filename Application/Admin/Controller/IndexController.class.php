<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends AdminController {
    public function index(){
         if(UID){
            $this->meta_title = '管理首页';
			$info['movie']	=	M('movie')->count();
            $info['news']		=	M('news')->count();
			$info['users']		=	M('users')->count();
            $info['comment']      =   M('comment')->count();
            $this->assign('info',$info);
            $this->display();
        } else {
            $this->redirect('Public/login');
        }
    }
		
	public function cache(){
        if(IS_POST){
			dropDir(TEMP_PATH);
			dropDir(CACHE_PATH);
            $this->success('缓存清除成功！');
        } else {
			$this->meta_title = '清除缓存';
			$this->display();
        }
    }
}