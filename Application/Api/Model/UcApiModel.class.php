<?php
namespace Api\Model;
use Think\Model;

class UcApiModel extends Model {
	
	protected function _serialize($arr, $htmlon = 0) {
		return xml_serialize($arr, $htmlon);
	}

	public function test($get, $post) {
		return C('API_RETURN_SUCCEED');
	}

	public function deleteuser($get, $post) {
		$uids = $get['ids'];
		!C('API_DELETEUSER') && exit(C('API_RETURN_FORBIDDEN'));

		return C('API_RETURN_SUCCEED');
	}

	public function renameuser($get, $post) {
		$uid = $get['uid'];
		$usernameold = $get['oldusername'];
		$usernamenew = $get['newusername'];
		if(!API_RENAMEUSER) {
			return C('API_RETURN_FORBIDDEN');
		}
		return C('API_RETURN_SUCCEED');
	}

	public function gettag($get, $post) {
		$name = $get['id'];
		if(!API_GETTAG) {
			return C('API_RETURN_FORBIDDEN');
		}
		$return = array();
		return $this->_serialize($return, 1);
	}

	public function synlogin($get, $post) {
		$map['ucid'] = $get['uid'];
		$map['status'] = 1;
		if(!C('API_SYNLOGIN')) {
			return C('API_RETURN_FORBIDDEN');
		}
		$user=M('Users')->where($map)->find();
		if(is_array($user)){
			header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
			D('User/Public')->autoLogin($user);
			D('User/Public')->upPlayLog($user['id']);
		}else{
			$user=$this->get_user($get);
			$data['username']=$user[1];
			$data['email']=$user[2];
	        $data['password']=think_ucenter_md5($get['password']);
	        $data['reg_time']=NOW_TIME;
	        $data['reg_ip']=get_client_ip();
	        $data['status']=1;
	        $data['ucid']=$user[0];
	        $uid=M('Users')->add($data);
	        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
			D('User/Public')->autoLogin(array('id'=>$uid,'username'=>$user[1]));
			D('User/Public')->upPlayLog($uid);
		}
	}

	public function synlogout($get, $post) {
		if(!C('API_SYNLOGOUT')) {
			return C('API_RETURN_FORBIDDEN');
		}
		//note 同步登出 API 接口
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		session('user_auth', null);
        session('user_auth_sign', null);
        session('[destroy]');
	}

	public function updatepw($get, $post) {
		if(!API_UPDATEPW) {
			return C('API_RETURN_FORBIDDEN');
		}
		$user=$this->get_user($get);
		M('users')->where('ucid='.$user[0])->setField('password',think_ucenter_md5($get['password']));
		return C('API_RETURN_SUCCEED');
	}

	public function updatebadwords($get, $post) {
		if(!API_UPDATEBADWORDS) {
			return C('API_RETURN_FORBIDDEN');
		}
		return C('API_RETURN_SUCCEED');
	}

	public function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return C('API_RETURN_FORBIDDEN');
		}
		return C('API_RETURN_SUCCEED');
	}

	public function updateapps($get, $post) {
		if(!API_UPDATEAPPS) {
			return C('API_RETURN_FORBIDDEN');
		}
		return C('API_RETURN_SUCCEED');
	}

	public function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return C('API_RETURN_FORBIDDEN');
		}
		return C('API_RETURN_SUCCEED');
	}

	public function updatecredit($get, $post) {
		if(!C('API_UPDATECREDIT')) {
			return C('API_RETURN_FORBIDDEN');
		}
		$credit = $get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];
		return C('API_RETURN_SUCCEED');
	}

	public function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return C('API_RETURN_FORBIDDEN');
		}
	}

	public function getcreditsettings($get, $post) {
		if(!C('API_GETCREDITSETTINGS')) {
			return C('API_RETURN_FORBIDDEN');
		}
		$credits = array();
		return $this->_serialize($credits);
	}

	public function updatecreditsettings($get, $post) {
		if(!C('API_UPDATECREDITSETTINGS')) {
			return C('API_RETURN_FORBIDDEN');
		}
		return C('API_RETURN_SUCCEED');
	}

	public function get_user($get){
		$UcSend = new \Com\UCenter\UcSend(C('BBS_URL'),C('BBS_KEY'),C('BBS_APIID'));
		$user=$UcSend->uc_get_user($get['username']);
		return $user;
	}
}