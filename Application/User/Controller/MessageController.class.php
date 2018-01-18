<?php
namespace User\Controller;
use Think\Controller;

class MessageController extends UserController {
    public function index(){
		$map['to_uid']=UID;
		$map['status']=1;
		if(isset($_GET['type'])){
			$map['type']=I('get.type');
		}
		$list = $this->lists('Message', $map ,'is_read asc,id desc',10);
		foreach($list as $key=>$value){
			$list[$key]=D('Message')->user_info($value);
		}
		$this->assign('message',$list);
		$this->type=I('get.type');
		$this->display();
    }
	
	public function detail(){
		$list=D('Message')->info(I('id'));
		$this->assign('message',$list);
		$this->display();
	}
	
	public function add(){
        if(IS_POST){
            $rs = D('Message')->send();
            if($rs){
                $this->success('信息发送成功！');
            } else {
                $this->error(D('Message')->getError());
            }
        } else {
			if($_GET['uid']){
				$this->username=get_user_name(I('get.uid'));
				$this->type=1;
			}
            $this->display();
        }
    }
	
	/**
     * 删除消息
     */
    public function del(){
        if(IS_GET){
        	$map['id'] = I('get.id');
        	if(M('Message')->where($map)->delete()){
				//记录行为
	        	action_log('del_message','message','',UID);	
	            $this->success('清除成功',U('index'));
	        } else {
	            $this->error('无清除内容！');
	        }
        }
    }
	
	public function message(){
		$map['to_uid']=UID;
		$map['status']=1;
		$list = M('Message')->where($map)->order('is_read asc')->limit(5)->select();
		$map['is_read']=0;
		$count = M('Message')->where($map)->count();
		foreach($list as $key=>$value){
			$list[$key]=D('Message')->user_info($value);
			$list[$key]['time']=tmspan($value['create_time']);
			$list[$key]['url']=U('Message/detail?id='.$value['id']);
		}
		$msg=array('list'=>$list,'count'=>$count);
		$this->ajaxReturn($msg);
	}
}