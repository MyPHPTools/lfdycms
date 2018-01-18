<?php
namespace Addons\OAuthWechat;
use Common\Controller\Addon;

class OAuthWechatAddon extends Addon{

    private $auth;
    protected $config;

    public $info = array(
        'name'=>'OAuthWechat',
        'title'=>'微信登录',
        'description'=>'微信登录',
        'status'=>1,
        'author'=>'弘讯科技',
        'version'=>'1.0',
        'group'=>'oauth',
        'mold'=>'web,wap,wechat',
        'has_hook'=>0,
        'exclusive'=>0,
        'sort'=>1
    );

    public function install(){
        $dataList[] = array('name'=>'addons/oauthwechat/login','title'=>'微信登录','value'=>'["addons/run",{"addon_name":"OAuthWechat","addon_run":"login"}]','display'=>0,'addons'=>'OAuthWechat');
        M('route')->addAll($dataList);
        $db_prefix = C('DB_PREFIX');
        $Model = M();
        $Model->execute("DROP TABLE IF EXISTS `".$db_prefix."oauth_wechat`");
        $Model->execute("CREATE TABLE `".$db_prefix."oauth_wechat` (`id` int(11) NOT NULL AUTO_INCREMENT,`openid` varchar(32) DEFAULT '',`uid` int(11) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信登录'");
        return true;
    }

    public function uninstall(){
        M('route')->where(array('addons'=>'OAuthWechat'))->delete();
        $db_prefix = C('DB_PREFIX');
        $Model = M();
        $Model->execute("DROP TABLE `".$db_prefix."oauth_wechat`");
        return true;
    }

    protected function wechatauth(){
        $this->config=$this->getConfig();
        $token = session("token");
        $appid=$this->config['login_wechat_web_appid'];
        $appsecret=$this->config['login_wechat_web_appid'];
        if($token){
            $this->auth = new \Addons\OAuthWechat\wechat\WechatAuth($appid, $appsecret, $token);
        } else {
            $this->auth  = new \Addons\OAuthWechat\wechat\WechatAuth($appid, $appsecret);
            $token = $this->auth->getAccessToken();
            session(['expire' => $token['expires_in']]);
            session("token", $token['access_token']);
        }
    }

    public function login(){
        $this->wechatauth();
        $code = I('get.code');
        if(!$code){
            header("Location: ".$this->auth->getRequestCodeURL(__SELF__));
            exit;
        }
        $token=$this->auth->getAccessToken('code',$code);
        $map['openid']=$token['openid'];
        $uid=M('oauth_wechat')->where($map)->field('uid')->find();
        if(!$uid){
            $user = $this->auth->getUserInfo($token['openid']);
            $data['username']=$user['nickname'];
            $data['password']=think_ucenter_md5($user['openid']);
            $data['email']=$user['nickname']."@QQ.com";
            $data['reg_time']=NOW_TIME;
            $data['reg_ip']=ip2long(get_client_ip());
            $data['update_time']=NOW_TIME;
            $data['status']=1;
            $data['path']=$user['headimgurl'];
            $data['birthday']=NOW_TIME;
            $data['gender']=$user['sex'];
            $uid=M('Users')->add($data);
            M('oauth_wechat')->add(array('openid'=>$user['openid'],'uid'=>$uid));
            D('User/Public')->autoLogin(array('id'=>$uid,'username'=>$user['nickname']));
            D('User/Public')->upPlayLog($uid);
            return $this->success('用户注册成功！','Home/index/index');
        }else{
            $user=M('Users')->where(array('id'=>uid))->field('id,username')->find();
            D('User/Public')->autoLogin($user);
            D('User/Public')->upPlayLog($user['id']);
            return $this->success('登录成功！','Home/index/index');
        }
    }
}