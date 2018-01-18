<?php
namespace Home\Controller;
class ApiController extends HomeController {
	// api数据共享
    public function index(){
		$data=D('Api')->listMovie();
        $this->ajaxReturn($data);
    }

    public function favorite($type=0,$page=1,$limit=10){
    	$list=M('Favorites')->where(array('uid'=>UID,'type'=>$type))->page($page)->limit($limit)->select();
    	$data=D('User/Favorites')->change($list);
    	$this->ajaxReturn($data);
    }

}