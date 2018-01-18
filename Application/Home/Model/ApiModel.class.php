<?php
namespace Home\Model;
use Think\Model;

class ApiModel extends Model{

	public function type($id=0){
		$map["status"] = 1;
		$map["display"] = 1;
		$map['pid']=$id;
		$map['appno']=1;
		$data=M("Category")->field('id,title,icon')->where($map)->order('sort')->select();
		return $data;
	}

	protected function player(){
		$map["display"] = 1;
		return M("Player")->field('id,title,adon,player_code,player_ad,vip')->where($map)->order('sort')->select();
	}
}
