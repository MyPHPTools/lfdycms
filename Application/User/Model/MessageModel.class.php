<?php
namespace User\Model;
use Think\Model;

class MessageModel extends Model {
	
	protected $_validate = array(
        array('title', 'require', '消息标题不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
		array('content', 'require', '消息内容不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
		array('title', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
		array('content', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('create_time', NOW_TIME, self::MODEL_BOTH),
		array('is_read', 0, self::MODEL_BOTH, 'string'),
		array('status', 1, self::MODEL_BOTH, 'string'),
    );
	
	public function user_info($list){
		if($list['uid']==0){
			$list['userpath']=__ROOT__ . '/Public/User/'.MOBILE.'/images/envelope.png';
			$list['username']='管理员';
			$list['useremail']='aming@admin.com';
			$list['userintegral']=0;
			$list['userintroduction']='系统管理员';
			$list['userlast_login_time']=NOW_TIME;
			$list['userfollow']=0;
			$list['userfans']=0;
			$list['usercfollow']=1;
		}else{
			$users=D('User/Users')->info($list['uid']);
			$list['userpath']=$users['path'];
			$list['username']=$users['username'];
			$list['useremail']=$users['email'];
			$list['userintegral']=$users['integral'];
			$list['userintroduction']=$users['introduction'];
			$list['userlast_login_time']=$users['last_login_time'];
			$list['userfollow']=$users['follow'];
			$list['userfans']=$users['fans'];
			$list['usercfollow']=$users['cfollow'];
		}
		return $list;
	}
	
	public function info($id){
		$map['status']=1;
		$map['id']=$id;
		$this->where($map)->setField('is_read',1);
		$info=$this->where($map)->find();
		return $this->user_info($info);
	}
	
	public function send(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }
		$data['uid']=UID;
		$map['username']=I("post.username");
		if(empty($map['username'])){
			$this->error = '请输入要接收消息的用户名！';
			return false;
		}
		$uid=M('users')->where($map)->field('id')->find();
		$data['to_uid']=$uid['id'];
		$data['type']=1;
		if(empty($data['to_uid'])){
			$this->error = '对不没有找到该用户！';
			return false;
		}
        return $this->add($data);
    }
}