<?php
namespace Admin\Model;
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

		/* 获取用户数据 */
		$user = M("Member")->where($map)->find();
		if(is_array($user)){
			/* 验证用户密码 */
			if(think_ucenter_md5($password) === $user['password']){
				$this->autoLogin($user); //更新用户登录信息
				//记录行为
        		action_log('admin_login','member',$user['id'],$user['id']);
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
    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'id'             => $user['id'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(1),
        );
        M("Member")->save($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
            'last_login_time' => $user['last_login_time'],
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

    }
	 /**
     * 注销当前用户
     * @return void
     */
	public function logout(){
		//记录行为
		$uid=is_login();
        action_log('admin_logout','member',$uid,$uid);
        session('user_auth', null);
        session('user_auth_sign', null);
    }
}