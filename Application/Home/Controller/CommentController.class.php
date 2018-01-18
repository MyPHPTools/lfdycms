<?php
namespace Home\Controller;

class CommentController extends HomeController {
    public function index(){
		$tree = D('Comment')->getTree(I('id'));
		$this->assign('count',M('Comment')->where(array('mid'=>I('id'),'pid'=>0,'status'=>1))->count());
		$this->assign('limit',I('limit'));
        $this->assign('size',I('size'));
        $this->assign('tree', $tree);
		$this->assign("mid",I('id'));
        $this->display("Public/Comment/comment.html");
    }

    /**
     * 显示分类树，仅支持内部调
     * @param  array $tree 分类树
     */
    public function tree($tree = null){
    	if(!is_array($tree)){
    		$tree=json_decode($tree,true);
    	}
        $this->assign('tree', $tree);
        $this->display('Public/Comment/tree.html');
    }

    public function add(){
    	if(UID){
    		if(D("Comment")->comment_add()){
	    		$this->success('评论发送成功！');
	    	}else{
	    		$this->error(D('Comment')->getError());
	    	}
    	}else{
    		$this->error('请先登录！');
    	}
    }

    public function up($id){
    	if(!cookie('comment_up_'.$id)){
    		cookie('comment_up_'.$id,true);
    		M('Comment')->where(array('id'=>$id))->setInc('up');
    		$this->success('+1');
    	}else{
    		$this->error('请不要重复顶！');
    	}
    }
}