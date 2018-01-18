<?php
namespace Admin\Controller;

/**
 * 行为控制器
 */
class ActionController extends AdminController {

	/**
     * 行为日志列表
     */
    public function index(){
        //获取列表数据
        $map['status']    =   array('gt', -1);
		$map['type']    =   array('eq', 1);
        $list   =   $this->lists('ActionLog', $map);
        $this->assign('_list', $list);
        $this->meta_title = '行为日志';
        $this->display();
    }

    /**
     * 清空日志
     */
    public function clear(){
		$current = Date('Y-m-d',strtotime("-1 month"));
		$current_date = strtotime($current);
		$map['create_time']    =   array('lt', $current_date);
		$map['type'] = 1;
        $res = M('ActionLog')->where($map)->delete();
        if($res !== false){
			//记录行为
        	action_log('delete_log','action_log',1,UID);
            $this->success('日志清空成功！');
        }else {
            $this->error('日志清空失败！');
        }
    }
	
    /**
     * 行为列表
     */
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    /**
     * 新增行为
     */
    public function addAction(){
        $this->meta_title = '新增行为';
        $this->assign('data',null);
        $this->display('editaction');
    }

    /**
     * 编辑行为
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error('参数不能为空！');
        $data = M('Action')->field(true)->find($id);
        $this->assign('data',$data);
        $this->meta_title = '编辑行为';
        $this->display('editaction');
    }

    /**
     * 更新行为
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            $this->success($res['id']?'更新成功！':'新增成功！', Cookie('__forward__'));
        }
    }
	
	public function del(){
		$id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $res = D('Action')->remove($id);
        if($res !== false){
            $this->success('删除行为成功！');
        }else{
            $this->error('删除行为失败！');
        }
    }
}
