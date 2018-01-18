<?php
namespace Admin\Model;
use Think\Model;

class PlayerModel extends Model{

	/* 用户模型自动验证 */
	protected $_validate = array(
		/* 验证用户名 */
		array('title', '1,30', '播放器名称不能为空', self::EXISTS_VALIDATE, 'length' , self::MODEL_BOTH),
		array('title', '', '播放器已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),
		array('player_code', 'checkPlayerCode', '播放器代码不能为空', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH),
	);
	
	/**
     * 获取播放器详细信息
     * @param  milit   $id 播放器ID或标识
     * @param  boolean $field 查询字段
     * @return array     播放器信息
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
     * 更新播放器信息
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
        	action_log('add_player','player',$res,UID);
        }else{
            $res = $this->save();
			//记录行为
        	action_log('update_player','player',$data['id'],UID);
        }
        return $res;
    }
	
	public function getPlayer($url,$type){
		$map['id']=bind_play($type);
		$map['display']=1;
		$player=M('Player')->field(true)->where($map)->find();
		if(!$player){
			$this->error = '影片播放器禁止播放！';
			return false;
		}
		return str_replace(array('<$url>','<$lasturl>','<$nexturl>','<$lastplay>','<$nextplay>'),array($url,'','','',''),htmlspecialchars_decode($player["player_code"]));
	}

    protected function checkPlayerCode($code){
        if(I('type')==1){
            return true;
        }else{
            if(!empty($code)){
                return true;
            }
            return false;
        }
    }
}