<?php
namespace Admin\Model;
use Think\Model;

class UsersModel extends Model{

	/* 用户模型自动验证 */
	protected $_validate = array(
		/* 验证用户名 */
		array('username', '1,30', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
		array('username', '', -2, self::EXISTS_VALIDATE, 'unique'), //用户名被占用
		array('email', '', -4, self::EXISTS_VALIDATE, 'unique'), //用户名被占用
		array('email', 'email', -5, self::EXISTS_VALIDATE, 'regex'),

		/* 验证密码 */
		array('password', '6,30', -3, self::EXISTS_VALIDATE, 'length'), //密码长度不合法
	);

	/* 用户模型自动完成 */
	protected $_auto = array(
		array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function'),
		array('reg_time', NOW_TIME, self::MODEL_INSERT),
		array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
		array('status', '1', self::MODEL_INSERT),
	);
	
	/**
	 * 注册一个新用户
	 * @param  string $username 用户名
	 * @param  string $password 用户密码
	 */
	public function register(){
		/* 添加用户 */
		if($data=$this->create()){
			$uid = $this->add($data);
			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		} else {
			return M('Users')->getError(); //错误详情见自动验证注释
		}
	}
	
	/**
	 * 更新用户信息
	 * @param int $uid 用户id
	 * @param string $password 密码，用来验证
	 * @param array $data 修改的字段数组
	 * @return true 修改成功，false 修改失败
	 */
	public function updateUser($uid, $data){
		if(empty($uid) || empty($data)){
			$this->error = '参数错误！';
			return false;
		}
		//更新用户信息
		$data = $this->create($data);
		if($data){
			return M('Users')->where(array('id'=>$uid))->save($data);
		}
		return false;
	}
}