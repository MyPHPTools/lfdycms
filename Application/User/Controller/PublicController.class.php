<?php
namespace User\Controller;
use Think\Controller;
/**
 * 用户首页控制器
 */
class PublicController extends Controller {

	 protected function _initialize(){
        $config =   S('DB_CONFIG_DATA');
        if(!$config){
            $config =  config_user_lists();
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
		$this->weburl=C("WEB_URL");
		$this->webname=C("WEB_NAME");
        if(is_mobile()){
            C('CACHE_PATH',RUNTIME_PATH."/Cache/".MODULE_NAME."/Wap/");
            $this->tplpath=$this->webpath.C("TPL_PATH").'wap/'.C("DEFAULT_WAP_TPl");
            C('VIEW_PATH',APP_PATH.MODULE_NAME.'/'.C('DEFAULT_V_LAYER').'/wap/');
            define('MOBILE','wap');
        }else{
            C('CACHE_PATH',RUNTIME_PATH."/Cache/".MODULE_NAME."/Web/");
            $this->tplpath=$this->webpath.C("TPL_PATH").'web/'.C("DEFAULT_WEB_TPl");
            C('VIEW_PATH',APP_PATH.MODULE_NAME.'/'.C('DEFAULT_V_LAYER').'/web/');
            define('MOBILE','web');
        }
	}
	
	public function login($username = null, $password = null,$app = null){
        if(IS_POST){
            $uid = D('Public')->login($username, $password);
            if(C('BBS_ON')){
                $login = A('Api/UserApi')->User_Login($uid,$username,$password);
            }else{
                $login=array($uid,'');
            }
            if(0 < $login[0]){
                if($app){
                    $this->ajaxReturn(array('uid'=>$uid,'status'=>1,'info'=>'登录成功！'));
                }else{
                    $this->success('登录成功！'.$login[1], Cookie('__forward__')?Cookie('__forward__'):U('Home/Index/index'));
                }
            } else { //登录失败
                switch($login[0]) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break;
                }
                $this->error($error);
            }
        } else {
            if(is_login()){
                $this->redirect('Home/Index/index');
            }else{
                $oauth_login=get_oauth_login(MOBILE);
                $this->assign('oauth_login',$oauth_login);
                $this->display();
            }
        }
    }

    public function islogin(){
        if(is_user_login()){
            $this->success('已经登录！');
        }else{
            $this->error('请先登录！');
        }
    }
	
	/* 退出登录 */
    public function logout($app = null){
        D('Public')->logout();
        session('[destroy]');
        if($app){
            $this->success('退出成功！');
        }else{
            $jslogin=A('Api/UserApi')->User_logout();
            $this->success('退出成功！'.$jslogin, Cookie('__forward__')?Cookie('__forward__'):U('Home/Index/index'));
        }
    }
	
	public function reg(){
		if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已经关闭，请稍后注册~');
        }
		if(IS_POST){
			if(I("password") != I("repassword")){
                $this->error('密码和重复密码不一致！');
            }
			$uid = D('Public')->reg();
			if(is_numeric($uid)){
                $this->success('用户注册成功！',U('Index/index'));
            } else {
                $this->error(D('Public')->getError());
            }
		}else{
            $oauth_login=get_oauth_login(MOBILE);
            $this->assign('oauth_login',$oauth_login);
			$this->display();
		}
	}

    public function forgetpwd($step=1){
        switch ($step) {
            case 1:
                if(IS_POST){
                    /* 检测验证码 TODO: */
                    if(!check_verify(I("passcode"))){$this->error("验证码错误！");}
                    if(I('username')){
                        $map['username']=I('username');
                        $map['status']=1;
                        if($user=M('users')->field('id,username,password,email')->where($map)->find()){
                            $this->pwdMail($user['id'],$user['email'],$user['password']);
                            session('username',$user['username']);
                            $this->success('已发送注册邮箱，请到注册邮箱查看！',U('Public/forgetpwd',array('step'=>2,'uid'=>$user['id'])));
                        }else{$this->error('没有该用户！');}
                    }else{$this->error('请输入用户名！');}
                }else{$this->display("findpwd_1");}
                break;
            case 2:
                $this->assign('uid',I('uid',0,'intval'));
                $this->assign('username',session('username'));
                $this->display("findpwd_2");
                break;
            case 3:
                if(IS_POST){
                    if(I("password") != I("repassword")){
                        $this->error('密码和重复密码不一致！');
                    }
                    if(strlen(I('password'))<6){
                        $this->error('密码长度必须大于5位数！');
                    }
                    $map=array('id'=>session('uid'),'password'=>session('password'));
                    session('[destroy]');
                    if(M('users')->where($map)->setField('password',think_ucenter_md5(I('repassword')))){
                        A('Api/UserApi')->User_edit(UID,I('post.password'),I('post.password'),'',1);
                        $this->success('密码修改成功！',U('Public/login'));
                    }else{
                        $this->error('请问你想做什么！',U('index/index'));
                    }
                }else{
                    $map=array('id'=>I('uid',0,'intval'), 'password'=>I('key'),'status'=>1);
                    if(M('users')->where($map)->getField('id')){
                        session('password',I('key'));
                        session('uid',I('uid',0,'intval'));
                        $this->display("findpwd_3");
                    }else{
                        $this->error('请不要到你不该来的地方！',U('index/index'));
                    }
                }
                break;
        }
    }
	
	public function validate($username){
		$id = M('Users')->where(array('username'=>$username))->field('id')->select();
        if(!empty($id)){
            echo "false";
        }
	}

    public function verify(){
        ob_clean();
        $config =   array(
        'useCurve'  => false,            // 是否画混淆曲线
        'useNoise'  => true,            // 是否添加杂
        'fontSize'  => 20,              // 验证码字体大小(px)
        'length'    => 4,               // 验证码位数
        );
        $verify = new \Think\Verify($config);
        $verify->entry(1);
    }

    public function againpwd($uid){
        $map=array('id' => $uid,'status'=>1);
        $user=M('users')->field('id,username,password,email')->where($map)->find();
        if($user){
            if($this->pwdMail($user['id'],$user['email'],$user['password'])){
                $this->success('发送成功请查收！');
            }
        }
        $this->error('发送失败请从新发送！');
    }

    protected function pwdMail($uid,$email,$password){
        $url=$this->weburl.U('public/forgetpwd',array('step'=>3,'uid'=>$uid,'key'=>$password));
        return sendMail($email,$this->webtitle.'-密码找回','<div class="wrapper" style="margin: 20px auto 0; width: 500px; padding-top:16px; padding-bottom:10px;"><br style="clear:both; height:0"><div class="content" style="background: none repeat scroll 0 0 #FFFFFF; border: 1px solid #E9E9E9; margin: 2px 0 0; padding: 30px;"><p>您好: </p><p style="border-top: 1px solid #DDDDDD;margin: 15px 0 25px;padding: 15px;">您最近提出了密码重设请求。要完成此过程，请点按以下链接: <a href="'.$url.'" target="_blank">'.$url.'</a></p><p style="border-top: 1px solid #DDDDDD; padding-top:6px; margin-top:25px; color:#838383;"><p>如果您未提出此请求，可能是其他用户无意中输入了您的电子邮件地址，您的帐户仍然安全。</p><p>请勿回复本邮件, 此邮箱未受监控, 您不会得到任何回复。</p><p>如果点击上面的链接无效，请尝试将链接复制到浏览器地址栏访问。</p></p></div></div>');
    }
}
