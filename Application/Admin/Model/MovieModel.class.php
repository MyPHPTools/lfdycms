<?php
namespace Admin\Model;
use Think\Model;
use Think\Storage;

/**
 * 影片模型
 */
class MovieModel extends Model{

    protected $_validate = array(
        array('title', 'require', '影片名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
		array('category', 'checkCategory', '该分类下还有分类请选择下属分类', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH),
    );

    protected $_auto = array(
		array('title', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
		array('create_time', 'getCreateTime', self::MODEL_BOTH,'callback'),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
		array('position', 'getPosition', self::MODEL_BOTH, 'callback'),
    );

    /**
     * 获取分类树
     */
    public function getTree($type=1){
        /* 获取当前分类信息 */
        $map = array('status'=>1,'type'=>$type);
        $list = M("Category")->where($map)->field('id,pid,title')->order('pid asc,sort asc')->select();
		$Tree = new \Org\Tree;
		$Tree::$treeList = array();
		return $Tree->tree($list);
    }
	
	public function getPlayer(){
        /* 获取播放器信息 */
		return M("Player")->field('id,title')->order('id asc,sort asc')->select();
    }
	
	/**
     * 获取影片详细信息
     * @param  milit   $id 影片ID
     * @param  boolean $field 查询字段
     * @return array     影片信息
     */
    public function info($id, $field = true){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){
            $map['id'] = $id;
        }
		$info=$this->field($field)->where($map)->find();
		$prefix   = C('DB_PREFIX');
		$info["palyer"]=M("movie_url")->table($prefix.'movie_url url,'.$prefix.'player play')->where('url.movie_player_id=play.id and url.movie_id='.$id)->field('url.id,url.movie_url,url.movie_player_id')->order("play.sort asc")->select();
		$info["picurl"]=get_cover($info["cover_id"],"path");
        return $info;
    }
	
    /**
     * 更新影片信息
     * @return boolean 更新状态
     */
    public function update(){
        $data = $this->create();
		$this->pinyin = $this->get_letter($data['title']);
        if(!$data){ //数据对象创建错误
            return false;
        }
        /* 添加或更新数据 */
        if(empty($data['id'])){
            $res = $this->add();
			$movie_url=I('movie_url',0);
			foreach (I('movie_player_id',0) as $k=>$v){
				$date_url[] = array('movie_id'=>$res,'movie_player_id'=>$v,'movie_url'=>$movie_url[$k]);
        	}
			$rs = M("movie_url")->addAll($date_url);
			//记录行为
			action_log('add_movie','movie',$rs,UID);
        }else{
            $res = $this->save();
			$movie_url=I('movie_url',0);
			$pid=I('pid',0);
			 foreach (I('movie_player_id',0) as $k=>$v){
			 	if($pid[$k]>0){
					M("movie_url")->where(array('id'=>$pid[$k]))->save(array('movie_player_id'=>$v,'movie_url'=>$movie_url[$k]));
				}else{
					M("movie_url")->add(array('movie_id'=>$data['id'],'movie_player_id'=>$v,'movie_url'=>$movie_url[$k]));
				}
        	}
			//记录行为
			action_log('update_movie','movie',$data['id'],UID);
        }
        return $res;
    }

    public function uptj(){
    	$data['id']=I('id');
    	$data['tj_tag']=I('tj_tag');
    	$data['position']=$this->getPosition();
    	$res = $this->save($data);
    	return $res;
    }

    public function displayx($id = null,$value){
    	$map = array('id' => array('in', $id));
    	return $this->where($map)->setField('display',$value);
    }
	
	/**
     * 删除影片
     * @return true 删除成功， false 删除失败
     */
    public function remove($id = null){
		$map = array('id' => array('in', $id) );
		$movie_list = $this->where($map)->field('cover_id')->select();
		foreach ($movie_list as $key => $value) {
			$picture[$key] = $value['cover_id'];
		}
		$map_cover = array('id' => array('in',$picture));
		$cover_list = M("picture")->where($map_cover)->field('path')->select();
		foreach ($cover_list as $value) {
			Storage::unlink($value['path']);
		}
		$res=$this->where($map)->delete();
		M("picture")->where($map_cover)->delete();
		$map_purl = array('movie_id' => array('in', $id));
		M("movie_url")->where($map_purl)->delete();
		//记录行为
		action_log('del_movie','movie',implode(',', $id),UID);
		return $res;
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

	protected function checkCategory($cate_id){
		 $child = M('Category')->where(array('pid'=>$cate_id))->field('id')->select();
        if(!empty($child)){
            return false;
        }
        return true;
	}
	
	/**
	 * 获取指定分类和下级分类
	 * @param  integer $id    分类ID
	 * @param  boolean $field 查询字段
	 * @return array
	 */
	public function getId($id){
		$map["status"] = 1;
		$map["display"] = 1;
		if($id){
			$map["pid"] = $id;
			$info = M("Category")->field("id")->where($map)->order('sort')->select();
			if($info){
				foreach ($info as $key=>$val){
					$ids[]=$val["id"];
				}
			}else{
				$ids[]=$id;
			}
			return $ids;
		}
	}
	
	public function get_letter($s0){
		$firstchar_ord = ord(strtoupper($s0{0})); 
		if (($firstchar_ord>=65 and $firstchar_ord<=91)or($firstchar_ord>=48 and $firstchar_ord<=57)) return $s0{0}; 
		$s = iconv("UTF-8","gb2312", $s0); 
		$asc = ord($s{0})*256+ord($s{1})-65536; 
		if($asc>=-20319 and $asc<=-20284)return "A";
		if($asc>=-20283 and $asc<=-19776)return "B";
		if($asc>=-19775 and $asc<=-19219)return "C";
		if($asc>=-19218 and $asc<=-18711)return "D";
		if($asc>=-18710 and $asc<=-18527)return "E";
		if($asc>=-18526 and $asc<=-18240)return "F";
		if($asc>=-18239 and $asc<=-17923)return "G";
		if($asc>=-17922 and $asc<=-17418)return "H";
		if($asc>=-17417 and $asc<=-16475)return "J";
		if($asc>=-16474 and $asc<=-16213)return "K";
		if($asc>=-16212 and $asc<=-15641)return "L";
		if($asc>=-15640 and $asc<=-15166)return "M";
		if($asc>=-15165 and $asc<=-14923)return "N";
		if($asc>=-14922 and $asc<=-14915)return "O";
		if($asc>=-14914 and $asc<=-14631)return "P";
		if($asc>=-14630 and $asc<=-14150)return "Q";
		if($asc>=-14149 and $asc<=-14091)return "R";
		if($asc>=-14090 and $asc<=-13319)return "S";
		if($asc>=-13318 and $asc<=-12839)return "T";
		if($asc>=-12838 and $asc<=-12557)return "W";
		if($asc>=-12556 and $asc<=-11848)return "X";
		if($asc>=-11847 and $asc<=-11056)return "Y";
		if($asc>=-11055 and $asc<=-10247)return "Z";
		return 0;
	}
}
