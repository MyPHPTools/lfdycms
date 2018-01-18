<?php
namespace Home\Controller;

class AjaxController extends HomeController {
	//json 随机影片
    public function randMovie(){
		$data=D('Ajax')->randMovie(I('limit'),I('category'));
        $this->ajaxReturn($data);
    }
	public function searchTips(){
		$data=D('Ajax')->searchTips(I('keyword'),I('limit'));
        $this->ajaxReturn($data);
    }
}