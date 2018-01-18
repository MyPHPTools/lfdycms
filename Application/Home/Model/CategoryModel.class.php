<?php
namespace Home\Model;
use Think\Model;

/**
 * 分类模型
 */
class CategoryModel extends Model{
	/**
	 * 获取分类详细信息
	 * @param  milit   $id 分类ID或标识
	 * @param  boolean $field 查询字段
	 * @return array     分类信息
	 */
	public function info($id, $field = true){
		/* 获取分类信息 */
		$map = array();
		if(is_numeric($id)){ //通过ID查询
			$map['id'] = $id;
		} else { //通过标识查询
			$map['name'] = $id;
		}
		return $this->field($field)->where($map)->find();
	}
	/**
	*返回分类设置的模板
	*/
	public function getTpl($id,$tpld){
		$tpl=$this->info($id,'pid,'.$tpld);
		if($tpl[$tpld]){
			return $tpl[$tpld];
		}
		if($tpl['pid']==0){
			$this->error = '模板未设置！';
			return false;
		}else{
			return $this->getTpl($tpl['pid'],$tpld);
		}
	}
}
