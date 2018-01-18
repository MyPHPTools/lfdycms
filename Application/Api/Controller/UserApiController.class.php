<?php
namespace Api\Controller;
use Think\Controller;

class UserApiController extends Controller{
	private $UcSend;

	public function _initialize(){
        /* 读取站点配置 */
        $config =   S('DB_CONFIG_DATA');
        if(!$config){
            $config =  config_lists();
            S('DB_CONFIG_DATA',$config);
        }
        C($config);
        $this->UcSend = new \Com\UCenter\UcSend(C('BBS_URL'),C('BBS_KEY'),C('BBS_APIID'));
    }

    public function User_Login($uid,$username,$password){
    	if($uid>0){
    		$ucid=M('Users')->where('id='.$uid)->getField('ucid');
    		$jslogin=$this->UcSend->uc_user_synlogin($ucid);
    		return array($uid,$jslogin);//登录成功
    	}elseif($uid=='-2'){
    		$ucid=$this->UcSend->uc_user_login($username,$password);
    		if($ucid[0]>0){
    			$uid=M('Users')->where(array('username'=>$username,'ucid'=>$ucid[0]))->getField('id');
    			D('User/Public')->autoLogin(array('id'=>$uid,'username'=>$username));
				D('User/Public')->upPlayLog($uid);
    			$jslogin=$this->UcSend->uc_user_synlogin($ucid[0]);
    			return array($ucid,$jslogin);//登录成功
    		}else{
    			return array($uid,'');
    		}
    	}else{
    		return array($uid,'');
    	}
	}

	public function User_register($username,$password,$email){
		$ucid=$this->UcSend->uc_user_register($username,$password,$email);
		return $ucid;
	}

	public function User_edit($uid,$oldpw,$newpw,$email='',$ignoreoldpw=0){
		$ucid = M('Users')->where('id='.$uid)->getField('ucid');
		if($ucid){
			$username=$this->UcSend->uc_get_user($ucid,1);
			$user=$this->UcSend->uc_user_edit($username[1], $oldpw, $newpw, $email,$ignoreoldpw);
			return $user;
		}	
	}

	public function User_logout(){
		return $this->UcSend->uc_user_synlogout();
	}
}