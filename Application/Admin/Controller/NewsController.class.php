<?php
namespace Admin\Controller;


class NewsController extends AdminController {

    public function index(){
        $map = array();
        if(isset($_GET['keyword'])){
            $where['title']  = array('like', '%'.I('keyword').'%');
			$where['content']  = array('like', '%'.I('keyword').'%');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
        }
		if(isset($_GET['category'])){
            $map['category']  = I('category');
        }
		if(isset($_GET["order"])){
			$order=I('order')." ".I('type');
		}else{
			$order="id desc";
		}
        $list   =   $this->lists('News', $map ,$order);
        $this->assign('newslist', $list);
		$this->assign('category',   D('movie')->getTree(2));
        $this->meta_title = '文章管理';
        $this->display();
    }

    public function edit($id = null){
        $News = D('News');
        if(IS_POST){
            if(false !== $News->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $News->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
			$info=$News->info($id);
            $this->assign('info',       $info);
            $this->assign('category',   D('movie')->getTree(2));
            $this->meta_title = '编辑文章';
            $this->display();
        }
    }

    public function add(){
        $News = D('News');
        if(IS_POST){
            if(false !== $News->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $News->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $this->assign('category',  D('movie')->getTree(2));
            $this->meta_title = '新增文章';
            $this->display('edit');
        }
    }

    public function del(){
		$id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $res = D('News')->remove($id);
        if($res !== false){
            $this->success('删除文章成功！');
        }else{
            $this->error('删除文章失败！');
        }
    }
}
