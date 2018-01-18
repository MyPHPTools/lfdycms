<?php
namespace User\Model;
use Think\Model;

class FavoritesModel extends Model {

	public function info($id){
		$map['id']=$id;
		$info=$this->where($map)->find();
		$info=D('Home/Movie')->detail($info['mid']);
		return D('Home/Tag')->movieChange($info);
	}
	
	public function change($data){
		foreach ($data as $k=>$v){
			$info=D('Home/Movie')->detail($v['mid']);
			$list[$k]=D('Home/Tag')->movieChange($info);
			$list[$k]['fid']=$v['id'];
		}
		return $list;
	}
	
	public function add($id,$category){
    	$data['mid'] = $id;
    	$data['uid'] = UID;
    	if(!M('Favorites')->where($data)->getField('id')){
    		$data['create_time'] = NOW_TIME;
    		$data['type']=M('Category')->where(array('id'=>$category))->getField('private');
    		M('movie')->where(array('id'=>$id))->setInc('favorites_count');
    		return M('Favorites')->data($data)->add();
    	}else{
    		return true;
    	}
    }
}