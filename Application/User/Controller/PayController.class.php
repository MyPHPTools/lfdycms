<?php
namespace User\Controller;
use Think\Controller;

class PayController extends UserController{
    public function log(){
    	$map['status']=1;
    	$map['uid']=UID;
		$list = $this->lists('PayLog', $map ,'id desc',15);
		$this->assign('_list',$list);
		$this->display();
    }

    public function card(){
    	if(IS_POST){
    		$time=M('Card')->where(array('key'=>strtoupper(I('post.key')),'type'=>0,'status'=>1))->getField('time');
    		if($time){
                if($this->vip_time>=NOW_TIME){
                    M('Users')->where(array('id'=>UID,'status'=>1))->setInc('vip_time',$time*86400);
                }else{
                    M('Users')->where(array('id'=>UID,'status'=>1))->setField('vip_time',NOW_TIME+$time*86400);
                }
    			M('Card')->where(array('key'=>strtoupper(I('post.key'))))->save(array('type'=>1,'uid'=>UID,'update_time'=>NOW_TIME));
    			$data['type']=3;
    			$data['uid']=UID;
    			$data['remark']='成功充值'.$time.'天';
    			$data['create_time']=NOW_TIME;
    			M('PayLog')->add($data);
    			$this->success('充值成功！', U('log'));
    		}else{
    			$this->error('充值卡KEY错误或已经使用！');
    		}
    	}else{
    		$this->display();
    	}
    }
}