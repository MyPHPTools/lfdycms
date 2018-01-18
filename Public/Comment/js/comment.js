$(function(){
	var ThinkPHP = window.Think;
	var page=1;
	$(document).on('click',".ajaxpost",function(){
		var url;
		var target_form = $(this).attr('target-form');
		var form = $('.'+target_form);
		if (url = form.get(0).action) {
			query = form.serialize();
			$.post(url,query).success(function(data){
				 if (data.status==1) {
				 	if(window.Think.MOBILE=='web'){
						parent.layer.msg(data.info,{icon: 1,shade: 0.3},function(){
							location.reload();
						});
					}else{
						parent.layer.open({content: data.info,time: 2,end:function(){
							location.reload();
						}});
					}
				 }else{
				 	if(window.Think.MOBILE=='web'){
						parent.layer.msg(data.info,{icon: 0,shade: 0.3});
					}else{
						parent.layer.open({content: data.info,time: 2});
					}
				 }
			});
		}
		return false;
	});

	reply=function(obj,mid,pid){
		var html='<div class="uyanpost">';
		html+='<form method="post" action="'+ThinkPHP.U("Home/comment/add")+'" class="form-x-'+pid+'">';
		html+='<div class="resetbox sectionbox"><div class="blockbox">';
		html+='<div class="postarea"><div class="postborder">';
		html+='<div class="layui-form"><textarea style="height: 100px;box-shadow:none;border:1px solid #DFDFDF;box-sizing:border-box;padding:10px" name="content" id="LAY_desc"></textarea></div>';
		html+='</div><div style="display: block;text-align: right;margin-top:8px">';
		html+='<button class="btn btn-info ajaxpost" type="submit" target-form="form-x-'+pid+'">发 送</button>';
		html+='</div></div><input type="hidden" name="mid" value="'+mid+'">';
		html+='<input type="hidden" name="pid" value="'+pid+'"></div></div></form></div>';
		var postbox=$(obj).parents('.post-content').siblings('.uyan-reply-postbox');
		if(postbox.html()){
			postbox.empty();
		}else{
			postbox.append(html);
			gather.layEditor({
				elem: postbox.find('[id="LAY_desc"]')
			});
		}
		resize();
	}

	up=function(id){
		$.get(ThinkPHP.U("Home/comment/up","id="+id),function(data){
			if(window.Think.MOBILE=='web'){
				parent.layer.msg(data.info,{icon: data.status,shade: 0.3});
			}else{
				parent.layer.open({content: data.info,time: 2});
			}
		});
	}

	resize=function() {
		$("#comment", window.parent.document).css("height",$(document.body).height());
		setTimeout(function () { 
	        $("#comment", window.parent.document).css("height",$(document.body).height());
	    }, 500);
    }

	ajaxpage=function(){
		var y=0,list={};
		if((page*page_num)>trre.length){
			var comment_page=trre.length;
		}else{
			var comment_page=page*page_num;
		}
		for(var i =(page-1)*page_num; i < comment_page; i++){
			list[y]=trre[i];
			y++;
	 	}
	 	$.post(ThinkPHP.U("Home/comment/tree"),{tree:JSON.stringify(list),page:page,limit:page_num,count:count}).success(function(data){
	 		$('#posts').append(data);
	 		if((trre.length>page_num && comment_page!=trre.length)){
	 			page++;
	 			$('#loadmore').show();
	 			$('#loadmore').html('<a id="uyan-more" href="javascript:;" onclick="ajaxpage();" class="more"><span>加载更多评论</span></a>');
	 		}else{
	 			$('#loadmore').hide();
	 		}
	 		resize();
	 	});
	}
	ajaxpage();
})