<?php
namespace Admin\Model;
use Think\Model;

/**
 * 分类模型
 */
class CategoryModel extends Model{

    protected $_validate = array(
        array('name', 'require', '分类标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '', '分类标识已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('title', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('type', array(1,2,3), '值的范围不正确！', self::VALUE_VALIDATE , 'in', self::MODEL_BOTH),
        array('meta_title', '1,50', '网页标题不能超过50个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
        array('keywords', '1,255', '网页关键字不能超过255个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
        array('meta_title', '1,255', '网页描述不能超过255个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_BOTH),
        array('template_index','template_index_auto',1,'callback'),
        array('template_detail','template_detail_auto',1,'callback'),
        array('template_play','template_play_auto',1,'callback'),
        array('template_type','template_type_auto',1,'callback'),
    );


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
     * 获取分类树，指定分类则返回指定分类极其子分类，不指定则返回所有分类树
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array          分类树
     */
    public function getTree($id = 0, $field = true){
        /* 获取当前分类信息 */
        if($id){
            $info = $this->info($id);
            $id   = $info['id'];
        }

        /* 获取所有分类 */
        $list = $this->field($field)->where($map)->order('sort')->select();
        $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);

        /* 获取返回数据 */
        if(isset($info)){ //指定分类则返回当前分类极其子分类
            $info['_'] = $list;
        } else { //否则返回所有分类
            $info = $list;
        }

        return $info;
    }

    /**
     * 获取指定分类的同级分类
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array
     */
    public function getSameLevel($id, $field = true){
        $info = $this->info($id, 'pid');
        $map = array('pid' => $info['pid'], 'status' => 1);
        return $this->field($field)->where($map)->order('sort')->select();
    }

    /**
     * 更新分类信息
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
            action_log('add_category','category',$res,UID);
        }else{
            $res = $this->save();
            //记录行为
            action_log('update_category','category',$data['id'],UID);
        }
        //更新分类缓存
        S('sys_category_list', null);
        return $res;
    }

    protected function template_index_auto(){
    	$template_index=I('post.template_index');
        if(empty($template_index)){
            if(I('post.type')==1){
                if(I('post.pid')){
                    return 'lists.html';
                }else{
                    return 'type.html';
                }
            }elseif(I('post.type')==2){
                return 'newslists.html';
            }
            return '';
        }else{
            return $template_index;
        }
    }

    protected function template_detail_auto(){
    	$template_detail=I('post.template_detail');
        if(empty($template_detail)){
            if(I('post.type')==1 && I('post.pid')==0){
                return 'movie.html';
            }elseif(I('post.type')==2 && I('post.pid')==0){
                return 'news.html';
            }
            return '';
        }else{
            return $template_detail;
        }
    }

    protected function template_play_auto(){
    	$template_play=I('post.template_play');
        if(empty($template_play)){
            if(I('post.type')==1 && I('post.pid')==0){
                return 'player.html';
            }
            return '';
        }else{
            return $template_play;
        }
    }

    protected function template_type_auto(){
    	$template_type=I('post.template_type');
        if(empty($template_type)){
            if(I('post.type')==1 && I('post.pid')==0){
                return 'lists.html';
            }
            return '';
        }else{
            return $template_type;
        }
    }
}
