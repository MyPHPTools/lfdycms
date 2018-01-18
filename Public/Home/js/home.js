$(function(){
	var ThinkPHP = window.Think;
	var hits=$("[id='hits']");
	if($(hits)){
		var model=$(hits).attr("model");
		var hits=$(hits).attr("hits");
	}
	if(ThinkPHP.CONTROLLER_NAME=="Movie" || ThinkPHP.CONTROLLER_NAME=="News"){
		var model=ThinkPHP.CONTROLLER_NAME;
		var hits=1;
		$.get(ThinkPHP.U("Home/"+model+"/hist","id="+ThinkPHP.ID+"&hits="+hits),function(date){
			if(ThinkPHP.PATTEM>1){
				$("[id='digg_up']").text(date.up);
				$("[id='digg_down']").text(date.down);
				$("[id='hits']").text(date.hits);
			}												   
		});
	}
	if(ThinkPHP.CONTROLLER_NAME=="Index"){
		var userID=getQueryString('userID');
		if(userID){
			$.get(ThinkPHP.U("User/Recom/rlink","uid="+userID),function(date){
				var str=date.split("|");
				if(ThinkPHP.MOBILE=="web"){
					layer.msg(str[1],{icon: str[0]});
				}else{
					layer.open({content: str[1],time: 2});
				}
			});
		}
	}

	movie_favorites=function(id){
		if(ThinkPHP.UID>0){
			$.get(ThinkPHP.U("User/Favorites/add","id="+id),function(date){
				if(ThinkPHP.MOBILE=="web"){
					layer.msg(date.msg,{icon: date.code});
				}else{
					layer.open({content: date.msg,time: 2});
				}
			});
		}else{
			if(ThinkPHP.MOBILE=="web"){
				layer.msg("请先登录后收藏！",{icon: 0});
			}else{
				layer.open({content: "请先登录后收藏！",time: 2});
			}
		}
		
	}

	player_vip=function(){
		var bol=false;
		$.ajax({ 
			type:"GET", 
			async:false, 
			url:ThinkPHP.U("Home/player/vip"),
			success:function(date){
				switch(date.code){
				case 1:
				  bol=true;
				  break;
				case 2:
				  	if(ThinkPHP.MOBILE=="web"){
						layer.msg(date.msg,{icon: 0});
					}else{
						layer.open({content: date.msg,time: 2});
					}
				  break;
				default:
					if(ThinkPHP.MOBILE=="web"){
						layer.msg(date.msg,{icon: 0});
					}else{
						layer.open({content: date.msg,time: 2});
					}
				}
			}
		});
		return bol;
	}
	digg=function(id,type,model){
		$.get(ThinkPHP.U("Home/"+model+"/digg","id="+id+"&digg="+type),function(date){
			if(date.error){
				if(ThinkPHP.MOBILE=="web"){
					layer.msg(date.error,{icon: 0});
				}else{
					layer.open({content: date.error,time: 2});
				}
			}else{
				$("[id='digg_up']").text(date.up);
				$("[id='digg_down']").text(date.down);
				digg_mag(type);
			}
		});
	}
	digg_mag=function(type){
		if(type=="up"){
			if(ThinkPHP.MOBILE=="web"){
				layer.msg("+1",{icon: 6});
			}else{
				layer.open({content: "+1",time: 2});
			}
		}else{
			if(ThinkPHP.MOBILE=="web"){
				layer.msg("+1",{icon: 5});
			}else{
				layer.open({content: "+1",time: 2});
			}
		}
	}
	function getQueryString(name){ 
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
		var r = window.location.search.substr(1).match(reg); 
		if (r != null) return unescape(r[2]);
		return null; 
	} 
})