<?php
namespace Admin\Controller;
/**
 * 友情链接
 */
class LinkController extends AdminController {

    /**
     * 友情链接管理首页
     */
    public function index(){
        $list   = $this->lists('Link');
        $this->assign('_list', $list);
        $this->meta_title = '友情链接列表';
        $this->display();
    }
	
	 /* 编辑友情链接 */
    public function edit($id = null){
        $Link = D('Link');
        if(IS_POST){ //提交表单
            if(false !== $Link->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Link->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            if($id){
                $info = $Link->info($id);
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑友情链接';
            $this->display();
        }
    }
	
	 /* 新增友情链接 */
    public function add(){
        $Link = D('Link');

        if(IS_POST){ //提交表单
            if(false !== $Link->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Link->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $this->meta_title = '新增播放器';
            $this->display('edit');
        }
    }
	
	 /**
     * 删除友情链接
     */
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(M('Link')->where($map)->delete()){
			//记录行为
        	action_log('delete_link','link',implode(',', $id),UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}