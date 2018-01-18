<?php
namespace Admin\Model;
use Think\Model;
use Think\Storage;


class NewsModel extends Model{

    protected $_validate = array(
        array('title', 'require', '文章名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
		array('category', 'checkCategory', '该分类下还有分类请选择下属分类', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH),
    );

    protected $_auto = array(
		array('title', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
		array('create_time', 'getCreateTime', self::MODEL_BOTH,'callback'),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
		array('position', 'getPosition', self::MODEL_BOTH, 'callback'),
    );
	
    public function info($id, $field = true){
        $map = array();
        if(is_numeric($id)){
            $map['id'] = $id;
        }
		$info=$this->field($field)->where($map)->find();
		$info["picurl"]=get_cover($info["cover_id"],"path");
        return $info;
    }
	
    public function update(){
        $data = $this->create();
        if(!$data){
            return false;
        }
        if(empty($data['id'])){
            $res = $this->add();
			action_log('add_news','news',$res,UID);
        }else{
            $res = $this->save();
			action_log('update_news','news',$data['id'],UID);
        }
        return $res;
    }
	
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
		action_log('del_news','news',implode(',', $id),UID);
		return $res;
	}
	
    protected function getPosition(){
        $position = I('post.position');
        if(!is_array($position)){
            return 0;
        }else{
            $pos = 0;
            foreach ($position as $key=>$value){
                $pos += $value;
            }
            return $pos;
        }
	}

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
}
