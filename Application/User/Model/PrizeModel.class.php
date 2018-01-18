<?php
namespace User\Model;
use Think\Model;

class PrizeModel extends Model {

	protected $_validate = array(
		array('name', 'require', '请输入收货人！'),
		array('tel', 'require', '请输入联系电话！'),
		array('qq', 'require', '请输入QQ！'),
	);

	public function info($id){
		$map['status']=1;
		$map['id']=$id;
		$info=$this->where($map)->find();
		return $this->change($info);
	}
	
	public function lists(){
		$map['status']=1;
		$lists=$this->where($map)->select();
		$plist=$this->pchange($lists);
		return $plist;
	}
	
	public function top(){
		$map['status']=1;
		$lists=$this->where($map)->order('number desc')->limit(10)->select();
		$plist=$this->pchange($lists);
		return $plist;
	}
	
	public function pchange($data){
		foreach ($data as $k=>$v){
			$mlist[]=$this->change($v);
		}
		return $mlist;
	}
	
	private function change($data){
		$data["pic"]=get_cover($data["cover_id"],"path");
		unset($data["display"],$data["cover_id"],$data["update_time"]);
		return $data;
	}
	
	public function gettitle($id){
		$map['status']=1;
		$map['id']=$id;
		$info=$this->where($map)->getField('title');
		return $info;
	}
	
	public function getIntegral($id){
		$map['status']=1;
		$map['id']=$id;
		return $this->where($map)->getField('integral');
	}
	
	public function exchange(){
		$Users=D('Users');
		if(!$data = M('exchange')->create()){
            return false;
        }
		$integral=$this->getIntegral($data['pid']);
		if(!$Users->decIntegral(UID,$integral)){
             $this->error = $Users->getError();
			 return false;
        }
        $data['uid']=UID;
		$data['usersname']=$Users->getName(UID);
		$data['integral']=$integral;
		$data['create_time']=NOW_TIME;
        return M('exchange')->add($data);
	}
}