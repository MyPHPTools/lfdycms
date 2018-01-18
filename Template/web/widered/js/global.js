/*!
 * index
 * http://www.168tv.ue
 * Copyright 2017
 */
$(function(){
	// 图标点击事件
	$('.nav-drop-down').each(function() {
		$(this).mouseDelay(false).hover(function() {
			$(this).addClass('hd-fBoxVis');
			$(this).find('.h-wrap .h-logout-wrap').show();
		}, function() {
			$(this).removeClass('hd-fBoxVis');
			$(this).find('.h-wrap .h-logout-wrap').hide();
		});
	});

	$("#topInfo").on("click", ".zhankai", function(a) {
		$(this).parents(".J-halfintro").hide(), $(this).parents(".J-halfintro").prev(".J-fullintro").show(), a.preventDefault()
	}).on("click", ".shouqi", function(a) {
		$(this).parents(".J-fullintro").hide(), $(this).parents(".J-fullintro").next(".J-halfintro").show(), a.preventDefault()
	});
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
    $.evalJSON = function(s) {   
        if ($.type(s) != 'string' || !s.length) return null;   
        return eval('(' + s + ')');   
    };   
})(jQuery);

//cookie
var Cookie = {
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

$(function(){
	var movHistory = Cookie.get("lf_users_movHistory");
	//播放记录
	var history = {
		tar:"#hisStatu",
		init:function(){
			if(!movHistory){
				var TPL = '<li class="his-item"><a class="hd-his-row3" href="#" target="_blank">您还没有观看记录</a></li>';
				$(this.tar).html(TPL);
			}else{
				movHistory = $.evalJSON(movHistory);
				// console.log(movHistory);
				var hisHtm = '',num=0;
				$.each(movHistory, function (i,data){
					num++;
					hisHtm += '<li class="his-item"><a class="hd-his-row3" href="'+data['purl']+'" target="_blank">'+data['title']+'</a><span class="hd-his-pc"></span></li>';
					if(num > 4){
						return false;
					}
				});
				$(this.tar).html(hisHtm);
			};
		}
	};
	history.init();
});

$(function(){
	var favorite = {
		init:function(){
			$.getJSON('/index.php?s=/Home/Api/favorite', function(movFavorite) {
				if(movFavorite){
					var hisHtm = '';
					$.each(movFavorite, function (i,data){
						hisHtm += '<li class="his-item"><a class="hd-his-row3" href="'+data['url']+'" target="_blank">'+data['title']+'</a><span class="hd-his-pc"></span></li>';
					});
					$("#favorite").html(hisHtm);
				}
			});
		}
	};
	favorite.init();
});