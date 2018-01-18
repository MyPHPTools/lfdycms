<?php
namespace User\Controller;
use Think\Controller;

class PrizeController extends UserController {
    public function index(){
		$map['status']=1;
		$list = $this->lists('Prize', $map ,'id desc',16);
		$list = D('Prize')->pchange($list);
		$top = D('prize')->top();
		$this->assign('prize',$list);
		$this->assign('top',$top);
		$this->display();
    }
	
	public function detail(){
		$map['status']=1;
		$top = D('prize')->top();
		$prize = D('Prize')->info(I('id'));
		$this->assign('prize',$prize);
		$this->assign('top',$top);
		$this->display();
    }
	
	public function exchange(){
		$Prize = D('Prize');
		if(IS_POST){
            if(false !== $Prize->exchange()){
                $this->success('兑换成功，请等待发货！', U('Prize/index'));
            } else {
                $error = $Prize->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
			$this->assign('pid',I('id'));
			$this->assign('ptitle',D('Prize')->gettitle(I('id')));
			$this->display();
		}
	}
	
	public function exchangegift(){
		$map['status']=1;
		$map['uid']=UID;
		$list = $this->lists('exchange', $map ,'id desc',15);
		$this->assign('exchange',$list);
		$this->display();
	}
}