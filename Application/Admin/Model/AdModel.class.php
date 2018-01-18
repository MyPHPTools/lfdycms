<?php
namespace Admin\Model;
use Think\Model;
use Think\Storage;

class AdModel extends Model{

	protected $_validate = array(
		array('title', '1,30', '广告名称不能为空', self::EXISTS_VALIDATE, 'length' , self::MODEL_BOTH),
		array('title', '', '广告已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),
		array('url', '1,30', '广告文件名不能为空', self::EXISTS_VALIDATE, 'length' , self::MODEL_BOTH),
		array('url', '', '广告文件名已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),
	);

	protected $_auto = array(
		array('status', '1', self::MODEL_BOTH),
	);
	
	/**
     * 获取广告详细信息
     * @param  milit   $id 广告ID或标识
     * @param  boolean $field 查询字段
     * @return array     广告信息
     */
    public function info($id, $field = true){
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            
        } else { //通过标识查询
            $map['title'] = $id;
        }
		$map['status']=1;
		$info=$this->field($field)->where($map)->find();
		$info["content"]=$this->js2t(Storage::read('Public/Ad/'.$info["url"].".js"));
        return $info;
    }
	
	 /**
     * 更新广告信息
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
			Storage::put('Public/Ad/'.I('url').'.js',$this->t2js(I('content')));
			//记录行为
			action_log('add_ad','ad',$res,UID);
        }else{
            $res = $this->save();
			$info=$this->info($data['id']);
			Storage::put('Public/Ad/'.$info['url'].'.js',$this->t2js(I('content')));
			//记录行为
        	action_log('update_ad','ad',$data['id'],UID);
        }
        return $res;
    }
	
	public function del($id){
		$info=$this->info($id);
		Storage::unlink('Public/Ad/'.$info['url'].'.js');
		action_log('delete_ad','ad',$id,UID);
		return $this->where('id='.$id)->delete();
	}
	
	protected function t2js($str){
    	$str = str_replace(array("\r", "\n"), array('', '\n'), htmlspecialchars_decode($str));
    	return "document.write('$str');";
	}
	protected function js2t($str){
		$str = str_replace(array("document.write('", "');"), array('', ''), $str);
		return $str;
	}
}