<?php
namespace Home\Model;
use Think\Model;

class NewsModel extends Model{

	public function detail($id){
		$info = $this->field(true)->find($id);
		$this->hits($id);
		if(!(is_array($info) || 1 !== $info['status'] || 1 !== $info['display'])){
			$this->error = '文章被禁用或已删除！';
			return false;
		}
		return $info;
	}
	
	public function hits($id){
		$this->where('id='.$id)->setInc('hits');
		return $this->where('id='.$id)->field('hits,up,down')->find();
	}
	
	public function digg($id){
		if($_GET['digg']=='up'){
			$this->where('id='.$id)->setInc('up');
		}else{
			$this->where('id='.$id)->setDec('down');
		}
		return $this->where('id='.$id)->field('up,down')->find();
	}
}
