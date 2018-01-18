<?php
namespace Admin\Controller;

class PrizeController extends AdminController {
    public function index(){
        $map = array();
        if(isset($_GET['keyword'])){
            $where['title']  = array('like', '%'.I('keyword').'%');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
        }
        $list   =   $this->lists('Prize', $map);
        $this->assign('Prizelist', $list);
        $this->meta_title = '奖品管理';
        $this->display();
    }

    /* 编辑奖品 */
    public function edit($id = null){
        $Prize = D('Prize');
        if(IS_POST){ //提交表单
            if(false !== $Prize->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Prize->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
			$info=$Prize->info($id);
            $this->assign('info',$info);
            $this->meta_title = '编辑奖品';
            $this->display();
        }
    }

    /* 新增奖品 */
    public function add(){
        $Prize = D('Prize');
        if(IS_POST){ //提交表单
            if(false !== $Prize->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Prize->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            /* 获取奖品信息 */
            $this->meta_title = '新增奖品';
            $this->display('edit');
        }
    }
	
	/**
     * 删除奖品
     */
    public function del(){
		$id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $res = D('Prize')->remove($id);
        if($res !== false){
            $this->success('删除奖品成功！');
        }else{
            $this->error('删除奖品失败！');
        }
    }
	
	public function exchange(){
        $map = array();
        if(isset($_GET['keyword'])){
            $where['usersname']  = array('like', '%'.I('keyword').'%');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
        }
		if(isset($_GET['mode'])){
			$map['mode'] = I('mode');
		}
        $list   =   $this->lists('exchange', $map);
        $this->assign('exchange', $list);
        $this->meta_title = '兑奖管理';
        $this->display();
    }
	
	public function operate($id){
		$operate=D('Prize')->operate($id);
		$this->assign('operate', $operate);
        $this->display();
	}
	
	public function cancel($id){
        if(D('Prize')->cancel($id) !== false){
			action_log('cancel_prize','exchange',$id,UID);
            $this->success('取消交易成功！');
        }else{
            $this->error('取消交易失败！');
        }
	}
	
	public function delivery($id){
		if(D('Prize')->delivery($id) !== false){
			action_log('delivery_prize','exchange',$id,UID);
            $this->success('发货成功！');
        }else{
            $this->error('发货失败！');
        }
	}
}
