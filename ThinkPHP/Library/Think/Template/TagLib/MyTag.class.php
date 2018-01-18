<?php
namespace Think\Template\TagLib;
use Think\Template\TagLib;
defined('THINK_PATH') or exit();

class MyTag extends TagLib{
	/**
	 * 定义标签列表
	 * @var array
	 */
	protected $tags   =  array(
		'nav'       => array('attr' => 'name,cid,type,limit,field', 'close' => 1,'level'=>3),
		'slider'    => array('attr' => 'name,limit,field', 'close' => 1,'level'=>1),
		'type'		=> array('attr' => 'name', 'close' => 1),
		'area'      => array('attr' => 'name', 'close' => 1),
		'language'  => array('attr' => 'name', 'close' => 1),
		'year'      => array('attr' => 'name', 'close' => 1),
		'weblink'   => array('attr' => 'name,limit', 'close' => 1),
		'page'    	=> array('attr' => 'listrow', 'close' => 0), //列表分页
		'count'    	=> array('attr' => 'cid', 'close' => 0), //分类内容数量
		'list'     	=> array('attr' => 'name,cid,order,pos,limit,field', 'close' => 1,'level'=>3), //获取指定分类列表
		'listpage'  => array('attr' => 'name,cid,order,limit,field', 'close' => 1,'level'=>1), //获取指定分类列表
		'news'      => array('attr' => 'name,cid,order,pos,limit,field', 'close' => 1,'level'=>3), //获取指定分类列表
		'newspage'  => array('attr' => 'name,cid,order,limit,field', 'close' => 1,'level'=>1), //获取指定分类列表
		'search'    => array('attr' => 'name,order,limit,field', 'close' => 1,'level'=>1), //获取指定分类列表
		'playlist'  => array('attr' => 'name,order', 'close' => 1), //获取指定分类列表
		'player'    => array('close' => 0), //播放器
		'comment'   => array('attr' => 'size,limit', 'close' => 0), //评论
	);
	
	public function _nav($tag, $content){
        $category  = empty($tag['cid']) ? '0' : $tag['cid'];
		$type    = empty($tag['type']) ? 0 : $tag['type'];
		$limit    = empty($tag['limit']) ? '' : $tag['limit'];
		$field  = empty($tag['field']) ? 'id,title,name,pid,link' : $tag['field'];
        $parse  = $parse   = '<?php ';
        $parse .= '$__NAV__ = D(\'Tag\')->getNav('.$category.',"'.$limit.'",'.$type.',"'.$field.'");';
        $parse .= '?><volist name="__NAV__" id="'. $tag['name'] .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }
    public function _slider($tag, $content){
		$limit    = empty($tag['limit']) ? '""' : $tag['limit'];
		$field  = empty($tag['field']) ? 'id,title,cover_id,link' : $tag['field'];
        $parse  = $parse   = '<?php ';
        if(is_mobile()){
        	$parse .= '$__SLIDER__ = D(\'Tag\')->getSlider('.$limit.',"'.$field.'",2);';
    	}else{
    		$parse .= '$__SLIDER__ = D(\'Tag\')->getSlider('.$limit.',"'.$field.'");';
    	}
        $parse .= '?><volist name="__SLIDER__" id="'. $tag['name'] .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }
	public function _area($tag, $content){
        return  $this->_classtag($tag,$content,'AREA');
    }
	public function _language($tag, $content){
        return  $this->_classtag($tag,$content,'LANGUAGE');
    }
	public function _year($tag, $content){
        return  $this->_classtag($tag,$content,'YEAR');
    }

	public function _list($tag, $content){
		$name   = $tag['name'];
		$category   = empty($tag['cid']) ? '$cid' : $tag['cid'];
		if(!$category){
			$category   = "''";
		}
		if(strstr($category,',')){
			$category ="'".$category."'";
		}
		$limit    = empty($tag['limit']) ? '' : $tag['limit'];
		$field  = empty($tag['field']) ? 'true' : $tag['field'];
		$order  = empty($tag['order']) ? '`id` DESC' : $tag['order'];
		$pos  = empty($tag['pos']) ? null : $tag['pos'];

		$parse  = '<?php ';
		$parse .= '$__LIST__ = D(\'Tag\')->lists(';
		$parse .= $category.', "'.$order.'","'.$limit.'", 1,"'.$field.'"';
		if($pos){
			$parse .= ',$pos';
		}
		$parse .=  ');';
		$parse .= ' ?>';
		$parse .= '<volist name="__LIST__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	
	public function _listpage($tag, $content){
		global $limit;
		$name   = $tag['name'];
		$category   = empty($tag['cid']) ? '$cid' : $tag['cid'];
		if(!$category){
			$category   = "''";
		}
		$limit    = empty($tag['limit']) ? '10' : $tag['limit'];
		$field  = empty($tag['field']) ? 'true' : $tag['field'];
		$order  = empty($tag['order']) ? '`id` DESC' : $tag['order'];
		$pos  = empty($tag['pos']) ? null : $tag['pos'];
		$parse  = '<?php ';
		$parse .= '$__LIST__ = D(\'Tag\')->listspage(';
		$parse .= $category.', "'.$order.'","'.$limit.'", 1,"'.$field.'"';
		if($pos){
			$parse .= ',$pos';
		}
		$parse .=  ');';
		$parse .= ' ?>';
		$parse .= '<volist name="__LIST__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	
	public function _news($tag, $content){
		$name   = $tag['name'];
		$category   = empty($tag['cid']) ? '$cid' : $tag['cid'];
		if(!$category){
			$category   = "''";
		}
		if(strstr($category,',')){
			$category ="'".$category."'";
		}
		$limit    = empty($tag['limit']) ? '' : $tag['limit'];
		$field  = empty($tag['field']) ? 'true' : $tag['field'];
		$order  = empty($tag['order']) ? '`id` DESC' : $tag['order'];
		$pos  = empty($tag['pos']) ? null : $tag['pos'];

		$parse  = '<?php ';
		$parse .= '$__NEWS__ = D(\'Tag\')->news(';
		$parse .= $category.', "'.$order.'","'.$limit.'", 1,"'.$field.'"';
		if($pos){
			$parse .= ',$pos';
		}
		$parse .=  ');';
		$parse .= ' ?>';
		$parse .= '<volist name="__NEWS__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	
	public function _newspage($tag, $content){
		global $limit;
		$name   = $tag['name'];
		$category   = empty($tag['cid']) ? '$cid' : $tag['cid'];
		if(!$category){
			$category   = "''";
		}
		$limit    = empty($tag['limit']) ? '10' : $tag['limit'];
		$field  = empty($tag['field']) ? 'true' : $tag['field'];
		$order  = empty($tag['order']) ? '`id` DESC' : $tag['order'];
		$pos  = empty($tag['pos']) ? null : $tag['pos'];
		$parse  = '<?php ';
		$parse .= '$__NEWS__ = D(\'Tag\')->newspage(';
		$parse .= $category.', "'.$order.'","'.$limit.'", 1,"'.$field.'"';
		if($pos){
			$parse .= ',$pos';
		}
		$parse .=  ');';
		$parse .= ' ?>';
		$parse .= '<volist name="__NEWS__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	
	public function _search($tag, $content){
		$name   = $tag['name'];
		$limit    = empty($tag['limit']) ? '10' : $tag['limit'];
		$field  = empty($tag['field']) ? 'true' : $tag['field'];
		$order  = empty($tag['order']) ? '`id` DESC' : $tag['order'];
		$pos  = empty($tag['pos']) ? null : $tag['pos'];

		$parse  = '<?php ';
		$parse .= '$__LIST__ = D(\'Tag\')->search(';
		$parse .= '"'.$order.'","'.$limit.'", 1,"'.$field.'"';
		if($pos){
			$parse .= ',$pos';
		}
		$parse .=  ');';
		$parse .= ' ?>';
		$parse .= '<volist name="__LIST__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
		/* 列表数据分页 */
	public function _page($tag){
		$listrow = $tag['listrow'];
		$parse   = '<?php ';
		$parse  .= '$__PAGE__ = new \Think\Page($count, ' . $listrow . ',array("model"=>$model,"name"=>$cname,"id"=>$cid,"year"=>$cyear,"area"=>$carea,"language"=>$clanguage,"order"=>$order,"keyword"=>$keyword));';
		if(is_mobile()){
            $parse  .= '$__PAGE__->setConfig("prev","上一页");';
            $parse  .= '$__PAGE__->setConfig("next","下一页");';
            $parse  .= '$__PAGE__->setConfig("theme","%UP_PAGE% %DOWN_PAGE%");';
        }
		$parse  .= 'echo $__PAGE__->show();';
		$parse  .= ' ?>';
		return $parse;
	}
	
	public function _count($tag){
		$cid   = empty($tag['cid']) ? '$cid' : $tag['cid'];
		if(!$cid){
			$cid   = "''";
		}
		if(strstr($cid,',')){
			$cid ="'".$cid."'";
		}
		$parse   = '<?php ';
		$parse .= '$__COUNT__ = D(\'Tag\')->listCount('.$cid.');';
		$parse  .= 'echo $__COUNT__';
		$parse  .= ' ?>';
		return $parse;
	}
	
	public function _weblink($tag, $content){
		$name   = $tag['name'];
		$parse   = '<?php ';
		$parse  .= '$__LINK__ = D(\'Tag\')->linkTag(\'' . $tag['limit'] . '\'); ?>';
		$parse .= '<volist name="__LINK__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	public function _type($tag, $content){
		$name   = $tag['name'];
		$parse   = '<?php ';
		$id='$cid';
		$parse  .= '$__TYPE__ = D(\'Tag\')->typeTag('.$id.'); ?>';
		$parse .= '<volist name="__TYPE__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	protected function _classtag($tag, $content ,$class){
		$name   = $tag['name'];
		$parse   = '<?php ';
		$id='$cid';
		$parse  .= '$__'.$class.'__ = D(\'Tag\')->classTag('.$id.',\'' . $class . '\'); ?>';
		$parse .= '<volist name="__'.$class.'__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	public function _playlist($tag, $content){
		$name   = $tag['name'];
		$order   = $tag['order'];
		$id='$id';
		$parse   = '<?php ';
		$parse  .= '$__PLAYLIST__ = D(\'Tag\')->playlistTag('.$id.',\'' . $order . '\'); ?>';
		$parse .= '<volist name="__PLAYLIST__" id="'. $name .'">';
		$parse .= $content;
		$parse .= '</volist>';
		return $parse;
	}
	public function _player($content){
		$parse= '<iframe id="playeriframe" name="playeriframe" src="" MARGINWIDTH=0 MARGINHEIGHT=0 HSPACE=0 VSPACE=0 FRAMEBORDER=0 SCROLLING=no width="100%" height="100%"></iframe>';
		$parse.='<script language="javascript">';
		if(C("WEB_PATTEM")==2 and C("HTML_PLAYER")==1){
			$parse.='var url=location.search;';
			$parse.='var Request = new Object();';
			$parse.='if(url.indexOf("?")!=-1){';
			$parse.='var str = url.substr(1);'; 
			$parse.='strs= str.split("&");'; 
			$parse.='for(var i=0;i<strs.length;i++){';
			$parse.='Request[strs[i].split("=")[0]]=(strs[i].split("=")[1]);'; 
			$parse.='}';
			$parse.='}'; 
			$parse.= 'var playerobj=document.getElementById("playeriframe");';
			$parse.= 'playerobj.src="/index.php?s=/Home/player/player/pid/"+Request["pid"]+"/n/"+Request["n"]+".html";';
		}else{
			$parse.= 'var playerobj=document.getElementById("playeriframe");';
			$parse.= 'playerobj.src="/index.php?s=/home/player/player/pid/{:I(\'pid\')}/n/{:I(\'n\')}.html";';
		}
		$parse.='</script>';
		return $parse;
	}

	public function _comment($tag, $content){
		$limit    = empty($tag['limit']) ? '5' : $tag['limit'];
		$size    = empty($tag['size']) ? '14' : $tag['size'];
		$parse='<iframe id="comment" scrolling="no" frameborder="0" style="height: 571px; display: block !important; width: 100% !important; border: 0px none !important; overflow: hidden !important;" src="/index.php?s=/Home/Comment/index/id/{$id}/limit/'.$limit.'/size/'.$size.'"></iframe>';
		return $parse;
	}

}