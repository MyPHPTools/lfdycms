$(function(){
	//ajax get请求
    $('.ajax-get').click(function(){
        var target;
        var that = this;
        if ( $(this).hasClass('confirm') ) {
            if(!confirm('确认要执行该操作吗?')){
                return false;
            }
        }
        if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
            $.get(target).success(function(data){
                if (data.status==1) {
                    if (data.url) {
                        updateAlert(data.info + ' 页面即将自动跳转~','alert-green');
                    }else{
                        updateAlert(data.info,'alert-green');
                    }
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else if( $(that).hasClass('no-refresh')){
                            updateAlert();
							var callback = $(that).attr('callback');
							if(callback){
								eval(callback);
							}
                        }else{
                            location.reload();
                        }
                    },2000);
                }else{
                    updateAlert(data.info,'alert-red');
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else{
                            updateAlert();
                        }
                    },2000);
                }
            });

        }
        return false;
    });
	//ajax post submit请求
    $('.ajax-post').click(function(){
        var target,query,form;
        var target_form = $(this).attr('target-form');
        var that = this;
        var nead_confirm=false;
        if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
            form = $('.'+target_form);

            if ($(this).attr('hide-data') === 'true'){//无数据时也可以使用的功能
            	form = $('.hide-data');
            	query = form.serialize();
            }else if (form.get(0)==undefined){
            	return false;
            }else if ( form.get(0).nodeName=='FORM' ){
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                if($(this).attr('url') !== undefined){
                	target = $(this).attr('url');
                }else{
                	target = form.get(0).action;
                }
                query = form.serialize();
            }else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
                form.each(function(k,v){
                    if(v.type=='checkbox' && v.checked==true){
                        nead_confirm = true;
                    }
                })
                if ( nead_confirm && $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.serialize();
            }else{
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.find('input,select,textarea').serialize();
            }
            $(that).attr('autocomplete','off').prop('disabled',true);
            $.post(target,query).success(function(data){
                if (data.status==1) {
                    if (data.url) {
                        updateAlert(data.info + ' 页面即将自动跳转~','alert-green');
                    }else{
                        updateAlert(data.info ,'alert-green');
                    }
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else if( $(that).hasClass('no-refresh')){
							updateAlert();
                            $(that).prop('disabled',false);
							var callback = $(that).attr('callback');
							if(callback){
								eval(callback);
							}
                        }else{
                            location.reload();
                        }
                    },2000);
                }else{
                    updateAlert(data.info,'alert-red');
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else{
                            updateAlert();
                            $(that).prop('disabled',false);
                        }
                    },2000);
                }
            });
        }
        return false;
    });
	/**顶部警告栏*/
	var top_alert = $('#top-alert');
    window.updateAlert = function (text,c) {
		text = text||'default';
		c = c||false;
		if ( text!='default' ) {
            top_alert.text(text);
			if (top_alert.hasClass('show')) {
			} else {
				top_alert.addClass('show').removeClass('hidden').slideDown(200);
				// content.animate({paddingTop:'+=55'},200);
			}
		} else {
			if (top_alert.hasClass('show')) {
				top_alert.removeClass('show').addClass('hidden').slideUp(200);
				// content.animate({paddingTop:'-=55'},200);
			}
		}
		if ( c!=false ) {
            top_alert.removeClass('alert-red alert-yellow alert-blue alert-green').addClass(c);
		}
	};
	$('.addurl').click(function(){
		var movie_url=$('[id=movieurl]:last');
		var movie_url_html=movie_url.prop('outerHTML');
		var movie_url_number=$('[id=movieurl]').size();
		movie_url_html = movie_url_html.replace('播放地址'+movie_url_number,'播放地址'+(movie_url_number+1));
		onclick='deltr("+_len+")'
		$('[id=movieurl]:last').after(movie_url_html);
		$('[id=movieurl]:last button').attr('onclick','removeurl(this)').addClass('icon-minus delurl').removeClass('icon-plus addurl').text(' 删除这组播放地址');
		$('[id=movieurl]:last select').val($('[id=movieurl]:last select option').val());
		$('[id=movieurl]:last input').val('0');
		$('[id=movieurl]:last textarea').val('');
	});
	window.removeurl=function(obj){
		$(obj).parents('[id=movieurl]').remove();
	};
	window.removebind=function(obj,cid){
		var sval=$(obj).prev('select[name="category"]').val();
		if(sval){
			$('#bing_'+cid).html('<span class="text-green icon-check"></span>已绑定');
		}else{
			$('#bing_'+cid).html('<span class="text-red icon-times"></span>未绑定');
		}
		$(obj).parent().remove();
		$('.dialog-mask').remove();
	};
	window.removepbind=function(obj,pid){
		var sval=$(obj).prev('select[name="bpname"]').val();
		if(sval){
			$('#pbing_'+pid).html('<span class="text-green icon-check"></span>已绑定');
		}else{
			$('#pbing_'+pid).html('<span class="text-red icon-times"></span>未绑定');
		}
		$(obj).parent().remove();
		$('.dialog-mask').remove();
	};
});
window.setValue = function (name, value){
	var first = name.substr(0,1), input, i = 0, val;
	if(value === "") return;
	if("#" === first || "." === first){
		input = $(name);
	} else {
		input = $("[name='" + name + "']");
	}

	if(input.eq(0).is(":radio")) { //单选按钮
		input.filter("[value='" + value + "']").each(function(){this.checked = true});
	} else if(input.eq(0).is(":checkbox")) { //复选框
		if(!$.isArray(value)){
			val = new Array();
			val[0] = value;
		} else {
			val = value;
		}
		for(i = 0, len = val.length; i < len; i++){
			input.filter("[value='" + val[i] + "']").each(function(){this.checked = true});
		}
	} else {  //其他表单选项直接设置值
		input.val(value);
	}
};
var dialog = {
	show:function(){
		if($('.dialog-mask').length == 0){
		var masklayout=$('<div class="dialog-mask"></div>');
		$("body").append(masklayout);
		detail='<div class="dialog-win" style="position:fixed;width:60%;z-index:11;">'+$("#mydialog").html()+'</div>';
		var win=$(detail);
		win.find(".dialog").addClass("open");
		$("body").append(win);
		var x=parseInt($(window).width()-win.outerWidth())/2;
		var y=parseInt($(window).height()-win.outerHeight())/2;
		if (y<=10){y="10"}
		win.css({"left":x,"top":y});
		win.find(".dialog-close,.close").each(function(){
			$(this).click(function(){
				win.remove();
				$('.dialog-mask').remove();
				$('.list-group').find('li').remove();
				$('.step').addClass('hidden').removeClass('show');
				step_num=0;
				stopAjax();
			});
		});
		}
	},
	hide:function(){
		$('dialog-win').remove();
		$('.dialog-mask').remove();
		$('.list-group').find('li').remove();
		$('.step').addClass('hidden').removeClass('show');
		step_num=0;
		stopAjax();
	}
}
var currentAjax = null;
function ajaxjson(url,page){
	if(page==1){
		dialog.show();
	}
	currentAjax=$.getJSON(idchecked(url),function(data){
		$("span.num").text(data.num.pagesize*(page-1)+data.num.i);
		$("span.count").text(data.num.count);
		var bfb=(page/data.num.page*100).toFixed(1)+"%";
		$(".progress-bar").width(bfb).text("进度："+bfb);
		for(var i in data.video){
			if($(".list-group li").length==200){
				$(".list-group").html('<li>'+data.video[i].title+'<span class="float-right tag bg-green">'+data.video[i].content+'</span></li>');
			}
			$(".list-group").prepend('<li>'+data.video[i].title+'<span class="float-right tag bg-green">'+data.video[i].content+'</span></li>');   
		}
		if(page<data.num.page){
			page++;
			url=replaceParamVal(url,'p',page);
			ajaxjson(url,page);
		}else{
			if(data.num.n!=null){
				url=replaceParamVal(url,'p',1);
				url=replaceParamVal(url,'n',data.num.n);
				ajaxjson(url,1);
			}else{
				step_num++;
				step();
				if(data.url){
					ajaxjson(data.url,1);
				}else{
					if($("#time").length>0){
						$.get("index.php?s=/Home/Createl/delHtml.html");
					}else{
						$.get("index.php?s=/Admin/Collect/delCollect.html");
					}
					$(".list-group").prepend('<li class="text-center text-red">完毕</li>'); 
				}
			}
		}
	});
};

function stopAjax(){  
    if(currentAjax) {currentAjax.abort();}  
}  

function idchecked(url){
	var str="";
	var arrChk=$("input[name='id[]']:checked");
	if($(arrChk).size()){
		$(arrChk).each(function(i){
			if(i>0){
				str += ",";
			}
			str += $(this).val();                        
		}); 
		return url+"&id="+str;
	}else{
		return url;
	}
}

function create_html(url,name,id,page){
	ajaxjson(url+"&"+name+"="+$(id).val(),page);
}

function create_all_html(url){
	$('.step').addClass('show').removeClass('hidden');
	step();
	ajaxjson(url+"&id=all&all=all",1);
}

function replaceParamVal(url,name,val) {
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)|(^|\/)"+ name +"\/([^\/]*)");
	var r = url.match(reg);
	if (r!=null){
		url=url.replace(r[0],"&"+name+"="+val);
	}else{
		url+="&"+name+"="+val;
	}
	return url;
}

var step_num=0;
function step(){
	$('.step').find('div:eq('+step_num+')').prev().addClass('complete').removeClass('active').find('.step-point').addClass('icon-check').text('');
	$('.step').find('div:eq('+step_num+')').addClass('active');
}

var movie = {
	show:function(){
		if($('.dialog-mask').length == 0){
			var masklayout=$('<div class="dialog-mask"></div>');
			$("body").append(masklayout);
			detail='<div class="dialog-win" style="position:fixed;width:60%;z-index:11;">'+$("#dialogmovie").html()+'</div>';
			var win=$(detail);
			win.find(".dialog").addClass("open");
			$("body").append(win);
			win.find(".tb .drop").hide();
			var x=parseInt($(window).width()-win.outerWidth())/2;
			var y=parseInt($(window).height()-win.outerHeight())/2;
			if (y<=10){y="10"}
			win.css({"left":x,"top":y});
			win.find(".dialog-close,.close").each(function(){
				$(this).click(function(){
					win.remove();
					$('.dialog-mask').remove();
					stopAjax();
				});
			});
			win.find(".tb").each(function(){
				$(this).find("H4").children().hover(function(){
					win.find(".tb .drop").show();
				},function(){
					win.find(".tb .drop").hide();
				});
			});
		}
	},
	hide:function(){
		$('dialog-win').remove();
		$('.dialog-mask').remove();
		stopAjax();
	}
}
var play=null,playurl=null,playname=null;
function ajaxmoviejson(url){
	movie.show();
	$("[id^='movie_']").text('');
	$("[id='movie_title']").text('加载中请稍后…');
	$(".tb .drop-menu").empty();
	$("[id='Ajax_Content']").empty();
	currentAjax=$.getJSON(url,function(data){
		for(var x in data){
			//alert(x+"="+data[x]);
			if(x=='pic'){
				$("[id='movie_"+x+"']").attr('src',data[x]);
			}else if(x=='play'){
				play=data[x];
				playname=play[0]['name'];
				playurl=play[0]['url'].split("\r");
				for(var i=0; i<data[x].length; i++){
					$(".tb .drop-menu").append("<li><a  href=\"javascript:void(0)\" onclick=\"playtype("+i+")\">"+data[x][i]['name']+"</a></li>");
				}
				var currentPage=1;
				_$Pages(currentPage);
			}else if(x=='last'){
				$("[id='movie_"+x+"']").text(new Date(parseInt(data[x]) * 1000).toLocaleString());
			}else{
				$("[id='movie_"+x+"']").text(data[x]);
			}
		}
	});
}
function playtype(type){
	$(".tb .drop").hide();
	playname=play[type]['name'];
	playurl=play[type]['url'].split("\r");
	var currentPage=1;
	_$Pages(currentPage);
}

function next(){
	_$Pages(currentPage+1);
}
function previous(){
	_$Pages(currentPage-1);
}
function _$Pages(_i) {
	$('.tb LABEL').text(playname);
	currentPage=_i
	if((currentPage*5)>playurl.length){
		var Page=playurl.length;
	}else{
		var Page=currentPage*5;
	}
	ajax_url="<ul>";
	for(var i =(currentPage-1)*5; i < Page; i++)
	 {
		playUrl=playurl[i].split("$");
		if(playUrl[0]){
			ajax_url+="<li style=\"width: 10%;FLOAT: left;white-space:nowrap;text-overflow:ellipsis;overflow: hidden;\">"+playUrl[0]+"</li>";
		}else{
			ajax_url+="<li style=\"width: 10%;FLOAT: left;\">第"+(i+1)+"集</li>";
		}
		ajax_url+="<li style=\"width: 75%;FLOAT: left;text-overflow:ellipsis; overflow:hidden; white-space:nowrap\">"+playUrl[1]+"</li>";
		ajax_url+="<li style=\"width: 10%;FLOAT: left;text-align:center;\"><a href=\"javascript:ajaxpalyer('/index.php?s=/Admin/Collect/player/url/"+playUrl[1].replace('//','@').replace(/\//g,'~')+"/type/"+playname+"')\">播放</a></li>";
	 }
	ajax_url+="</ul>";
	$("[id='Ajax_Content']").html(ajax_url);
	_$InitPages(currentPage);
}

function _$InitPages(currentPage) {
		var pageSizeCount =Math.ceil(playurl.length/5);
		var strDisplayPagenation="<ul class=\"pagination pagination-small\">";
		strDisplayPagenation+="<li class=\"float-right\"><a>共" + pageSizeCount + "页 当前"+ currentPage +"页</a></li>";
		if(currentPage&&currentPage!=1)
			strDisplayPagenation+='<li><a href="javascript:void(0)" onclick="previous()">上一页</a></li>';
		else
			strDisplayPagenation+="<li class=\"disabled\"><a href=\"#\">上一页</a></li>";
		if(currentPage&&currentPage!=pageSizeCount)
			strDisplayPagenation+='<li><a href="javascript:void(0)" onclick="next()">下一页</a></li>';
		else
			strDisplayPagenation+="<li class=\"disabled\"><a href=\"#\">下一页</a></li>";
		strDisplayPagenation+="</ul>";
		$("[id='Pages']").html(strDisplayPagenation);
}

var player = {
	show:function(){
		detail='<div class="dialog-win" style="position:fixed;width:60%;z-index:12;">'+$("#dialogplayer").html()+'</div>';
		var win=$(detail);
		win.find(".dialog").addClass("open");
		$("body").append(win);
		var x=parseInt($(window).width()-win.outerWidth())/2;
		var y=parseInt($(window).height()-win.outerHeight())/2;
		if (y<=10){y="10"}
		win.css({"left":x,"top":y});
		win.find(".dialog-close,.close").each(function(){
			$(this).click(function(){
				win.remove();
			});
		});
	},
	hide:function(){
		$('dialog-win').remove();
	}
}
function ajaxpalyer(url){
	player.show();
	$("[id='cplayer']").attr('src',url);

}
function highlight_subnav(url){
    $('.sub-nav').find('a[href="'+url+'"]').parent().addClass("active");
}