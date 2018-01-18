<?php
namespace Admin\Model;
use Think\Model;

class RouteModel extends Model{

	/* 用户模型自动验证 */
	protected $_validate = array(
		/* 验证用户名 */
		array('title', 'require', '路由名称不能为空', self::EXISTS_VALIDATE),
		array('name', '', '路由已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),
		array('value', 'require', '路由规则不能为空', self::MUST_VALIDATE),
	);
	
	/**
     * 获取路由详细信息
     * @param  milit   $id 路由ID或标识
     * @param  boolean $field 查询字段
     * @return array     路由信息
     */
    public function info($id, $field = true){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['title'] = $id;
        }
        return $this->field($field)->where($map)->find();
    }
	
	 /**
     * 更新路由信息
     * @return boolean 更新状态
     */
    public function update(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }
        $data['value']=htmlspecialchars_decode($data['value']);
        /* 添加或更新数据 */
        if(empty($data['id'])){
            $res = $this->add($data);
			//记录行为
        	action_log('add_route','route',$res,UID);
        }else{
            $res = $this->save($data);
			//记录行为
        	action_log('update_route','route',$data['id'],UID);
        }
        return $res;
    }
}