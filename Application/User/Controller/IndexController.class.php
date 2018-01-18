<?php
namespace User\Controller;
use Think\Controller;

class IndexController extends UserController {
    public function index(){
		$info=D('Users')->newLogin();
		$prize=D('Prize')->lists();
		$map=array('to_uid'=>UID,'status'=>1,'is_read'=>0);
		$msg_count = M('Message')->where($map)->count();
		$this->assign('msg_count',$msg_count);
		$this->assign('u_l_list',$info);
		$this->assign('prize',$prize);
		$this->display();
    }
}