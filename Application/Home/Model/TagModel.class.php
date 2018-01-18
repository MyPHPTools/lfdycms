<?php
namespace Home\Model;
use Think\Model;

class TagModel extends Model{
	
	public function getNav($category,$limit,$type,$field){
		if($field=="true") $field = true;
		$map["status"] = 1;
		$map["display"] = 1;
		$map["pid"] = $category;
		$map["navno"] = 1;
		if($type) $map["type"] = $type;
		$lists=M("Category")->field($field)->where($map)->limit($limit)->order('sort')->select();
		if($lists){
			foreach ($lists as $k=>$v){
				$navList[$k]=$v;
				$navList[$k]["url"]=url_change("lists/index",array("id"=>$v["id"],"name"=>$v["name"]));
				$navList[$k]["branch"]=$this->getbranch($v["id"],$type,$field);
				if($v["link"]){
					$navList[$k]["url"]=$v["link"];
				}
			}
			return $navList;
		}
	}

	public function getSlider($limit,$field,$type=0){
		if($field=="true") $field = true;
		$map["status"] = 1;
		$map["display"] = 1;
		$map['type']=$type;
		$lists=M("slider")->field($field)->where($map)->limit($limit)->order('sort')->select();
		if($lists){
			foreach ($lists as $k=>$v){
				$sliderList[$k]['title']=$v['title'];
				$sliderList[$k]["url"]=$v['link'];
				$sliderList[$k]["pic"]=get_cover($v["cover_id"],"path");
			}
			return $sliderList;
		}
	}

	 /**
	 * 获取文档列表
	 * @param  integer  $category 分类ID
	 * @param  string   $order    排序规则
	 * @param  integer  $status   状态
	 * @param  string   $field    字段 true-所有字段
	 * @param  string   $pos      推荐位置
	 * @return array              文档列表
	 */
	public function lists($category,$order,$limit,$status=1,$field=true,$pos=false){
		if($field=="true") $field = true;
		$category=$this->getId($category);
		$map = $this->listMap($category, $status, $pos);
		$lists = M("Movie")->field($field)->where($map)->limit($limit)->order($order)->select();
		if($lists){
			foreach ($lists as $k=>$v){
				$mlist[]=$this->movieChange($v);
			}
			return $mlist;
		}
	}
	
	public function news($category,$order,$limit,$status=1,$field=true,$pos=false){
		if($field=="true") $field = true;
		$category=$this->getId($category);
		$map = $this->listMap($category, $status, $pos);
		$lists = M("News")->field($field)->where($map)->limit($limit)->order($order)->select();
		if($lists){
			foreach ($lists as $k=>$v){
				$mlist[]=$this->movieChange($v,'news');
			}
			return $mlist;
		}
	}
	
	 /**
	 * 获取文档列表
	 * @param  integer  $category 分类ID
	 * @param  string   $order    排序规则
	 * @param  integer  $status   状态
	 * @param  string   $field    字段 true-所有字段
	 * @return array              文档列表
	 */
	public function listsPage($category,$order,$limit,$status=1,$field=true){
		if($field=="true") $field = true;
		if(I('p')){
			$page = I('p');
		}else{
			$page = 1;
		}
		if(I('order')){
			$order=I('order').' desc';
		}
		$category=$this->getId($category);
		$map = $this->listPageMap($category);
		$lists = M("Movie")->field($field)->where($map)->limit($limit)->page($page)->order($order)->select();
		foreach ($lists as $k=>$v){
			$mlist[]=$this->movieChange($v);
		}
		return $mlist;
	}
	
	public function newsPage($category,$order,$limit,$status=1,$field=true){
		if($field=="true") $field = true;
		if(I('p')){
			$page = I('p');
		}else{
			$page = 1;
		}
		if(I('order')){
			$order=I('order').' desc';
		}
		$category=$this->getId($category);
		$map = $this->listPageMap($category);
		$lists = M("News")->field($field)->where($map)->limit($limit)->page($page)->order($order)->select();
		foreach ($lists as $k=>$v){
			$mlist[]=$this->movieChange($v,'news');
		}
		return $mlist;
	}
	/**
	 * 获取文档列表
	 * @param  integer  $category 分类ID
	 * @param  string   $order    排序规则
	 * @param  integer  $status   状态
	 * @param  string   $field    字段 true-所有字段
	 * @return array              文档列表
	 */
	public function search($order,$limit,$status=1,$field=true){
		if($field=="true") $field = true;
		if(I('p')){
			$page = I('p');
		}else{
			$page = 1;
		}
		if(I('order')){
			$order=I('order').' desc';
		}
		if(isset($_REQUEST['keyword'])){
            $where['title']  = array('like', '%'.I('keyword').'%');
			$where['actors']  = array('like', '%'.I('keyword').'%');
			$where['also_known_as']  = array('like', '%'.I('keyword').'%');
			$where['directors']  = array('like', '%'.I('keyword').'%');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
        }
        $map["status"] = 1;
		$map["display"] = 1;
		$lists = M("Movie")->field($field)->where($map)->limit($limit)->page($page)->order($order)->select();
		foreach ($lists as $k=>$v){
			$mlist[]=$this->movieChange($v);
		}
		return $mlist;
	}
	
	public function listCount($cid){
		$cid=$this->getId($cid);
		$map = $this->listPageMap($cid);
		return M("Movie")->where($map)->count("id");
	}
	
	public function newsCount($cid){
		$map = array('status' => 1, 'display' => 1);
		if(!empty($cid)){
			$map['category'] = $cid;
		}
		return M("News")->where($map)->count("id");
	}
	
	public function searchCount(){
		if(isset($_REQUEST['keyword'])){
            $where['title']  = array('like', '%'.I('keyword').'%');
			$where['actors']  = array('like', '%'.I('keyword').'%');
			$where['also_known_as']  = array('like', '%'.I('keyword').'%');
			$where['directors']  = array('like', '%'.I('keyword').'%');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
        }
		return M("Movie")->where($map)->count("id");
	}
	
	/**
	 * 设置where查询条件
	 * @param  number  $category 分类ID
	 * @return array             查询条件
	 */
	private function listPageMap($category){
		/* 设置状态 */
		$map = array('status' => 1, 'display' => 1);
		/* 设置分类 */
		if(!empty($category)){
			if(is_numeric($category)){
				$map['category'] = $category;
			} else {
				$map['category'] = array('in', $this->str2arr($category));
			}
		}
		if(I('year')){
			$map['year']=I('year');
		}
		if(I('area')){
			$map['area']=I('area');
		}
		if(I('language')){
			$map['language']=I('language');
		}
		return $map;
	}
	
	 /**
	 * 设置where查询条件
	 * @param  number  $category 分类ID
	 * @param  number  $pos      推荐位
	 * @param  integer $status   状态
	 * @return array             查询条件
	 */
	private function listMap($category, $status = 1, $pos = null){
		/* 设置状态 */
		$map = array('status' => $status, 'display' => 1);
		/* 设置分类 */
		if(!empty($category)){
			if(is_numeric($category)){
				$map['category'] = $category;
			} else {
				$map['category'] = array('in', $this->str2arr($category));
			}
		}
		/* 设置推荐位 */
		if(is_numeric($pos)){
			$map[] = "position & {$pos} = {$pos}";
		}
		return $map;
	}


	/**
	 * 获取指定分类和下级分类
	 * @param  integer $id    分类ID
	 * @param  boolean $field 查询字段
	 * @return array
	 */
	public function getId($id){
		if($id=="all"){
			return false;
		}
		$map["status"] = 1;
		$map["display"] = 1;
		if($id){
			foreach ($this->str2arr($id) as $k=>$v){
				$map["pid"] = $v;
				$info = M("Category")->field("id")->where($map)->order('sort')->select();
				if($info){
					foreach ($info as $key=>$val){
						$ids[]=$val["id"];
					}
				}else{
					$ids[]=$v;
				}
			}
			return implode(',', $ids);
		}
	}
	
	
	public function typeTag($id){
		$id=$this->siblingsId($id);
		$map=$this->classUrl($name);
		$map['id']=$id;
		$where["status"] = 1;
		$where["display"] = 1;
		$where["navno"] = 1;
		$where["pid"] = $id;
		$lists=M("Category")->field('id,title,name')->where($where)->order('sort')->select();
		if($lists){
			if(C("WEB_PATTEM")==3) $map['name']=get_category_name($id);
			$typeTag[]=array("id"=>$id,"title"=>'全部',"url"=>url_change('lists/lists',$map));
			foreach ($lists as $key=>$val){
				$map['id']=$val['id'];
				if(C("WEB_PATTEM")==3) $map['name']=$val['name'];
				$typeTag[]=array("id"=>$val['id'],"title"=>$val['title'],"url"=>url_change('lists/lists',$map));
			}
		}
		return $typeTag;
	}
	
	public function classTag($id,$name){
			$map=$this->classUrl($name);
			if($id){
				$map['id']=$id;
			}
			if(C("WEB_PATTEM")==3) $map['name']=get_category_name($map['id']);
			$classTag[]=array("title"=>'全部',"url"=>url_change('lists/lists',$map));
		foreach (C('MOVIE_'.$name) as $key=>$val){
			$map[strtolower($name)]=$val;
			$classTag[]=array("title"=>$val,"url"=>url_change('lists/lists',$map));
		}
		return $classTag;
	}
	
	public function playlistTag($id,$order){
		$id   = empty($id)?D("Movie")->getmid(I('pid')):$id;
		return D('Movie')->playInfo($id,$order);
	}
	
	public function LinkTag($limit){
		$map["status"] = 1;
		$info = M("Link")->field("title,url")->where($map)->limit($limit)->order('sort')->select();
		return $info;
	}
	
	public function movieChange($date,$type='movie',$hits=0){
		$date["cid"]=$date["category"];
		$date["ctitle"]=get_category($date["category"]);
		$date["curl"]=url_change("lists/index",array("id"=>$date["category"],"name"=>get_category_name($date["category"])));
		if($type=="movie"){
			$date["actors_array"]=$this->actorsUrl($date["actors"]);
			$date["favorites"]="onclick=movie_favorites('".$date["id"]."')";
		}
		$date["pic"]=get_cover($date["cover_id"],"path");
		$date["url"]=url_change($type."/index",array("id"=>$date["id"],"name"=>$type));
		$date["time"]=time_format($date["update_time"],'Y-m-d');
		$date["content"]=htmlspecialchars_decode($date["content"]);
		$date["digg"]=array("up"=>$date["up"],"down"=>$date["down"],"up_js"=>"onclick=digg('".$date["id"]."','up','".$type."')","down_js"=>"onclick=digg('".$date["id"]."','down','".$type."')");
		if(C("WEB_PATTEM")==2 and $hits>0){
			$date["digg"]["up"]="<span id='digg_up'></span>";
			$date["digg"]["down"]="<span id='digg_down'></span>";
			$date["hits"]="<span id='hits' model='".$type."' hits='".$hits."'></span>";
		}
		unset($date["category"],$date["status"],$date["reurl"],$date["display"],$date["cover_id"],$date["update_time"],$date["up"],$date["down"]);
		return $date;
	}
	
	private function actorsUrl($actors){
		$actors=explode(",",$actors);
		foreach($actors as $key=>$value){
			$date[$key]["actors"]=$value;
			$date[$key]["url"]=url_change("Search/index",array("keyword"=>$value));
		}
		return $date;
	}
	
	private function classUrl($name){
		$map['id']=I('id');
		$map['year']=I('year');
		$map['area']=I('area');
		$map['language']=I('language');
		$map['order']=I('order');
		unset($map[strtolower($name)]);
		return $map;
	}
	
	private function str2arr($str, $glue = ','){
    	return explode($glue, $str);
	}
	
	private function getbranch($category,$type,$field=true){
		if($field=="true") $field = true;
		$map["status"] = 1;
		$map["display"] = 1;
		$map["pid"] = $category;
		if($type) $map["type"] = $type;
		$Count=M("Category")->field($field)->where($map)->Count();
		if($Count>0){
			return 1;
		}else{
			return 0;
		}
	}
	private function siblingsId($id){
		$pid=M("Category")->where('id='.$id)->getField('pid');
		if($pid==0){
			return $id;
		}
			return $pid;
	}
}
