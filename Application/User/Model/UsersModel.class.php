<?php
namespace User\Model;
use Think\Model;

class UsersModel extends Model {

	protected $_validate = array(
		/* 验证用户名 */
		array('username', '4,30', '用户名长度必须在4-30个字符之间！', self::EXISTS_VALIDATE, 'length',self::MODEL_INSERT), //用户名长度不合法
		array('username', '', '用户名被占用', self::EXISTS_VALIDATE, 'unique',self::MODEL_INSERT), //用户名被占用
		/* 验证密码 */
		array('oldpassword', 'require', '请输入原密码！', self::EXISTS_VALIDATE, 'regex',self::MODEL_UPDATE),
		array('password', '6,30', '密码长度必须在6-30个字符之间！', self::EXISTS_VALIDATE, 'length'),
		/* 验证邮箱 */
		array('email', 'email', '邮箱格式不正确！', self::EXISTS_VALIDATE, 'regex'), //邮箱格式不正确
		array('email', '1,32', '邮箱长度必须在32个字符以内！', self::EXISTS_VALIDATE, 'length'), //邮箱长度不合法
	);

	/* 用户模型自动完成 */
	protected $_auto = array(
		array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function'),
		array('reg_time', NOW_TIME, self::MODEL_INSERT),
		array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
		array('birthday', 'getBirthdayTime', self::MODEL_UPDATE,'callback'),
		array('update_time', NOW_TIME, self::MODEL_UPDATE),
		array('status', 'getStatus', self::MODEL_INSERT, 'callback'),
	);

	/*
	 * 获取用户信息
	 * @param  string  $uid         用户ID或用户名
	 * @param  boolean $is_username 是否使用用户名查询
	 * @return array                用户信息
	 */
	public function info($uid){
		$map['id'] = $uid;
		$map['status']=1;
		$info=$this->where($map)->field('id,username,email,path,last_login_time,last_login_ip,login,introduction,integral,gender,sign,favorites_password,vip_time')->find();
		$info['follow']=D('User/Follow')->followCount($uid);
		$info['fans']=D('User/Follow')->fansCount($uid);
		$info['cfollow']=D('User/Follow')->checkFollow($uid);
		return $info;
	}
	
	 public function update(){
        if(!$data = $this->create()){
            return false;
        }
        $data['id']=UID;
		unset($data['password']);
        $res = $this->save($data);
        return $res;
    }
	
	public function Password(){
		if(!$data = $this->create()){
            return false;
        }
		if(I('post.password') !== I('post.repassword')){
            $this->error = '您输入的新密码与确认密码不一致！';
			return false;
        }
		$ucReturn=A('Api/UserApi')->User_edit(UID,I('post.oldpassword'),I('post.password'));
		if($ucReturn==-1){
			$this->error = '验证出错：密码不正确！';
			return false;
		}
        $this->id=UID;
        $res = $this->save();
        return $res;
    }

    public function favorites_add_password(){
		if(I('post.favorites_repassword') !== I('post.favorites_password')){
            $this->error = '您输入的新密码与确认密码不一致！';
			return false;
        }
        $res = $this->where(array('id'=>UID))->setField('favorites_password',think_ucenter_md5(I('post.favorites_password')));
        return $res;
    }

    public function favorites_password(){
		if(I('post.favorites_repassword') !== I('post.favorites_password')){
            $this->error = '您输入的新密码与确认密码不一致！';
			return false;
        }
		if(!$this->favorites_verifyUser(UID, I('post.favorites_oldpassword'))){
			$this->error = '验证出错：密码不正确！';
			return false;
		}
        $res = $this->where(array('id'=>UID))->setField('favorites_password',think_ucenter_md5(I('post.favorites_password')));
        return $res;
    }
	
	public function newLogin(){
		$map['id']=array('neq',UID);
		$map['status']=1;
		return $this->where($map)->field('id,username,path,last_login_time,introduction,integral,gender')->order('last_login_time')->limit(10)->select();
	}
	
	public function getName($id){
		$map['id'] = $id;
		$map['status']=1;
		return $this->where($map)->getField('username');
	}
	
	public function decIntegral($id,$integral){
		$map['id']=$id;
		$U_integral = $this->where($map)->getField('integral');
		if($U_integral>=$integral){
			return $this->where($map)->setDec('integral',$integral);
		}else{
			$this->error = '对不起您的积分不够！';
			return false;
		}
	}
	
	public function followId($id){
		$map['uid']=$id;
		$info=M('users_follow')->where($map)->field('fid')->select();
		if($info){
			foreach ($info as $key=>$val){
				$ids[]=$val["fid"];
			}
		}
		return $ids;
	}
	
	public function fansId($id){
		$map['fid']=$id;
		$info=M('users_follow')->where($map)->field('uid')->select();
		if($info){
			foreach ($info as $key=>$val){
				$ids[]=$val["uid"];
			}
		}
		return $ids;
	}
	
	/**
	 * 验证用户密码
	 * @param int $uid 用户id
	 * @param string $password_in 密码
	 * @return true 验证成功，false 验证失败
	 */
	protected function verifyUser($uid, $password_in){
		$password = $this->getFieldById($uid, 'password');
		if(think_ucenter_md5($password_in) === $password){
			return true;
		}
		return false;
	}

	/**
	 * 验证用户密码
	 * @param int $uid 用户id
	 * @param string $password_in 密码
	 * @return true 验证成功，false 验证失败
	 */
	public function favorites_verifyUser($uid, $password_in){
		$password = $this->getFieldById($uid, 'favorites_password');
		if(think_ucenter_md5($password_in) === $password){
			return true;
		}
		return false;
	}
	
	/* 时间处理规则 */
	protected function getBirthdayTime(){
		$birthday_time    =   I('post.birthday');
		return $birthday_time?strtotime($birthday_time):NOW_TIME;
	}
	
		/**
	 * 根据配置指定用户状态
	 * @return integer 用户状态
	 */
	protected function getStatus(){
		return true;
	}
}