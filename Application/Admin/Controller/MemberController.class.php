<?php
namespace Admin\Controller;
/**
 * 管理员管理
 */
class MemberController extends AdminController {

    /**
     * 管理员管理首页
     */
    public function index(){
        $list   = $this->lists('Member');
        $this->assign('_list', $list);
        $this->meta_title = '管理员列表';
        $this->display();
    }
	
	public function add($username = '', $password = '', $repassword = ''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            $uid    =    D('Member')->register($username, $password);
            if(0 < $uid){ //注册成功
                $this->success('管理员添加成功！',U('index'));
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->meta_title = '新增管理员';
            $this->display();
        }
    }
	
	/**
     * 修改密码初始化
     */
    public function edit($id = 0){
	 	empty($id) && $this->error('参数不正确！');
		$username = M('Member')->getFieldById($id, 'username');
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
        $password   =   I('post.old');
        empty($password) && $this->error('请输入原密码');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');
		$uid = I('post.uid');
		empty($uid) && $this->error('参数不正确！');
        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }
        $res   =  D('Member')->updateUser($uid, $password, $data);
		if($res  !== false){
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
     * 删除管理员
     */
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(M('Member')->where($map)->delete()){
			//记录行为
        	action_log('delete_admin','member',implode(",", $id),UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
	
	 /**
     * 获取管理员注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '管理员名长度必须在16个字符以内！'; break;
            case -2:  $error = '管理员名被占用！'; break;
            case -3:  $error = '密码长度必须在5-30个字符之间！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }
}