<?php
namespace User\Model;
use Think\Model;

class FollowModel extends Model {
	
	public function follow($uid,$fid){
		$data['uid']=$uid;
		$data['fid']=$fid;
		$data['ctime']=NOW_TIME;
		M('users_follow')->create($data);
		return M('users_follow')->add();
	}
	
	public function del($uid,$fid){
		$map['uid']=array('eq',$uid);
		$map['fid']=array('eq',$fid);
		return M('users_follow')->where($map)->delete();
	}
	
	public function followCount($uid){
		$map['uid']=array('eq',$uid);
		return M('users_follow')->where($map)->count();
	}
	
	public function fansCount($uid){
		$map['fid']=array('eq',$uid);
		return M('users_follow')->where($map)->count();
	}
	
	public function checkFollow($uid){
		$map['fid']=array('eq',$uid);
		$map['uid']=array('eq',UID);
		if(M('users_follow')->where($map)->find()){
			return "true";
		}else{
			return "false";
		};
	
	}
}