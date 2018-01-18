var bstartnextplay = false;
var ffhd_weburl = unescape(window.location.href);
var is_ie_not_install = false;
function isIE() {
	if (!!window.ActiveXObject || "ActiveXObject" in window)  
		return true;  
	else  
		return false;  
}
function $ShowSetup() {
	return '<iframe src="./Public/Player/player/ffplayer/ffhdsetup.html" width="100%" height="'+MacPlayer.Height+'" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" scrolling="no" vspale="0" noResize></iframe>';
}
function $PlayerNt(){
	if (navigator.plugins) {
		var notinstall = true;
		for (var i=0;i<navigator.plugins.length;i++) {
			if(navigator.plugins[i].name == 'FFPlayer Plug-In'){
				notinstall = false;
				break;
			}
		}
		if(!notinstall){
			player = '<object id="FFHDPlayer" name="FFHDPlayer" type="application/npFFPlayer" width="100%" height="'+MacPlayer.Height+'" progid="XLIB.FFPlayer.1" url="'+MacPlayer.PlayUrl+'" CurWebPage="'+ffhd_weburl+'"></object>';
			return player;
		}
	}
	return $ShowSetup();
}
function $PlayerIe(){
	player = '<object classid="clsid:D154C77B-73C3-4096-ABC4-4AFAE87AB206" width="100%" height="'+MacPlayer.Height+'" id="FFHDPlayer" onerror="is_ie_not_install = true;"><param name="url" value="'+MacPlayer.PlayUrl+'"/><param name="CurWebPage" value="'+ffhd_weburl+'"/></object>';
	return player;
}
function WriteIEShowSetup(){
	if (is_ie_not_install===false)
		return;
	document.write($ShowSetup());
}
function $Showhtml(){
	if(!isIE()){
		return $PlayerNt();
	}else{
		return $PlayerIe();
	}
}

document.write($Showhtml());
WriteIEShowSetup();