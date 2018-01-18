<?php
namespace Admin\Controller;
/**
 * 广告
 */
class AdController extends AdminController {

    /**
     * 广告管理首页
     */
    public function index(){
        $list   = $this->lists('Ad');
        $this->assign('_list', $list);
        $this->meta_title = '广告列表';
        $this->display();
    }
	
	 /* 编辑广告 */
    public function edit($id = null){
        $Ad = D('Ad');
        if(IS_POST){ //提交表单
            if(false !== $Ad->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Ad->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            if($id){
                $info = $Ad->info($id);
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑广告';
            $this->display();
        }
    }
	
	 /* 新增广告 */
    public function add(){
        $Ad = D('Ad');
        if(IS_POST){ //提交表单
            if(false !== $Ad->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Ad->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $this->meta_title = '新增广告';
            $this->display('edit');
        }
    }
	
	 /**
     * 删除广告
     */
    public function del(){
        if(D('Ad')->del(I('id'))){
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}