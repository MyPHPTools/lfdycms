
function jjvodstatus(offest){
    if(document.getElementById('jjvodPlayer').PlayState==3){
         document.getElementById('jjad').style.display='none';
    }else if(document.getElementById('jjvodPlayer').PlayState==2||document.getElementById('jjvodPlayer').PlayState==4){
         document.getElementById('jjad').style.display='block';
    }
}


//调用JJVOD代码
function addJJVod(){
if(!!window.ActiveXObject || "ActiveXObject" in window){
		document.write("<div style='position:relative'>");
		document.write('<div id="jjad" style="position:absolute; z-index:1001"><iframe marginWidth="0" id="wdqad" name="wdqad" marginHeight="0" src="'+jjvod_ad+'" frameBorder="0" width="'+jjvod_w+'" scrolling="no" height="390"></iframe></div>');
		document.write("<object classid='clsid:C56A576C-CC4F-4414-8CB1-9AAC2F535837' width='"+jjvod_w+"' height='"+jjvod_h+"' id='jjvodPlayer' name='jjvodPlayer' onerror=\"document.getElementById('jjvodPlayer').style.display='none';document.getElementById('jjad').style.display='block';document.getElementById('wdqad').src='"+jjvod_install+"';\"><PARAM NAME='URL' VALUE='"+jjvod_url+"'><PARAM NAME='WEB_URL' VALUE='"+jjvod_weburl+"'><param name='Autoplay' value='1'></object>");
		document.write("</div>");
		var ver = chkJJActivexVer();
		setInterval('jjvodstatus()','1000');

}else{
	if (navigator.plugins) {
		var install = false;
		for (var i=0;i<navigator.plugins.length;i++) {
			if(navigator.plugins[i].name == 'JJvod Plugin'){//ActiveX hosting plugin for Firefox || JJvod Plugin
				install = true;break;
			}
		}
		
		if(install){//已安装
			document.write('<div style="width:'+jjvod_w+'px; height:'+jjvod_h+'px;overflow:hidden;position:relative">');
			document.write('<div id="jjad" style="position:absolute;z-index:2;top:0px;left:0px"><iframe border="0" src="'+jjvod_ad+'" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" noResize scrolling="no" width="'+jjvod_w+'" height="410" vspale="0"></iframe></div>');
			document.write('<object id="jjvodPlayer" name="jjvodPlayer" TYPE="application/x-itst-activex" ALIGN="baseline" BORDER="0" WIDTH="'+jjvod_w+'" HEIGHT="'+jjvod_h+'" progid="WEBPLAYER.WebPlayerCtrl.2" param_URL="'+jjvod_url+'" param_WEB_URL="'+jjvod_weburl+'"></object>');
			document.write("</div>");
			setInterval('jjvodstatus()','1000');
		}else{
			document.write('<div id="jjad"><iframe border="0" src="'+jjvod_install+'" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" noResize scrolling="no" width="'+jjvod_w+'" height="410" vspale="0"></iframe></div>');
		}
	}
}
}

function killErrors(){return true;}window.onerror = killErrors;

addJJVod();

function chkJJActivexVer(){
	var playerS = document.getElementById('jjvodPlayer');
	if(playerS.GetVer&&typeof(playerS.GetVer)=="number"){
		return ;
	}else{//老版本
		var play = checkPlugins('WEBPLAYER.WebPlayerCtrl.1');
		if(play){
			if(confirm("请下载升级最新吉吉影音播放器，以便更流畅播放影片！")){
				window.location.href="http://dl.jijivod.com/JJPlayer_"+jjvod_c+".exe";
			}else{
				return false;
			}
		}
	}
}

function checkPlugins(activexObjectName) {
	var np = navigator.plugins;	
	if (np && np.length)// 针对于FF等非IE.
	{
		for(var i = 0; i < np.length; i ++) {
			if(np[i].name.indexOf(activexObjectName)!= -1)
			{
				return true;
			}
		}
	}
	else if (window.ActiveXObject)// 针对于IE
	{
		try {
			new ActiveXObject(activexObjectName);
			return true;
		}
		catch (e) {
			return false;
		}
	}
	return false;
}

