<?php
namespace Admin\Controller;

/**
 * 路由管理控制器
 */
class RouteController extends AdminController {

    /**
     * 路由管理列表
     */
    public function index(){
		$list   = $this->lists('Route',array('display'=>1));
        $this->assign('_list', $list);
        $this->meta_title = '路由管理';
        $this->display();
    }

    /* 编辑路由 */
    public function edit($id = null){
        $Route = D('Route');
        if(IS_POST){ //提交表单
            if(false !== $Route->update()){
                F('route',NULL);
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Route->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            if($id){
                $info = $Route->info($id);
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑路由';
            $this->display();
        }
    }

    /* 新增路由 */
    public function add(){
        $Route = D('Route');
        if(IS_POST){ //提交表单
            if(false !== $Route->update()){
                F('route',NULL);
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Route->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $this->meta_title = '新增路由';
            $this->display('edit');
        }
    }

    /**
     * 删除一个路由
     */
    public function del(){
        $id = I('id');
        if(empty($id)){
            $this->error('参数错误!');
        }
        $res = M('Route')->delete($id);
        if($res !== false){
            //记录行为
            action_log('delete_route','route',$id,UID);
            F('route',NULL);
            $this->success('删除路由成功！');
        }else{
            $this->error('删除路由失败！');
        }
    }
}
