$(function(){
	if($('div').is('.swiper-container')){
		var mySwiper = new Swiper('.swiper-container',{
			autoplay : 2000,
			loop : true,
			pagination : '.swiper-pagination',
		});
	}

	// 图标点击事件
	$('[name="TopIcon"]').children('.fBox').each(function() {
		$(this).mouseDelay(false).hover(function() {
			var ThisSize = $(this).outerWidth();
			var TipSize = (ThisSize / 2) - 5;
			$(this).children('.show-record').css('visibility','visible');
			$(this).children('.show-record').children('em').css('right',TipSize);
			$(this).children('.show-record').children('i').css('right',TipSize);
			$(this).children('.tr_icons').addClass('active');
		}, function() {
			$(this).children('.show-record').css('visibility','hidden');
			$(this).children('.tr_icons').removeClass('active');
		});
	})
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
				var TPL = '<div class="record-list" href="#">您还没有观看记录~</div>';
				$(this.tar).html(TPL);
			}else{
				movHistory = $.evalJSON(movHistory);
				// console.log(movHistory);
				var hisHtm = '',num=0;
				$.each(movHistory, function (i,data){
					num++;
					hisHtm += '<div class="record-list"><a href="'+data['url']+'"><span>'+data['title']+'</span></a><em><a href="'+data['purl']+'" class="a1" target="_blank"><i class="icon icon-small-play"></i>继续观看</a></em></div>';
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
						hisHtm += '<div class="record-list"><a class="f12 a1" href="'+data['url']+'"><span>'+data['title']+'</span></a><em><a href="'+data['url']+'" class="a1" target="_blank"><i class="icon icon-small-play"></i>马上观看</a></em></div>';
					});
					$("#favorite").html(hisHtm);
				}
			});
		}
	};
	favorite.init();
});