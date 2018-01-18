<?php
namespace Home\Model;
use Think\Model;

class CommentModel extends Model {

	protected $_validate = array(
		array('content', 'require', '消息内容不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
		array('content', 'filterContent', self::MODEL_BOTH, 'callback'),
        array('create_time', NOW_TIME, self::MODEL_BOTH),
		array('status', 1, self::MODEL_BOTH, 'string'),
    );

	public function comment_add(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }
		$data['uid']=UID;
        return $this->add($data);
    }

    public function user_info($id){
    	$map['id'] = $id;
		$map['status']=1;
    	$info=M('users')->where($map)->field('id,username,email,path,vip_time')->find();
		$info['path']=$info['path']?$info['path']:__ROOT__ . '/Public/User/'.MOBILE.'/images/user.jpg';
		return $info;
    }

    /**
     * 获取分类树，指定分类则返回指定分类极其子分类，不指定则返回所有分类树
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array          分类树
     */
    public function getTree($mid, $id = 0, $field = true){
        $map['status']=1;
        $map['mid']=$mid;
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

    protected function filterContent(){
        $str = htmlspecialchars(I('post.content'));
        $str = str_replace(C('COMMENT_KEY'), '***', $str);
        return $str;
    }
}
