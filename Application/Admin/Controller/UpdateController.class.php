<?php
namespace Admin\Controller;

class UpdateController extends AdminController {

    public function index(){
        $version  = D('Update')->version();
        $this->assign('version', $version);
        $this->meta_title = '在线升级';
        $this->display();
    }
	
	public function lists(){
		$version  = D('Update')->version();
		$upList = D('Update')->upContent();
		$this->assign('version', $version);
		$this->assign('upList', $upList);
		$this->meta_title = '在线升级';
		$this->display('list');
	}
    public function update(){
		$this->ajaxReturn(D('Update')->update());
    }
	
    public function install(){
		if(true==D('Update')->install()){
			$this->success('安装完成！');
    	}else{
			$this->error('安装错误！');
		}
	}
}