<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect(C("TPL_PATH").C("DEFAULT_TPl")."/index.html");
	}

    protected function _initialize(){
        /* 读取站点配置 */
		define('UID',is_user_login());
        $config =   S('DB_CONFIG_DATA');
        if(!$config){
            $config =  config_lists();
            S('DB_CONFIG_DATA',$config);
        }
        C($config);
        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
		$this->webpath=__ROOT__."/";
		$this->webtitle=C("WEB_SITE_TITLE");
		$this->weblogo=C("WEB_LOGO");
		$this->keywords=C("WEB_SITE_KEYWORD");
		$this->description=C("WEB_SITE_DESCRIPTION");
		$this->icp=C("WEB_SITE_ICP");
		//$this->rssurl="";
		$this->weburl=C("WEB_URL");
		$this->webname=C("WEB_NAME");
		C('CACHE_PATH',RUNTIME_PATH."/Cache/".MODULE_NAME."/Web/");
		C('TMPL_ACTION_ERROR','User@web/Public/dispatch_jump');
		C('TMPL_ACTION_SUCCESS','User@web/Public/dispatch_jump');
		$this->tplpath=$this->webpath.C("TPL_PATH").'web/'.C("DEFAULT_WEB_TPl");
		define('MOBILE','web');
		$this->user=user_info(UID);
		\Think\Hook::add("view_filter","Home\\Behavior\\JsBehavior");
    }
}
