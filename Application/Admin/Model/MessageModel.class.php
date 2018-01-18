<?php
namespace Admin\Model;
use Think\Model;

class MessageModel extends Model{

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

    public function send(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }
		$data['uid']=0;
        if($data['type']!=1){
			$list = M('Users')->where('status=1')->field('id')->select();
			foreach ($list as $v){
				$data['to_uid']=$v['id'];
				$rs = $this->add($data);
			}
        }else{
			$map['username']=I("post.username");
			if(empty($map['username'])){
				$this->error = '请输入要接收消息的用户名！';
				return false;
			}
			$uid=M('users')->where($map)->field('id')->find();
			$data['to_uid']=$uid['id'];
			if(empty($data['to_uid'])){
				$this->error = '对不没有找到该用户！';
				return false;
			}
			$rs = $this->add($data);
		}
		//记录行为
		action_log('add_message','prize',$data['type'],UID);
        return $rs;
    }

    public function system_send($to_uid,$title,$content){
    	action_log('add_message','prize',1,UID);
    	$this->add(['to_uid'=>$to_uid,'title'=>$title,'content'=>$content,'uid'=>0,'create_time'=>NOW_TIME]);

    }
}
