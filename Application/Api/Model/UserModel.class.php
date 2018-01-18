<?php
namespace Api\Model;
use Think\Model;

class UserModel extends Model {
	public function deleteuser($uid,$wid){
		$map=array('');
		M('User')->where($map)->delete();
	}
}