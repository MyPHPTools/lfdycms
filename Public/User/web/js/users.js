$(function(){
		 
	setTimeout(function(){getMsg();}, 1000);
	
	$(".message").click(function(){
		layer.open({
			type: 2,
			area: ['590px', '520px'],
			fix: false, //不固定
			maxmin: true,
			content: $(this).attr('href')
		});
		return false;
	});
	
	function getMsg(){
		$.getJSON("index.php?s=/User/Message/message.html",function(data){
			addMsg(data);
		});
	}
	function addMsg(data){
		var msg;
		var $el = $('.nav-user');
		for (i in data['list']){
			msg = '<a href="'+data['list'][i]['url']+'" class="media list-group-item message">'+
					  '<span class="pull-left thumb text-center">'+
						'<img src="'+(data['list'][i]['userpath']?data['list'][i]['userpath']:'Public/User/images/user.jpg')+'" class="img-circle">'+
					  '</span>'+
					  '<span class="media-body m-b-none">'+
						data['list'][i]['title']+'<br>'+
						'<div class="text-muted">'+data['list'][i]['time']+'</div>'+
					  '</span>'+
					'</a>';
			$(msg).hide().prependTo($el.find('.list-group')).slideDown().css('display','block');
		}
		if(data['count']>0){
			$('.count', $el).fadeOut().fadeIn().text(data['count']);
		}
	}
})