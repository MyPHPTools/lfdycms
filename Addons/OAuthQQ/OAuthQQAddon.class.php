<?php
namespace Addons\OAuthQQ;
use Common\Controller\Addon;

class OAuthQQAddon extends Addon{

    private $qc;
    protected $config;

    public $info = array(
        'name'=>'OAuthQQ',
        'title'=>'QQ登录',
        'description'=>'QQ登录',
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
        $dataList[] = array('name'=>'addons/oauthqq/login','title'=>'QQ登录','value'=>'["addons/run",{"addon_name":"OAuthQQ","addon_run":"login"}]','display'=>0,'addons'=>'OAuthQQ');
        $dataList[] = array('name'=>'addons/oauthqq/callback','title'=>'QQ登录回调','value'=>'["addons/run",{"addon_name":"OAuthQQ","addon_run":"callback"}]','display'=>0,'addons'=>'OAuthQQ');
        M('route')->addAll($dataList);
        $db_prefix = C('DB_PREFIX');
        $Model = M();
        $Model->execute("DROP TABLE IF EXISTS `".$db_prefix."oauth_qq`");
        $Model->execute("CREATE TABLE `".$db_prefix."oauth_qq` (`id` int(11) NOT NULL AUTO_INCREMENT,`openid` varchar(32) DEFAULT '',`uid` int(11) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='qq登录'");
        return true;
    }

    public function uninstall(){
        M('route')->where(array('addons'=>'OAuthQQ'))->delete();
        $db_prefix = C('DB_PREFIX');
        $Model = M();
        $Model->execute("DROP TABLE `".$db_prefix."oauth_qq`");
        return true;
    }

    protected function qqauth(){
        $this->config=$this->getConfig();
        import('Addons.OAuthQQ.qqconnect.qqconnect','./');
        $this->qc = new \QC($this->config['appid'],$this->config['appkey'],U('addons/oauthqq/callback','','',true));
    }

    public function login(){
        $this->qqauth();
        $this->qc->qq_login();
    }
    
    public function callback(){
        $this->qqauth();
        $acs=$this->qc->qq_callback();
        $oid=$this->qc->get_openid();
        $map['openid']=$oid;
        $uid=M('oauth_qq')->where($map)->field('uid')->find();
        if(!$uid){
            $qc = new \QC($this->config['appid'],$this->config['appkey'],U('addons/oauthqq/callback','','',true),$acs,$oid);
            $ret = $qc->get_user_info();
            $data['username']=$ret['nickname'];
            $data['password']=think_ucenter_md5($oid);
            $data['email']=$ret['nickname']."@QQ.com";
            $data['reg_time']=NOW_TIME;
            $data['reg_ip']=ip2long(get_client_ip());
            $data['update_time']=NOW_TIME;
            $data['status']=1;
            $data['path']=$ret['figureurl_qq_1'];
            $data['birthday']=NOW_TIME;
            $data['gender']=$ret['gender']=='男'?1:2;
            $uid=M('Users')->add($data);
            M('oauth_qq')->add(array('openid'=>$oid,'uid'=>$uid));
            D('User/Public')->autoLogin(array('id'=>$uid,'username'=>$ret['nickname']));
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