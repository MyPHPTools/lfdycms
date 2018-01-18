<?php
namespace Home\Controller;
class PlayerController extends HomeController {
    public function index(){
		$id=D("Movie")->getmid(I('pid'));
		$info=D("Movie")->detail($id);
		if(!$info){
			$error = D("Movie")->getError();
        	$this->error(empty($error) ? '未知错误！' : $error);
		}
		$info=D("Tag")->movieChange($info,'movie',2);
		$tpl=D("Category")->getTpl($info['cid'],'template_play');
		if(!$tpl){
			$error = D("Category")->getError();
        	$this->error(empty($error) ? '未知错误！' : $error);
		}
		$this->assign('pos',1);
		$this->assign($info);
		$payer_vip=D("Movie")->getPlayerVip(I('pid'));
		if($payer_vip){
			if(UID){
				if($this->user['vip_time']<time()){
					$this->error('VIP已过期，请续费',U('Home/Other/index/tpl/vip'),5);
				}
			}else{
				$this->error('还未登录',U('User/Public/login'),5);
			}
		}
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display(".".$this->tplpath."/".$tpl);
    }
	
	public function player(){
		$pid=I('pid');
		$id=D("Movie")->getmid($pid);
		$n=I('n');
		$info=D("Movie")->detail($id);
		if(C('USER_ALLOW_PLAY')==1 && C('USER_PLAY_COUNT')>1 && UID){
			$map['user_id']=UID;
			$map['type']=2;
			$map['action_id']=M('Action')->getFieldByName('users_play','id');
			$map['create_time']=array('gt', strtotime("-24 hours"));
			$count=M('ActionLog')->where($map)->count();
			if($count<=C('USER_PLAY_COUNT')){
				$this->player_recom=1;
			}
		}
		$record_on=M('category')->where(array('id'=>$info['category']))->getField('record');
		$info['url']=url_change("movie/index",array("id"=>$id,"name"=>'movie'));
		$this->assign("movie",$info);
		$this->assign("record_on",$record_on);
		$this->assign("player",D('Movie')->getPlayer($id,$pid,$n));
		$this->display("Public/Player/player.html");
	}

	public function down(){
		$pid=I('pid');
		$n=I('n');
		$payer_vip=D("Movie")->getPlayerVip(I('pid'));
		if($payer_vip){
			if(UID){
				if($this->user['vip_time']<time()){
					$this->error('VIP已过期，请续费',U('Home/Other/index/tpl/vip'),5);
				}
			}else{
				$this->error('还未登录','User/Public/login',5);
			}
		}
		$downUrl=D('Movie')->getPlayerUrl($pid,$n);
		$this->assign("downurl",$downUrl);
		$this->display("Public/Player/down.html");
	}

	public function vip(){
		if(UID){
			if($this->user['vip_time']>=time()){
				$info=array('code'=>1,'msg'=>'可以观看');
			}else{
				$info=array('code'=>3,'msg'=>'VIP已过期，请续费','url'=>U('Home/Other/index/tpl/vip'));
			}
		}else{
			$info=array('code'=>2,'msg'=>'还未登录','url'=>U('User/Public/login'));
		}
		$this->ajaxReturn($info);
	}
}