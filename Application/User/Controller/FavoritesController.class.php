<?php
namespace User\Controller;
use Think\Controller;

class FavoritesController extends UserController {
    public function index(){
		$map['uid']=UID;
		if(I('type')!=null){
			$map['type']=I('type');
		}else{
			$map['type']=0;
		}
		$list = $this->lists('Favorites', $map ,'id desc',24,'');
		$list = D('Favorites')->change($list);
		$this->assign('list',$list);
		$this->assign('type',I('type'));
		$this->display();
    }

    public function remove(){
        $map['id'] = I('get.id');
        if(M('Favorites')->where($map)->delete()){
        	M('movie')->where(array('id'=>I('get.id')))->setDec('favorites_count');
            $this->success('清除成功',U('index'));
        } else {
            $this->error('无清除内容！');
        }
    }

    public function login(){
    	if(!D('Users')->favorites_verifyUser(UID,I('post.favorites_password'))){
			$this->error('验证出错：密码不正确！');
		}
        session('favorites', true);
        $this->success('开启成功');
    }

    public function logout(){
        session('favorites', null);
        $this->success('关闭成功');
    }

    public function add($id){
    	$category=M('Movie')->where(array('id'=>$id))->getField('category');
		if(D('Favorites')->add($id,$category)){
			$return['code']= 1;
			$return['msg']= '收藏成功！';
		}else{
			$return['code']= 0;
			$return['msg']= '参数错误！';
		}
		$this->ajaxReturn($return);
	}
}