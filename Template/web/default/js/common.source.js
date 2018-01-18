$(function(){
	var cookie_prefix= "lf_users_";
	var movHistory = Cookie.get(cookie_prefix+"movHistory");

	//首页内容切换
	$(".contabs").find("li").hover(function(){
		var tab_index = $(this).index();
		$(this).addClass("current").siblings("li").removeClass("current");
		$(this).parents(".ingrep").find(".ingrep-Cont").hide();
		$(this).parents(".ingrep").find(".ingrep-Cont").eq(tab_index).show();
		$(".ingrep-Cont").eq(tab_index).molazy();
	});

	//lazyload
	$("img[data-original]").lazyload({
		effect:"fadeIn",
		threshold : 200
	});
	$("a#collet").click(function(){
		AddFavorite(getRootPath(),$(document).attr("title")); return false;
	});

	//播放记录
	var history = {
		tar:"#hisStatu ul",
		del:function(index){
			if($(this.tar).find("li").size() == 0){
				var TPL = '<li id="noHis">您还没有观看记录~</li>';
				$(this.tar).html(TPL);
				Cookie.clear(cookie_prefix+"movHistory");
			}else{
				var hisArr = Cookie.get(cookie_prefix+"movHistory");
				hisArr=$.evalJSON(hisArr);
				var id = hisArr[index]['id'];
				hisArr.splice(index,1);
				hisJson = $.toJSON(hisArr);
				Cookie.set(cookie_prefix+"movHistory",hisJson);
				$.get(getRootPath()+'/index.php?s=/User/Record/remove/id/'+id+'.html');
			}
		},
		init:function(){
			if(!movHistory){
				var TPL = '<li id="noHis">您还没有观看记录~</li>';
				$(this.tar).html(TPL);
			}else{
				movHistory = $.evalJSON(movHistory);
				var hisHtm = '';
				$.each(movHistory, function (i,data){
					hisHtm += '<li id="'+data['id']+'"><a href="'+data['url']+'" target="_blank">'+data['title']+'</a><span><a href="'+data['purl']+'" target="_blank">继续看</a><a href="javascript:;" class="del">X</a></span></li>';
					if(i > 9) return false;
				});
				$(this.tar).html(hisHtm);
			};
		}
	};
	history.init();

	$(".hisCont").find("a.del").on("click", function(){
		$(this).parents("li").fadeOut(500,function(){
			index=$(this).index();							   
			$(this).remove();
			history.del(index);
		});
	});

	//回到顶部
	var gotoTop = {
		id: "#gotop",
		clickMe : function(){
			$('html,body').animate({scrollTop : '0px'},{ duration:500});
		},
		toggleMe : function() {
			if($(window).scrollTop() == 0) {
				$(this.id).stop().animate({'opacity': 0}, "slow");
			} else {
				$(this.id).stop().animate({'opacity': 1}, "slow");
			}
		},
		init : function() {
			$(this.id).css('opacity', 0);
			$(this.id).click(function(){
				gotoTop.clickMe();
				return false;
			});
			$(window).bind('scroll resize', function(){
				gotoTop.toggleMe();
			});
		}
	};
	gotoTop.init();

	//添加hover
	$(".history, .sumgroup li, .caseList li, .comcaseRow li, .spitMvList li, .gloComList li, .rowMvlist li, .usHistoryList li, .usform td span, .seleList ul li").hover(function(){
		$(this).addClass("hover");
	},function(){
		$(this).removeClass("hover");
	});
	$(".foldlist").find("li").hover(function(){
		$(this).addClass("hover").siblings("li").removeClass("hover");
		$(this).molazy();//触发延迟加载图片
	});
	$(".foldlist").find("li").eq(0).molazy();//分类内页边栏第一个加载;
	
	//{S:搜索框}
	var queryList;//隐藏搜索框建议
	var KeywordItems;
	var currentKey = 0;
	$(".queryList ul").on("mouseover",'li',function(){
		currentKey = $(this).index();
		$(this).addClass("hover").siblings("li").removeClass("hover");
		$(".tcont").eq($(this).index()).show().siblings(".tcont").hide();
	}).on("click",'li', function(){
		var kw = $(this).attr("data-title");
		$("#searchTxt").val(kw);
		$("#js-query-data").hide();
		//searchform();
		window.location.href=$("#searchform").attr("action")+"&keyword="+kw; 
		//return false;
	});
	$(".queryList").on("click",'a.goplay',function(){
		$("#js-query-data").hide();
		//return false;
	})
	$(".queryList").bind({
		mouseover:function(){
			queryList = true;
		},
		mouseout:function(){
			queryList = false;
		}
	});
	$("#searchform").submit(function(){
		searchform();
		$("#js-query-data").hide();
		return false;
	});
	var delaySearch;;
	$("#searchTxt").focus();
	$("#searchTxt").bind({
		keydown:function(){
			clearTimeout(delaySearch);
		},
		keyup:function(e){
			var e = e || event, keyCode = e.keyCode;
			var keyword =  $("#searchTxt").val();
			if(keyword == '') return;//搜索为空
			if(keyCode == 40){//down
				currentKey++;
				searchMod.selectItem();
			}else if(keyCode == 38){//up
				currentKey--;
				searchMod.selectItem();
			}else if(keyCode == 27){//esc
				$("#js-query-data").hide();
			}else{//query data
				if(keyword != ''){
					$(".search").append('<em class="serLoad"></em>');
				}
				delaySearch = setTimeout(function(){
					searchMod.queryData(keyword, function(){
						$("#js-query-data").show();
					});
				}, 500)
			}
		}
	});
	var searchMod = {
		queryData : function(value, callback){
			$.ajax({
				tpye:'post',
				url:getRootPath()+'/index.php?s=/Home/Ajax/searchTips.html',
				data:{'keyword':value},
				dataType:'json',
				success:function(data){
					var listTPL = '';
					var summTPL = '';
					if(data){
						for(var i = 0;i < data.length;i++){
							var actors = (data[i]['actors'] == '') ? '——' : data[i]['actors'];
									listTPL += '<li id="'+data[i]['id']+'" data-title="'+data[i]['title']+'">'+data[i]['title']+'<em></em></li>';
									summTPL += '<dl class="tcont"><dt><a href="'+data[i]['url']+'" target="_blank"><img src="'+data[i]['pic']+'" alt="'+data[i]['title']+'" /></a>'
									+'<div><p>'+data[i]['title']+'</p><p>主演：<span>'+actors+'</span></p></div></dt><dd>'
									+'<a href="'+data[i]['url']+'" class="goplay" target="_blank">立即播放</a></dd></dl>';
						}
						$("#js-calldata-list").html(listTPL).find("li").eq(0).addClass("hover");
						$("#js-calldata-preview").html(summTPL).find(".tcont").eq(0).show();
					}else{
						$("#js-calldata-list").html('<p>木有数据噢~试下其他关键字?</p>');
						$("#js-calldata-preview").html('');
					}
					$(".serLoad").remove();
				},
				error:function(){
					$("#js-calldata-list").html('<p>搜索数据请求错误，请稍后在试~</p>');
				}
			});
			if(callback){
				callback();
			}
		},
		selectItem:function(){
			KeywordItems = $("#js-calldata-list li")
	        if (!KeywordItems) return;
	        var len = KeywordItems.length;

	        if (currentKey < 0) {
	            currentKey = len - 1;
	        }
	        else if (currentKey >= len) {
	                currentKey = 0;
	        }
	        $("#searchTxt").val(KeywordItems.eq(currentKey).attr("data-title"));
	        KeywordItems.eq(currentKey).addClass('hover').siblings('li').removeClass('hover');
	        $(".tcont").eq(currentKey).show().siblings(".tcont").hide();
	    }
	}
	
	$(document).click(function(ele){
		if(!queryList){$(".queryList").hide();}
	});

	//详细页
	$(".playurl ul li").on("click", function(){
		$(this).addClass("current").siblings("li").removeClass();
		$(".playurl dd").eq($(this).index()).show().siblings(".playurl dd").hide();
	});
	if(typeof($(".playurl")[0]) != 'undefined'){
		$(".playurl dd").each(function(){
			var judhei = $(this).height();
			if(judhei >= 220){
				var emTPL ='<em class="swHiCh">展开更多↓</em>';
				$(this).addClass("stu").append(emTPL);
			};
		});
		$(".swHiCh").on("click",function(){
			$(this).parent().removeClass("stu");
			$(this).remove();
		});
		if($(".contSums").height() > 100){
			$(".contSums").css("height","100px");
			$(".contSums span").css("display","inline-block");
		};
	}
	$(".contSums span").click(function(){
		if($(this).find("i").attr("class") == 'cos'){
			$(".contSums").css("height","100px");
			$(".contSums span").find("i").removeClass("cos")
		}else{
			$(".contSums").css("height","auto");
			$(this).find("i").toggleClass("cos");
		}
	});
});
//ready end

function searchform(){
	var q = $('#searchTxt').val(), t = $('input[name=t]').val();
	if(t){
		self.location.href=$("#searchform").attr("action")+"&keyword="+q;  
	}else{
		self.location.href=$("#searchform").attr("action")+"&keyword="+q;
	}
};

function getRootPath(){
    var curWwwPath=window.document.location.href;
    var pathName=window.document.location.pathname;
    var pos=curWwwPath.indexOf(pathName);
    var localhostPaht=curWwwPath.substring(0,pos);
    var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
    return(localhostPaht+projectName);
}

//添加收藏
function AddFavorite(url,title){
    try{
        window.external.addFavorite(url, title);
    }
    catch(e){
        try{
            window.sidebar.addPanel(title, url, "");
        }
        catch(e){
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
};
function setHome(obj,hostname) {
    if (!$.browser.msie) {
        alert("您的浏览器不支持自动设置主页，请使用浏览器菜单手动设置。")
        return;
    }
    var host = hostname;
    if (!host) {
        host = window.location.href;
    }
    obj.style.behavior = 'url(#default#homepage)';
    obj.setHomePage(host);
};

//兼容firefox、ie浏览器event事件
if(window.addEventListener) { FixPrototypeForGecko(); } 
function FixPrototypeForGecko(){
	try{
		HTMLElement.prototype.__defineGetter__("runtimeStyle",element_prototype_get_runtimeStyle);
		window.constructor.prototype.__defineGetter__("event",window_prototype_get_event);
		Event.prototype.__defineGetter__("srcElement",event_prototype_get_srcElement);
		Event.prototype.__defineGetter__("fromElement", element_prototype_get_fromElement);
		Event.prototype.__defineGetter__("toElement", element_prototype_get_toElement);
	}catch(e){
	
	}
} 
function element_prototype_get_runtimeStyle() { return this.style; }
function window_prototype_get_event() { return SearchEvent(); }
function event_prototype_get_srcElement() { return this.target; } 
function element_prototype_get_fromElement() {
	var node;
	if(this.type == "mouseover") node = this.relatedTarget;
	else if (this.type == "mouseout") node = this.target;
	if(!node) return;
	while (node.nodeType != 1)
		node = node.parentNode;
	return node;
}
 
function element_prototype_get_toElement() {
	var node;
	if(this.type == "mouseout") node = this.relatedTarget;
	else if (this.type == "mouseover") node = this.target;
	if(!node) return;
	while (node.nodeType != 1)
		node = node.parentNode;
	return node;
}
 
function SearchEvent(){
	if(document.all) return window.event; 
	func = SearchEvent.caller; 
	while(func!=null){
		var arg0=func.arguments[0]; 
		if(arg0 instanceof Event) {
			return arg0;
		}
		func=func.caller;
	}
	return null;
}

//兼容IE的placeholder,type=password还没有更好的解决方案，用一个浮动层解决
$(function(){
	if(!placeholderSupport()){   // 判断浏览器是否支持 placeholder
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		}).blur(function() {
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		}).blur();
	};
})
function placeholderSupport() {
	return 'placeholder' in document.createElement('input');
}

//图片延迟加载
(function($) {
    $.extend($.fn, {
        molazy : function(container){
        	$(this).find('img').each(function (){
        		var _self  = $(this);
		        var org = _self.attr("data-original");
		        if(org){
		        	_self.attr('src', org).removeAttr('data-original');
		        }
		    });
        }
    });
})(jQuery);

//格式化json数据
(function($) {   
    $.type = function(o) {   
        var _toS = Object.prototype.toString;   
        var _types = {   
            'undefined': 'undefined',   
            'number': 'number',   
            'boolean': 'boolean',   
            'string': 'string',   
            '[object Function]': 'function',   
            '[object RegExp]': 'regexp',   
            '[object Array]': 'array',   
            '[object Date]': 'date',   
            '[object Error]': 'error'   
        };   
        return _types[typeof o] || _types[_toS.call(o)] || (o ? 'object' : 'null');   
    };
    var $specialChars = { '\b': '\\b', '\t': '\\t', '\n': '\\n', '\f': '\\f', '\r': '\\r', '"': '\\"', '\\': '\\\\' };   
    var $replaceChars = function(chr) {   
        return $specialChars[chr] || '\\u00' + Math.floor(chr.charCodeAt() / 16).toString(16) + (chr.charCodeAt() % 16).toString(16);   
    };   
    $.toJSON = function(o) {   
        var s = [];   
        switch ($.type(o)) {   
            case 'undefined':   
                return 'undefined';   
                break;   
            case 'null':   
                return 'null';   
                break;   
            case 'number':   
            case 'boolean':   
            case 'date':   
            case 'function':   
                return o.toString();   
                break;   
            case 'string':   
                return '"' + o.replace(/[\x00-\x1f\\"]/g, $replaceChars) + '"';   
                break;   
            case 'array':   
                for (var i = 0, l = o.length; i < l; i++) {   
                    s.push($.toJSON(o[i]));   
                }   
                return '[' + s.join(',') + ']';   
                break;   
            case 'error':   
            case 'object':   
                for (var p in o) {   
                    s.push('"' + p + '"' + ':' + $.toJSON(o[p]));   
                }   
                return '{' + s.join(',') + '}';   
                break;   
            default:   
                return '';   
                break;   
        }   
    };   
    $.evalJSON = function(s) {   
        if ($.type(s) != 'string' || !s.length) return null;   
        return eval('(' + s + ')');   
    };   
})(jQuery);

//cookie
Cookie = {
    set: function (name, value, expires, path, domain) {
        if (typeof expires == "undefined") {
            expires = new Date(new Date().getTime() + 1000 * 3600 * 24 * 365);
        }

        document.cookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires.toGMTString() : "") + ((path) ? "; path=" + path : "; path=/") + ((domain) ? ";domain=" + domain : "");

    },
    get: function (name) {
        var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
        if (arr != null) {
            return unescape(arr[2]);
        }
        return null;
    },
    clear: function (name, path, domain) {
        if (this.get(name)) {
            document.cookie = name + "=" + ((path) ? "; path=" + path : "; path=/") + ((domain) ? "; domain=" + domain : "") + ";expires=Fri, 02-Jan-1970 00:00:00 GMT";
        }
    }
};

/**ie6 png**/
function pngfix(img){
    if (window.XMLHttpRequest) {return}
    if($.browser.msie && ($.browser.version == "6.0") && !$.support.style){
        var imgStyle = img.style.cssText;
        var strNewHTML = "<img src='/static/images/holder.png' class=\"" + img.className + "\" title=\"" + img.title + "\" style=\"width:" + img.clientWidth + "px; height:" + img.clientHeight + "px;" + imgStyle + ";" + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + img.src + "', sizingMethod='scale');\" />";
        img.outerHTML = strNewHTML;
    }
};
