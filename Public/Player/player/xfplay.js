function $Showhtml(){
       if(window.ActiveXObject || window.ActiveXObject !== undefined)
            return $PlayerIe();
       else
            return $PlayerNt();
}

function $PlayerNt(){
	if (navigator.plugins) {
            var Install = false;
				for (i=0; i < navigator.plugins.length; i++ ) 
				{
					var n = navigator.plugins[i].name;
					if( navigator.plugins[n][0]['type'] == 'application/xfplay-plugin')
					{
						Install = true; break;
					}		
				} 

		if(Install){
			return '<embed type="application/xfplay-plugin" PARAM_URL="'+playerurl+'" PARAM_Status="1" width="100%" height="'+playerh+'" id="Xfplay" name="Xfplay"></embed>';
			
		}
	}
	return $xfInstall();
        
}

function $PlayerIe(){
      document.write('<IFRAME id=xframe_mz name=xframe_mz style="MARGIN: 0px; DISPLAY: none" src="http://error.xfplay.com/error.htm" frameBorder=0 scrolling=no width="'+playerw+'" height="' +playerh+ '"></IFRAME>');
         var player = '<object ID="Xfplay" name="Xfplay" width="'+playerw+'" height="'+playerh+'" onerror="$xf_IE_Install();" classid="clsid:E38F2429-07FE-464A-9DF6-C14EF88117DD" >';
         player += '<PARAM name="URL" value="'+playerurl+'">';
         player += '<PARAM name="Status" value="1"></object>';
         return player;
}

function $xfInstall(){
  return '<iframe border="0" src="http://error.xfplay.com/error.htm' + '" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" noResize scrolling="no" width="'+playerw+'" height="' + playerh + '" vspale="0"></iframe>';
}

function $xf_IE_Install(){
  document.getElementById('Xfplay').style.display='none';document.getElementById('xframe_mz').style.display='';document.getElementById('xframe_mz').src='http://error.xfplay.com/error.htm';  
}

document.write($Showhtml());