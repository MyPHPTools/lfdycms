<?php

function user_info($id){
	$map['id'] = $id;
	$map['status']=1;
	$info=M('users')->where($map)->field('id,username,password,email,path,introduction,integral,sign,vip_time,favorites_password')->find();
	$info['path']=$info['path']?$info['path']:"/Public/User/web/images/user.jpg";
	$info['userurl']=U('User/Index/index');
	$info['userlogin']=U('/User/Public/login');
	$info['userreg']=U('/User/Public/reg');
	$info['userlogout']=U('/User/Public/logout');
	return $info;
}
?>