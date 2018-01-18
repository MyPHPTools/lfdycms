<?php
namespace Api\Controller;
use Think\Controller;

class UcApiController extends Controller{

	protected function _initialize(){
        /* 读取站点配置 */
        $config =   S('DB_CONFIG_DATA');
        if(!$config){
            $config =  config_lists();
            S('DB_CONFIG_DATA',$config);
        }
        C($config);
    }

	//系统首页
    public function index(){
		$_DCACHE = $get = $post = array();
		$code = @$_GET['code'];
		parse_str(uc_authcode($code, 'DECODE', C('BBS_KEY')), $get);
		// file_put_contents('./data.txt', json_encode($get).PHP_EOL,FILE_APPEND);
		$timestamp = time();
		if($timestamp - $get['time'] > 3600) {
			exit('Authracation has expiried');
		}
		if(empty($get)) {
			exit('Invalid Request');
		}
		$action = $get['action'];
		$post = xml_unserialize(file_get_contents('php://input'));
		if(in_array($action, array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))){
			exit(D('UcApi')->$action($get, $post));
		} else {
			exit(C('API_RETURN_FAILED'));
		}
	}
}