<?php
namespace Admin\Controller;

/**
 * 后台配置控制器
 */
class ToolController extends AdminController {
	
    public function remove(){
		$Tool = D('Tool');
        if(IS_POST){ //提交表单
            switch (I('get.type')) {
                case 'movie':
                    $Tool->remove_movie();
                    break;
                case 'news':
                    $Tool->remove_news();
                    break;
                case 'user':
                    $Tool->remove_user();
                    break;
            }
            $this->success('清空成功！', U('remove'));
        } else {
            $this->meta_title = '清空数据';
            $this->display();
        }
    }

    public function replace(){
        $Tool = D('Tool');
        if(IS_POST){ //提交表单
            $Tool->data_replace();
            $this->success('替换成功！', U('replace'));
        } else {
            $this->meta_title = '数据替换';
            $this->assign('category',D('Movie')->getTree());
            $this->assign('playerlist',D('Movie')->getPlayer());
            $this->display();
        }
    }

    public function random(){
        $Tool = D('Tool');
        if(IS_POST){ //提交表单
            $Tool->data_random();
            $this->success('替换成功！', U('random'));
        } else {
            $this->meta_title = '随机数据';
            $this->assign('category',D('Movie')->getTree());
            $this->display();
        }
    }
}
