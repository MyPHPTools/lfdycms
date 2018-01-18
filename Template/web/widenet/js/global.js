$(function(){
	if($('div').is('.swiper-container')){
		var slider_swiper = new Swiper ('.swiper-container', {
			autoplay : 3000,
		    loop: true,
		    // 如果需要分页器
		    pagination: '.swiper-number',
		    paginationElement : 'a',
		    
		    // 如果需要前进后退按钮
		    nextButton: '.swiper-next',
		    prevButton: '.swiper-prev',
	 	}) 
	}
	var list_swiper=new Array();
	$('[id="t-lastest-online"]').each(function(index, el) {
		list_swiper[index] = new Swiper($(this).find('.inner'), {
	        slidesPerView: 6,
	        slidesPerGroup:6,
	        spaceBetween: 20,
	        prevButton:$(this).find('.prev'),
			nextButton:$(this).find('.next'),
	    });
	});

	$('.u-record').mouseDelay(false).hover(function() {
		$(this).find('#history_list').removeClass('hidden');
	}, function() {
		$(this).find('#history_list').addClass('hidden');
	});
	$('.u-collect').mouseDelay(false).hover(function() {
		$(this).find('#collect_list').removeClass('hidden');
	}, function() {
		$(this).find('#collect_list').addClass('hidden');
	});

	// 图标点击事件
	$('.main-sub li').each(function() {
		$(this).mouseDelay(false).hover(function() {
			$(this).find('.subs-nav').show();
		}, function() {
			$(this).find('.subs-nav').hide();
		});
	});

	$('#pIntroMore').click(function(event) {
		if($(this).hasClass('more-expand')){
			$(this).removeClass('more-expand').text('查看详情');
			$(this).siblings('.text').removeClass('hide').siblings('.intro-more').addClass('hide');
		}else{
			$(this).addClass('more-expand').text('收起详情');
			$(this).siblings('.text').addClass('hide').siblings('.intro-more').removeClass('hide');
		}
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
		tar:"#history_list_wrap",
		init:function(){
			if(!movHistory){
				var TPL = '<div class="f_white_op5 ta_center">您还没有看过任何影片哦</div>';
				$(this.tar).html(TPL);
			}else{
				movHistory = $.evalJSON(movHistory);
				// console.log(movHistory);
				var hisHtm = '',num=0;
				$.each(movHistory, function (i,data){
					num++;
					hisHtm += '<p class="info_tit"><a href="'+data['purl']+'">'+data['title']+'</a></p>';
					if(num > 4){
						return false;
					}
				});
				$(this.tar).find('.user_list_info').html(hisHtm);
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
						hisHtm += '<p class="info_tit"><a href="'+data['url']+'">'+data['title']+'</a></p>';
					});
					$("#collect_list_wrap").find('.user_list_info').html(hisHtm);
				}
			});
		}
	};
	favorite.init();
});