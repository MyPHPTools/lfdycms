<?php
namespace Admin\Controller;
use Think\Storage;

class UsersController extends AdminController {

    
    public function index(){
		$map = array();
        if(isset($_GET['keyword'])){
            $map['username']  = array('like', '%'.I('keyword').'%');
        }
        if(!empty($_GET['type'])){
            if($_GET['type']==1){
                $map['vip_time'] = array('lt',NOW_TIME);
            }else{
                $map['vip_time'] = array('egt',NOW_TIME);
            }
        }
        $count['pt']=M('users')->where(array('vip_time'=>array('lt',NOW_TIME)))->count();
        $count['vip']=M('users')->where(array('vip_time'=>array('egt',NOW_TIME)))->count();
        $list   = $this->lists('Users',$map);
        $this->assign('_list', $list);
        $this->assign('count', $count);
        $this->meta_title = '用户列表';
        $this->display();
    }

    public function info($id){
        $user=M('users')->where(array('id'=>$id))->find();
        $this->assign('user', $user);
        $this->display();
    }
	
	public function add($username = '', $password = '', $repassword = ''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }
            $uid = D('Users')->register();
            if(0 < $uid){ //注册成功
				//记录行为
        		action_log('add_user','users',$uid ,UID);	
                $this->success('用户添加成功！',U('index'));
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->meta_title = '新增用户';
            $this->display();
        }
    }
	
	/**
     * 修改密码初始化
     */
    public function edit($id = 0){
	 	empty($id) && $this->error('参数不正确！');
		$username = M('Users')->getFieldById($id, 'username');
		$this->assign('uid', $id);
        $this->assign('username', $username);
        $this->meta_title = '修改密码';
        $this->display();
    }

    /**
     * 修改密码提交
     */
    public function submitPassword(){
        //获取参数
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');
		$uid = I('post.uid');
		empty($uid) && $this->error('参数不正确！');
        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }
        $res   =  D('Users')->updateUser($uid, $data);
		if($res  !== false){
			//记录行为
        	action_log('update_user_user','users',$uid ,UID);
            $this->success('修改密码成功！',U('index'));
        }else{
			if(!is_numeric(D('Member')->getError())){
				$this->error(D('Member')->getError());
			}else{
				$this->error($this->showRegError(D('Member')->getError()));
			}
        }
    }
	
	 /**
     * 删除用户
     */
    public function del(){
        $id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
		$user_list = M('Users')->where($map)->field('path')->select();
		foreach ($user_list as $value) {
			Storage::unlink($value['path']);
		}
        if(M('Users')->where($map)->delete()){
            $umap = array('uid' => array('in', $id) );
            M('Comment')->where($umap)->delete();
            M('users_follow')->where($umap)->delete();
            M('users_follow')->where(array('fid' => array('in', $id)))->delete();
			M('PlayerLog')->where($umap)->delete();
			//记录行为
        	action_log('del_user_user','users',implode(',', $id) ,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    public function timeadd(){
        $this->display();
    }

    public function disable($id){
        M('Users')->where(array('id'=>$id))->setField('status',0);
        $this->success('禁用成功');
    }

    public function enable($id){
        M('Users')->where(array('id'=>$id))->setField('status',1);
        $this->success('启用成功');
    }
	
	 /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被占用！'; break;
            case -3:  $error = '密码长度必须在5-30个字符之间！'; break;
			case -4:  $error = 'email被占用！'; break;
			case -5:  $error = 'email格式不正确！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }
}