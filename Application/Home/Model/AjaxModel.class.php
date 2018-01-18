<?php
namespace Home\Model;
use Think\Model;

class AjaxModel extends Model{

	public function randMovie($limit=6,$category=''){
		if($category){
			$type='and category='.$category;
		}
		$prefix=C('DB_PREFIX');
		$mlist=M()->query('SELECT * FROM `'.$prefix.'movie` AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `'.$prefix.'movie`)-(SELECT MIN(id) FROM `'.$prefix.'movie`))+(SELECT MIN(id) FROM `'.$prefix.'movie`)) AS idx) AS t2 WHERE t1.id >= t2.idx '.$type.' ORDER BY t1.id LIMIT '.$limit);
		foreach($mlist as $key=>$value){
			$list[$key]=D('Tag')->movieChange($value,'movie');
		}
		return $list;
	}
	//搜索返回json
	public function searchTips($keyword,$limit=10){
		$where['title']  = array('like', '%'.$keyword.'%');
		$where['also_known_as']  = array('like', '%'.$keyword.'%');
		$where['_logic'] = 'or';
		$map['_complex'] = $where;
		$lists = M("Movie")->field(true)->where($map)->limit($limit)->order('hits desc')->select();
		foreach ($lists as $v){
			$mlist[]=D('Tag')->movieChange($v);
		}
		return $mlist;
	}
}
