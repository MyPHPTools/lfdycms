<?php
namespace Home\Model;
use Think\Model;

class MovieModel extends Model{
	/**
	 * 获取详情页数据
	 * @param  integer $id 文档ID
	 * @return array       详细数据
	 */
	public function detail($id){
		$info = $this->field(true)->find($id);
		if(!(is_array($info) || 1 !== $info['status'] || 1 !== $info['display'])){
			$this->error = '影片被禁用或已删除！';
			return false;
		}
		return $info;
	}

	public function getmid($id){
		return M('movie_url')->where('id='.$id)->getField('movie_id');
	}

	public function playInfo($id,$order='asc'){
		$prefix   = C('DB_PREFIX');
		$info=M("movie_url")->table($prefix.'movie_url url,'.$prefix.'player play')->where('url.movie_player_id=play.id and url.movie_id='.$id.' and play.display>0')->field('url.id,url.movie_url,url.movie_player_id,play.title,play.vip,play.type')->order("play.sort asc")->select();
		if(!(is_array($info))){
			$this->error = '影片播放地址已经被删除！';
			return false;
		}
		foreach($info as $key=>$value){
			if($order=='desc'){
				$info[$key]["movie_url"]=array_reverse($this->playReplace($value["movie_url"],$value["id"],$value["type"]));
			}else{
				$info[$key]["movie_url"]=$this->playReplace($value["movie_url"],$value["id"],$value["type"]);
			}
		}
		return $info;
	}

	public function playReplace($purl,$pid,$type){
		$purl=explode(chr(13),$purl);
		foreach($purl as $key=>$value){
			$play=explode('$',$value);
			$payurl[$key]["title"]=$play[0];
			if($type){
				$payurl[$key]["url"]=url_change("player/down",array("name"=>"down","pid"=>$pid,"n"=>$key+1));
			}else{
				$payurl[$key]["url"]=url_change("player/index",array("name"=>"player","pid"=>$pid,"n"=>$key+1));
			}
			$payurl[$key]["purl"]=$play[1];
			$payurl[$key]["vip_js"]="onclick=\"if(!player_vip()){return false;}\"";
		}
		return $payurl;
	}

	public function getPlayer($id,$pid,$n){
		$map['id']=$pid;
		$purl=M('Movie_url')->field(true)->where($map)->find();
		$map['id']=$purl['movie_player_id'];
		$map['display']=1;
		$player=M('Player')->field(true)->where($map)->find();
		if(!$player){
			$this->error = '影片播放器禁止播放！';
			return false;
		}
		$player["id"]=$purl["id"];
		$player["ptitle"]=$player["title"];
		$purl=explode(chr(13),$purl["movie_url"]);
		$play=explode('$',$purl[$n-1]);
		$player["title"]=$play[0];
		$player["url"]=$play[1];
		$play=explode('$',$purl[$n-2]);
		$player["prevurl"]=empty($play[1])?'':$play[1];
		$play=explode('$',$purl[$n]);
		$player["nexturl"]=empty($play[1])?'':$play[1];
		if($n>1){
			$lastplay=url_change("player/index",array("name"=>"player","pid"=>$pid,"n"=>$n-1));
		}
		if($n<count($purl)){
			$nextplay=url_change("player/index",array("name"=>"player","pid"=>$pid,"n"=>$n+1));
		}
		$player["player_code"]=str_replace(array('<$url>','<$lasturl>','<$nexturl>','<$lastplay>','<$nextplay>'),array($player["url"],$player["prevurl"],$player["nexturl"],$lastplay,$nextplay),htmlspecialchars_decode($player["player_code"]));
		unset($player['sort']);
		return $player;
	}

	public function getPlayerUrl($pid,$n){
		$map['id']=$pid;
		$purl=M('Movie_url')->field(true)->where($map)->find();
		$purl=explode(chr(13),$purl["movie_url"]);
		$play=explode('$',$purl[$n-1]);
		return $play[1];
	}

	public function getPlayerVip($id){
		$prefix   = C('DB_PREFIX');
		$info=M("movie_url")->table($prefix.'movie_url url,'.$prefix.'player play')->where('url.id='.$id.' and play.id=url.movie_player_id and play.display=1')->field('play.vip')->find();
		return $info['vip'];
	}

	public function hits($id){
		if(I('hits')==1){
			$this->where('id='.$id)->setInc('hits');
		}
		return $this->where('id='.$id)->field('hits,up,down')->find();
	}

	public function digg($id){
		$this->where('id='.$id)->setInc(I('digg'));
		return $this->where('id='.$id)->field('up,down')->find();
	}
}
