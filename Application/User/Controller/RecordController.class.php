<?php
namespace User\Controller;
use Think\Controller;

class RecordController extends UserController {
    public function index(){
		$recordMov=recordArray(UID);
		$this->assign('mov',$recordMov);
		$this->display();
    }
	
	public function remove(){
		if(isset($_GET['id'])){
			$recordMov=M('PlayerLog')->where('uid='.UID)->getField('log');
			$recordMov=json_decode($recordMov,true);
			foreach($recordMov as $key=>$value){
				if ($value['id'] == I('get.id')){
					unset($recordMov[$key]);
					break;
				}
			}
			if(count($recordMov)==0){
				$recordMovCookie="";
			}
			$recordMovCookie=array_slice($recordMov, 0, 10);
			cookie('movHistory',json_encode($recordMovCookie));
			$recordMov=json_encode($recordMov);
			M('PlayerLog')->where('uid='.UID)->setField('log',$recordMov);
			$this->success('清除成功！');
		}else{
			M('PlayerLog')->where('uid='.UID)->setField('log','');
			cookie('movHistory',null);
			$this->success('清除成功！');
		}
	}
	
	public function add($data){
		$data=json_decode(stripslashes($data),true);
		$recordMov=M('PlayerLog')->where('uid='.UID)->getField('log');
		$recordMov=json_decode($recordMov,true);
		foreach($recordMov as $key=>$value){
			if ($value['id'] == $data['id']){
				unset($recordMov[$key]);
				break;
			}
		}
		if(is_array($recordMov)){
			array_unshift($recordMov,$data);
		}else{
			$recordMov[]=$data;
		}
		$recordMov=json_encode($recordMov);
		M('PlayerLog')->where('uid='.UID)->setField('log',$recordMov);
		$this->success('添加成功！');
	}
}