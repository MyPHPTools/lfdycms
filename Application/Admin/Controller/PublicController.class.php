<?php
namespace Admin\Controller;


class PublicController extends \Think\Controller {

    /**
     * 后台用户登录
     */
    public function login($username = null, $password = null, $passcode = null){
        if(IS_POST){
            /* 检测验证码 TODO: */
           	if(!check_verify($passcode)){
               	$this->error("验证码错误！");
            }

            $uid = D('Public')->login($username, $password);
            if(0 < $uid){ //UC登录成功
                $this->success('登录成功！', U('Index/index'));
            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                /* 读取数据库中的配置 */
				$config =   S('DB_CONFIG_DATA');
				if(!$config){
					$config =  config_lists();
					S('DB_CONFIG_DATA',$config);
				}
				C($config); //添加配置
                
                $this->display();
            }
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            D('Public')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
		ob_clean();
		$config =	array(
		'useCurve'  => false,            // 是否画混淆曲线
        'useNoise'  => false,            // 是否添加杂
        'fontSize'  => 14,              // 验证码字体大小(px)
        'length'    => 4,               // 验证码位数
        );
        $verify = new \Think\Verify($config);
        $verify->entry(1);
    }
}
