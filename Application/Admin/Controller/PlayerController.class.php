<?php
namespace Admin\Controller;

/**
 * 后台播放器管理控制器
 */
class PlayerController extends AdminController {

    /**
     * 播放器管理列表
     */
    public function index(){
		$player   = M("Player")->field('id,title,display,vip,type')->order('sort asc,id desc')->select();
        $this->assign('player', $player);
        $this->meta_title = '播放器管理';
        $this->display();
    }

    /* 编辑播放器 */
    public function edit($id = null){
        $Player = D('Player');

        if(IS_POST){ //提交表单
            if(false !== $Player->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Player->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            if($id){
                $info = $Player->info($id);
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑播放器';
            $this->display();
        }
    }

    /* 新增播放器 */
    public function add(){
        $Player = D('Player');

        if(IS_POST){ //提交表单
            if(false !== $Player->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Player->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $this->meta_title = '新增播放器';
            $this->display('edit');
        }
    }

    /**
     * 删除一个播放器
     */
    public function del(){
        $id = I('id');
        if(empty($id)){
            $this->error('参数错误!');
        }
        $res = M('Player')->delete($id);
        if($res !== false){
            //记录行为
            action_log('delete_player','player',$id,UID);
            $this->success('删除播放器成功！');
        }else{
            $this->error('删除播放器失败！');
        }
    }
}
