<?php
namespace User\Controller;
use Think\Controller;
use Think\Storage;
/**
 * 用户首页控制器
 */
class UsersController extends UserController {

    public function profile($id = null){
        $Users = D('Users');
        if(IS_POST){
            if(false !== $Users->update()){
                $this->success('修改成功！', U('profile'));
            } else {
                $error = $Users->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $this->display();
        }
    }

    public function uploadPicture(){
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        $Picture = D('Picture');
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        );
        if($info){
            $return['status'] = 1;
            $return = array_merge($info['download'], $return);
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }
        $this->ajaxReturn($return);
    }
	
	public function cropImg($crop){
		$return  = array('status' => 1, 'info' => '头像保存成功', 'path' => '');
		if(!isset($crop) && empty($crop)){
			$return['status']= 0;
			$return['info']= '参数错误！';
		}
		$Picture = D('Picture');
		$info = $Picture->cropImg($crop);
		$return['path'] = $info;
		$this->ajaxReturn($return);
	}

	public function Password(){
        $res   =  D('Users')->Password();
		if($res  !== false){
            $this->success('修改密码成功！',U('profile'));
        }else{
			$this->error(D('Users')->getError());
        }
    }

    public function favorites_add_password(){
    	$res   =  D('Users')->favorites_add_password();
		if($res  !== false){
			$url=cookie('__forward__')?cookie('__forward__'):U('index');
			cookie('__forward__',null);
            $this->success('设置收藏夹密码成功！',$url);
        }else{
			$this->error(D('Users')->getError());
        }
    }
	
	public function favorites_password(){
        $res   =  D('Users')->favorites_password();
		if($res  !== false){
            $this->success('修改收藏夹密码成功！',U('profile'));
        }else{
			$this->error(D('Users')->getError());
        }
    }
	
	public function info($id){
		$recordMov=recordArray($id);
		$this->assign('mov',$recordMov);
		$info=D('Users')->info($id);
		$this->assign('user',$info);
		$this->display();
	}
	
	public function follow(){
		if(D('Follow')->follow(UID,I('uid'))){
			$return['status']= 1;
			$return['info']= '关注成功！';
			$return['follow']= 1;
		}else{
			$return['status']= 0;
			$return['info']= '参数错误！';
		}
		$this->ajaxReturn($return);
	}
	
	public function followDel(){
		if(D('Follow')->del(UID,I('get.uid'))){
			$return['status']= 1;
			$return['info']= '取消关注！';
			$return['follow']= 0;
		}else{
			$return['status']= 0;
			$return['info']= '参数错误！';
		}
		$this->ajaxReturn($return);
	}
	
	public function user(){
		if(isset($_POST['keyword'])){
            $where['username']  = array('like', '%'.I('keyword').'%');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
        }
		if($_GET['state']=='follow'){
			$id=D('Users')->followId(I('id'));
			$map['id'] = array('in', $id);
        }elseif($_GET['state']=='fans'){
			$id=D('Users')->fansId(I('id'));
			$map['id'] = array('in', $id);
        }
		$map['status']=1;
		$map['id']=array('neq',UID);
		$list = $this->lists('Users', $map ,'id desc',15);
		foreach($list as $key=>$value){
			$list[$key]['follow']=D('Follow')->followCount($value['id']);
			$list[$key]['fans']=D('Follow')->fansCount($value['id']);
			$list[$key]['cfollow']=D('Follow')->checkFollow($value['id']);
		}
		$this->assign('user',$list);
		$this->display();
	}
}
