var add_history=function(Params){
	var cookie_prefix= "lf_users_";
	var movHistory = Cookie_get(cookie_prefix+"movHistory");
	var hisArr = $.evalJSON(movHistory);
	if(!hisArr){
		hisArr=[];
	}
	$.each(hisArr, function (i,data){
		if(data.id == Params.id){
			hisArr.splice(i,1);
			return false;
		}
	});
	hisArr.unshift(Params);
	hisJson = $.toJSON(hisArr);
	Cookie_set(cookie_prefix+"movHistory",hisJson);
	// console.log($.toJSON(Params));
	$.ajax({
		tpye:'get',
		url:getRootPath()+'/index.php?s=/User/Record/add.html',
		data:{data: $.toJSON(Params)}
	});
}


var Cookie_set =  function (name, value, expires, path, domain) {
	if (typeof expires == "undefined") {
		expires = new Date(new Date().getTime() + 1000 * 3600 * 24 * 365);
	}
	document.cookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires.toGMTString() : "") + ((path) ? "; path=" + path : "; path=/") + ((domain) ? ";domain=" + domain : "");
}
var Cookie_get = function (name) {
	var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
	if (arr != null) {
		return unescape(arr[2]);
	}
	return null;
}
	
function getRootPath(){
	var curWwwPath=window.document.location.href;
	var pathName=window.document.location.pathname;
	var pos=curWwwPath.indexOf(pathName);
	var localhostPaht=curWwwPath.substring(0,pos);
	var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
	return(localhostPaht+projectName);
}

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
var $replaceChars = function(chr) {   
	var $specialChars = { '\b': '\\b', '\t': '\\t', '\n': '\\n', '\f': '\\f', '\r': '\\r', '"': '\\"', '\\': '\\\\' }; 
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