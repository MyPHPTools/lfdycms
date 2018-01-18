<?php
namespace Admin\Model;
use Think\Model;

class LinkModel extends Model{

	/* 用户模型自动验证 */
	protected $_validate = array(
		/* 验证用户名 */
		array('title', '1,30', '友情链接网站名称不能为空', self::EXISTS_VALIDATE, 'length' , self::MODEL_BOTH),
		array('title', '', '友情链接网站已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),
		array('url', 'require', '友情链接地址不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	);

	/* 自动完成 */
	protected $_auto = array(
		array('status', '1', self::MODEL_BOTH),
	);
	
	/**
     * 获取友情链接详细信息
     * @param  milit   $id 友情链接ID或标识
     * @param  boolean $field 查询字段
     * @return array     友情链接信息
     */
    public function info($id, $field = true){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['title'] = $id;
        }
		$map['status']=1;
        return $this->field($field)->where($map)->find();
    }
	
	 /**
     * 更新友情链接信息
     * @return boolean 更新状态
     */
    public function update(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }
        /* 添加或更新数据 */
        if(empty($data['id'])){
            $res = $this->add();
			//记录行为
        	action_log('add_link','link',$res,UID);
        }else{
            $res = $this->save();
			//记录行为
        	action_log('update_link','link',$data['id'],UID);
        }
        return $res;
    }
}