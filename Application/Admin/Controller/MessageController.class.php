<?php
namespace Admin\Controller;
/**
 * 消息管理
 */
class MessageController extends AdminController{

    /**
     * 消息首页
     */
    public function index(){
        $this->meta_title = '消息管理';
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
			if($_GET['id']){
				$this->username=get_user_name(I('get.id'));
				$this->type=1;
			}
            $this->meta_title = '新增用户';
            $this->display();
        }
    }
	
	 /**
     * 删除消息
     */
    public function del(){
        $map['is_read'] = 1;
        if(M('Message')->where($map)->delete()){
			//记录行为
        	action_log('del_message','message','',UID);	
            $this->success('清除成功');
        } else {
            $this->error('无清除内容！');
        }
    }
}