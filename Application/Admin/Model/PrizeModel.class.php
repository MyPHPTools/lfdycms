<?php
namespace Admin\Model;
use Think\Model;
use Think\Storage;

/**
 * 分类模型
 */
class PrizeModel extends Model{

    protected $_validate = array(
        array('title', 'require', '奖品名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
		array('title', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
		array('create_time', 'getCreateTime', self::MODEL_BOTH,'callback'),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
		array('position', 'getPosition', self::MODEL_BOTH, 'callback'),
    );

	/**
     * 获取奖品详细信息
     * @param  milit   $id 奖品ID
     * @param  boolean $field 查询字段
     * @return array     播放器信息
     */
    public function info($id, $field = true){
        $map = array();
        if(is_numeric($id)){
            $map['id'] = $id;
        }
		$info=$this->field($field)->where($map)->find();
		$info["picurl"]=get_cover($info["cover_id"],"path");
        return $info;
    }
	
    /**
     * 更新奖品信息
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
			action_log('add_prize','prize',$res,UID);
        }else{
            $res = $this->save();
			//记录行为
			action_log('update_prize','prize',$data['id'],UID);
        }
        return $res;
    }
	
	
	/**
     * 删除奖品
     * @return true 删除成功， false 删除失败
     */
	public function remove($id = null){
		$map = array('id' => array('in', $id) );
		$prize_list = $this->where($map)->field('cover_id')->select();
		foreach ($prize_list as $key => $value) {
			$picture[$key] = $value['cover_id'];
		}
		$map_cover = array('id' => array('in',$picture));
		$cover_list = M("picture")->where($map_cover)->field('path')->select();
		foreach ($cover_list as $value) {
			Storage::unlink($value['path']);
		}
		$res=$this->where($map)->delete();
		M("picture")->where($map_cover)->delete();
		//记录行为
		action_log('del_prize','prize',implode(',', $id),UID);
		return $res;
	}
	
	public function operate($id){
		$map = array();
        if(is_numeric($id)){
            $map['id'] = $id;
        }
		$info=M('exchange')->field($field)->where($map)->find();
        return $info;
	}
	
	public function cancel($id){
		$info=$this->operate($id);
		$prizetitle=get_prizetitle($info['pid']);
		$data=array('to_uid'=>$info['uid'],'title'=>'你兑换的奖品'.$prizetitle.'已经取消','content'=>'你兑换的奖品'.$prizetitle.'已经取消，积分已经返回，取消原因请联系管理员！','create_time'=>NOW_TIME,'type'=>0,'uid'=>0);
		M('message')->add($data);
		M('exchange')-> where('id='.$info['id'])->setField('mode',2);
		return M('Users')->where('id='.$info['uid'])->setInc('integral',$info['integral']);
	}
	
	public function delivery($id){
		$info=$this->operate($id);
		$prizetitle=get_prizetitle($info['pid']);
		$data=array('to_uid'=>$info['uid'],'title'=>'你兑换的奖品'.$prizetitle.'已经发货','content'=>'你兑换的奖品'.$prizetitle.'已经发货，不久将能收到请您耐心等待！','create_time'=>NOW_TIME,'type'=>0,'uid'=>0);
		M('message')->add($data);
		return M('exchange')-> where('id='.$id)->setField('mode',1);
	}
	
	 /**
     * 生成推荐位的值
     * @return number 推荐位
     */
    protected function getPosition(){
        $position = I('post.position');
        if(!is_array($position)){
            return 0;
        }else{
            $pos = 0;
            foreach ($position as $key=>$value){
                $pos += $value;		//将各个推荐位的值相加
            }
            return $pos;
        }
	}
	
	 /**
     * 创建时间不写则取当前时间
     * @return int 时间戳
     */
    protected function getCreateTime(){
        $create_time    =   I('post.create_time');
        return $create_time?strtotime($create_time):NOW_TIME;
    }
}
