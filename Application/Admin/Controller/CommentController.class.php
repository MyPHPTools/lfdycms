<?php
namespace Admin\Controller;

class CommentController extends AdminController {

    public function index(){
        $map['status']=1;
		$tree = $this->lists('comment', $map ,'id desc');
        foreach ($tree as $key => $value) {
            $tree[$key]['user']=D('Comment')->user_info($value['uid']);
            $tree[$key]['movie_title']=M('movie')->where(array('id'=>$value['mid']))->getField('title');
        }
        $this->assign('tree', $tree);
        $this->meta_title = '评论管理';
        $this->display();
    }

    public function comment($id = null){
        $tree = D('Comment')->getTree($id);
        $this->assign('tree', $tree);
        C('_SYS_GET_COMMENT_TREE_', true);
        $this->display();
    }

    /**
     * 显示分类树，仅支持内部调
     * @param  array $tree 分类树
     */
    public function tree($tree = null){
        C('_SYS_GET_COMMENT_TREE_') || $this->_empty();
        $this->assign('tree', $tree);
        $this->display('tree');
    }

    public function del($id){
        D('Comment')->remove($id);
        $this->success('删除评论成功！');
    }
}