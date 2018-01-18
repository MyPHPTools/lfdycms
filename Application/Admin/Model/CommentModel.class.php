<?php
namespace Admin\Model;
use Think\Model;

class CommentModel extends Model {


    public function user_info($id){
    	$map['id'] = $id;
		$map['status']=1;
    	$info=M('users')->where($map)->field('id,username,email,path,vip_time')->find();
		$info['path']=$info['path']?$info['path']:__ROOT__ . '/Public/User/images/user.jpg';
		return $info;
    }

    /**
     * 获取分类树，指定分类则返回指定分类极其子分类，不指定则返回所有分类树
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array          分类树
     */
    public function getTree($mid = null, $id = 0, $field = true){
        $map['status']=1;
        if($mid){
            $map['mid']=$mid;
        }
        /* 获取所有分类 */
        $list = $this->field($field)->where($map)->order('up desc,id desc')->select();
        foreach ($list as $key => $value) {
        	$list[$key]['user']=$this->user_info($value['uid']);
        }
        $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);

        /* 获取返回数据 */
        if(isset($info)){ //指定分类则返回当前分类极其子分类
            $info['_'] = $list;
        } else { //否则返回所有分类
            $info = $list;
        }
        return $info;
    }

    public function remove($id){
        $this->where(array('id'=>$id))->delete();
        $pid=$this->where(array('pid'=>$id))->getField('id');
        if($pid){
            $this->remove($pid);
        }
    }

}