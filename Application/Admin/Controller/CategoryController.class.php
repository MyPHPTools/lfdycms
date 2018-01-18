<?php
namespace Admin\Controller;

/**
 * 后台分类管理控制器
 */
class CategoryController extends AdminController {

    /**
     * 分类管理列表
     */
    public function index(){
        $tree = D('Category')->getTree(0,'id,name,title,sort,pid,type,display,status');
        $this->assign('tree', $tree);
        C('_SYS_GET_CATEGORY_TREE_', true); //标记系统获取分类树模板
        $this->meta_title = '分类管理';
        $this->display();
    }

    /**
     * 显示分类树，仅支持内部调
     * @param  array $tree 分类树
     */
    public function tree($tree = null){
        C('_SYS_GET_CATEGORY_TREE_') || $this->_empty();
        $this->assign('tree', $tree);
        $this->display('tree');
    }

    /* 编辑分类 */
    public function edit($id = null, $pid = 0){
        $Category = D('Category');
        if(IS_POST){ //提交表单
            if(false !== $Category->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Category->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = '';
            if($pid){
                /* 获取上级分类信息 */
                $cate = $Category->info($pid, 'id,name,title,status');
                if(!($cate && 1 == $cate['status'])){
                    $this->error('指定的上级分类不存在或被禁用！');
                }
            }

            /* 获取分类信息 */
            $info = $id ? $Category->info($id) : '';
            $this->assign('info',       $info);
            $this->assign('category',   $cate);
            $this->meta_title = '编辑分类';
            $this->display();
        }
    }

    /* 新增分类 */
    public function add($pid = 0){
        $Category = D('Category');
        if(IS_POST){ //提交表单
            if(false !== $Category->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Category->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = array();
            if($pid){
                /* 获取上级分类信息 */
                $cate = $Category->info($pid, 'id,name,title,status');
                if(!($cate && 1 == $cate['status'])){
                    $this->error('指定的上级分类不存在或被禁用！');
                }
            }
            /* 获取分类信息 */
            $this->assign('category', $cate);
            $this->meta_title = '新增分类';
            $this->display('edit');
        }
    }

    /**
     * 删除一个分类
     */
    public function remove(){
        $cate_id = I('id');
        if(empty($cate_id)){
            $this->error('参数错误!');
        }

        //判断该分类下有没有子分类，有则不允许删除
        $child = M('Category')->where(array('pid'=>$cate_id))->getField('id');
        if(!empty($child)){
            $this->error('请先删除该分类下的子分类');
        }

        //删除该分类下内容
        $type=M('Category')->where(array('id'=>$cate_id))->getField('type');
        if($type==1){
            $movie_list = M('Movie')->where(array('category'=>$cate_id))->getField('id',true);
            if(!empty($movie_list)){
                D('Movie')->remove($movie_list);
            }
        }else{
            $news_list = M('News')->where(array('category'=>$cate_id))->getField('id',true);
            if(!empty($news_list)){
                D('News')->remove($news_list);
            }
        }

        //删除该分类信息
        $res = M('Category')->delete($cate_id);
        if($res !== false){
            //记录行为
			action_log('del_category','category',$cate_id,UID);
            $this->success('删除分类成功！');
        }else{
            $this->error('删除分类失败！');
        }
    }

    /**
     * 操作分类初始化
     * @param string $type
     */
    public function operate($type = 'move'){
        //检查操作参数
        if(strcmp($type, 'move') == 0){
            $operate = '移动';
        }elseif(strcmp($type, 'merge') == 0){
            $operate = '合并';
        }else{
            $this->error('参数错误！');
        }
        $from = intval(I('get.from'));
        empty($from) && $this->error('参数错误！');

        //获取分类
        $map = array('status'=>1, 'id'=>array('neq', $from));
        $list = M('Category')->where($map)->field('id,pid,title')->order('pid asc,id asc,sort asc')->select();
		$Tree = new \Org\Tree;
        $this->assign('type', $type);
        $this->assign('operate', $operate);
        $this->assign('from', $from);
        $this->assign('list', $Tree->tree($list));
        $this->meta_title = $operate.'分类';
        $this->display();
    }

    /**
     * 移动分类
     */
    public function move(){
        $to = I('post.to');
        $from = I('post.from');
		$Model = M('Category');
		$from_models = $Model->getFieldById($from, 'type');
        $to_models = $Model->getFieldById($to, 'type');
		if($from_models!=$to_models){
			$this->error('不同模型分类无移动');
		}
        $res = $Model->where(array('id'=>$from))->setField('pid', $to);
        if($res !== false){
			//记录行为
        	action_log('move_category','category',$from.'移动到'.$to,UID);
            $this->success('分类移动成功！', U('index'));
        }else{
            $this->error('分类移动失败！');
        }
    }

    /**
     * 合并分类
     */
    public function merge(){
        $to = I('post.to');
        $from = I('post.from');
        $Model = M('Category');
        //检查分类绑定的模型
        $from_models = $Model->getFieldById($from, 'type');
        $to_models = $Model->getFieldById($to, 'type');
		if($from_models!=$to_models or $from_models==3){
			$this->error('不同模型分类无法合并或外链模型无法合并');
		}
        //合并文档
		if($from_models==1){
        	$res = M('Movie')->where(array('category'=>$from))->setField('category', $to);
		}else{
			$res = M('News')->where(array('category'=>$from))->setField('category', $to);
		}
        if($res){
            //删除被合并的分类
            $Model->delete($from);
			//记录行为
        	action_log('merge_category','category',$from.'合并到'.$to,UID);
            $this->success('合并分类成功！', U('index'));
        }else{
            $this->error('合并分类失败！');
        }

    }
}
