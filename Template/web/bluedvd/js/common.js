jQuery("#menu").slide({ titCell:".m li", mainCell:"#nav"});
jQuery(".box .content").slide({ titCell:".title dd",mainCell:".bd",delayTime:10 });
jQuery(".channel .box").slide({ titCell:".title dl dd",mainCell:"ul", effect:"left", delayTime:800,vis:6,scroll:6,pnLoop:false,easing:"easeOutCubic" });

$(function(){
	var cookie_prefix= "lf_users_";
	var movHistory = Cookie.get(cookie_prefix+"movHistory");
	//播放记录
	var history = {
		tar:".lookedlist ul",
		del:function(index){
			if($(this.tar).find("li").size() == 0){
				var TPL = '<div id="morelog" class="histodo">您的观看历史为空。</div>';
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
				var TPL = '<div id="morelog" class="histodo">您的观看历史为空。</div>';
				$(this.tar).html(TPL);
			}else{
				movHistory = $.evalJSON(movHistory);
				var hisHtm = '';
				$.each(movHistory, function (i,data){
					hisHtm += '<li id="'+data['id']+'"><h5><a href="'+data['url']+'" target="_blank">'+data['title']+'</a></h5><label><a href="'+data['purl']+'" target="_blank">继续看</a></label><a href="javascript:;" class="del">X</a></span></li>';
					if(i > 9) return false;
				});
				$(this.tar).html(hisHtm);
			};
		}
	};
	history.init();

	$(".history").hover(function(){
		$(".drop-box").show();
	},function(){
		$(".drop-box").hide();
	});
	
	$(".closehis").click(function(){
		$(".drop-box").hide();
	});

	$(".highlight").find("a.del").on("click", function(){
		$(this).parents("li").fadeOut(500,function(){
			index=$(this).index();							   
			$(this).remove();
			history.del(index);
		});
	});

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
});

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