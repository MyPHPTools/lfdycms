<?php
namespace Home\Behavior;
use Think\Behavior;

class JsBehavior extends Behavior {

    public function run(&$content){
		if(!defined('HTML_FILE_NAME')){
        	$content=$this->tplJsAdd($content);
		}
	}
	
	protected function tplJsAdd($content){
		$jsCode ="<script type=\"text/javascript\">\n";
    	$jsCode.="(function(){\n";
        $jsCode.="var ThinkPHP = window.Think = {\n";
        $jsCode.="\"UID\"    : \"".UID."\",\n";
        if((defined('HTML_CONTROLLER')?HTML_CONTROLLER:CONTROLLER_NAME)=="Player"){
        	$jsCode.="\"ID\"    : \"".D("Movie")->getmid(I('pid'))."\",\n";
        }else{
        	$jsCode.="\"ID\"    : \"".I('id')."\",\n";
        }
		$jsCode.="\"CONTROLLER_NAME\"    : \"".(defined('HTML_CONTROLLER')?HTML_CONTROLLER:CONTROLLER_NAME)."\",\n";
		$jsCode.="\"APP\"    : \"".__APP__."\",\n";
		$jsCode.="\"PATTEM\"    : \"".C("WEB_PATTEM")."\",\n";
		$jsCode.="\"DEEP\"   : \"".C('URL_PATHINFO_DEPR')."\",\n";
		$jsCode.="\"MODEL\"  : [\"".C('URL_MODEL')."\", \"".C('URL_CASE_INSENSITIVE')."\", \"".C('URL_HTML_SUFFIX')."\"],\n";
		$jsCode.="\"VAR\"    : [\"".C('VAR_MODULE')."\", \"".C('VAR_CONTROLLER')."\", \"".C('VAR_ACTION')."\"],\n";
		$jsCode.="\"MOBILE\"    : \"".MOBILE."\"\n";
        $jsCode.="}\n";
    	$jsCode.="})();\n";
    	$jsCode.="</script>\n";
		$jsCode.="<script type=\"text/javascript\" src=\"".__ROOT__."/Public/static/think.js\"></script>\n";
		if(MOBILE=='web'){
            $jsCode.="<script type=\"text/javascript\" src=\"".__ROOT__."/Public/static/layer/layer.js\"></script>\n";
        }else{
            $jsCode.="<script type=\"text/javascript\" src=\"".__ROOT__."/Public/static/layer.m/layer.m.js\"></script>\n";
        }
		$jsCode.="<script type=\"text/javascript\" src=\"".__ROOT__."/Public/".MODULE_NAME."/js/home.js\"></script>\n";
		$jsCode.="</body>\n";
        $content = str_replace("</body>",$jsCode,$content);
        return $content;
    }
}