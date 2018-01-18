<?php
namespace User\Model;
use Think\Model;

class PublicModel extends Model {

	/**
	 * 用户登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($username, $password){
		$map = array();
		$map['username'] = $username;
		$map['status'] = 1;
		
		/* 获取用户数据 */
		$user = M('Users')->where($map)->find();
		if(is_array($user)){
			/* 验证用户密码 */
			if(think_ucenter_md5($password) === $user['password']){
				$this->autoLogin($user); //更新用户登录信息
				$this->upPlayLog($user['id']);
				return $user['id']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}
	
	 /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    public function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'id'             => $user['id'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(1),
        );
        M("Users")->save($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
            'last_login_time' => $data['last_login_time'],
        );

        cookie('user_auth', $auth);
        cookie('user_auth_sign', data_auth_sign($auth));
    }
	 /**
     * 注销当前用户
     * @return void
     */
	public function logout(){
        cookie('user_auth', null);
        cookie('user_auth_sign', null);
    }
	
	public function reg(){
		if($data=D('Users')->create()){
			if(C('BBS_ON')){
				$ucReturn=A('Api/UserApi')->User_register($data['username'],I('post.password'),$data['email']);
				$ucError=array('-1'=>'用户名不合法','-2'=>'包含不允许注册的词语','-3'=>'用户名已经存在','-4'=>'Email 格式有误','-5'=>'Email 不允许注册','-6'=>'该 Email 已经被注册');
				if($ucReturn>0){
					$data['ucid']=$ucReturn;
				}else{
					$this->error = $ucError[$ucReturn];
					return false;
				}
			}
			if(C('USER_REG_VIP')){
				$data['vip_time']=NOW_TIME+C('USER_REG_VIP_TIME')*86400;
			}
			$return=M('Users')->add($data);
			return $return;
		} else {
			$this->error = D('Users')->getError();
			return false;
		}
	}
	
	/*
	 * 获取用户信息
	 * @param  string  $uid         用户ID或用户名
	 * @param  boolean $is_username 是否使用用户名查询
	 * @return array                用户信息
	 */
	public function info($uid){
		$map['id'] = $uid;
		return M('Users')->where($map)->find();
	}
	
	public function upPlayLog($uid){
		$data['uid'] = $uid;
		if($log = M('PlayerLog')->where('uid='.$uid)->field('id,log')->find()){
			$data['id'] = $log['id'];
			$recordMovCookie =	json_decode(stripslashes(unescape(cookie('movHistory'))),true);
			$recordMovSql = json_decode($log['log'],true);
			if($recordMovCookie && $recordMovSql){
				$recordMov = a_array_unique(array_merge($recordMovCookie,$recordMovSql));
			}else{
				$recordMov = $recordMovCookie?a_array_unique($recordMovCookie):$recordMovSql;
			}
			if($recordMov){
				cookie('movHistory',json_encode(array_slice(array_values($recordMov),0,10)),1000*3600*24*365);
				$data['log'] = json_encode($recordMov);
				M('PlayerLog')->save($data);
			}
		}else{
			$data['log'] = json_decode(stripslashes(unescape(cookie('movHistory'))),true);
			$data['log'] = json_encode($data['log']);
			M('PlayerLog')->add($data);
		}		
	} 
}