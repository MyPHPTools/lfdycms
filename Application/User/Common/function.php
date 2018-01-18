<?php
function show_mode($mode) {
    switch ($mode){
        case 0  : return    '未发货';     break;
        case 1  : return    '已发货';     break;
		case 2  : return    '取消交易';     break;
        default : return    false;      break;
    }
}

function get_prize_name($id = 0){
	$info = M('prize')->field('title')->find($id);
	if($info !== false && $info['title'] ){
		$name = $info['title'];
	} else {
		$name = '';
	}
    return $name;
}

function get_recom_url(){
	if(substr(C("WEB_URL"),0,7) != 'http://'){
		$url = 'http://'.C("WEB_URL");
	}else{
		$url = C("WEB_URL");
	}
	return $url."/?userID=".UID;
}

function recordArray($uid=''){
	if($uid){
		$movHistory=M('PlayerLog')->where('uid='.$uid)->getField('log');
	}else{
		$movHistory=cookie('movHistory');
	}
	$movHistory=json_decode(trim(stripslashes($movHistory),'"'),true);
	foreach ($movHistory as $key=>$value){
		$timeType=timeType(substr($value['time'],0,10));
		$info=D('Movie')->field(true)->find($value['id']);
		$recordMov[$timeType]['type']=timeTypeName($timeType);
		$recordMov[$timeType]['movie'][$key]=D('Home/Tag')->movieChange($info,'movie');
		$recordMov[$timeType]['movie'][$key]['url']=$value['url'];
		$recordMov[$timeType]['movie'][$key]['purl']=$value['purl'];
	}
	return $recordMov;
}

function timeType($timestamp,$current_time=0){
	if(!$current_time) $current_time=time();
	$span=$current_time-$timestamp;
	if($span<24*3600){
		return 1;
	}else if($span<(7*24*3600)){
		return 2;
	}else{
		return 3;
	}
}

function timeTypeName($type){
	switch ($type){
	case 1:
		return "今天";
		break;  
	case 2:
		return "一周";
		break;
	default:
		return "更早";
	}
}

//只留下单一元素
function a_array_unique($array){
   $out = array();
   foreach ($array as $key=>$value) {
	   	$out[$value['id']] = $value;
   }
   return $out;
}

function unescape($str){
    $ret = '';
    $len = strlen ( $str );  
    for($i = 0; $i < $len; $i ++) {  
        if ($str [$i] == '%' && $str [$i + 1] == 'u') {
            $val = hexdec ( substr ( $str, $i + 2, 4 ) );
            if ($val < 0x7f)
                $ret .= chr ( $val );
            else if ($val < 0x800)
                $ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );
            else
                $ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );
            $i += 5;
        } else if ($str [$i] == '%') {
            $ret .= urldecode ( substr ( $str, $i, 3 ) );
            $i += 2;
        } else
            $ret .= $str [$i];
    }  
    return $ret;  
}

function sendMail($to, $title, $content){
    import('Com.PHPMailer.PHPMailerAutoload');
    $mail = new \PHPMailer();
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的客户");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject =$title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    return($mail->Send());
}

function check_verify($code, $id = 1){
    ob_clean();
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

function user_info($id){
	$map['id'] = $id;
	$map['status']=1;
	$info=M('users')->where($map)->field('id,username,password,email,path,introduction,integral,sign,vip_time,favorites_password')->find();
	$info['path']=$info['path']?$info['path']:"/Public/User/images/user.jpg";
	$info['userurl']=U('User/Index/index');
	$info['userlogin']=U('/User/Public/login');
	$info['userreg']=U('/User/Public/reg');
	$info['userlogout']=U('/User/Public/logout');
	return $info;
}
?>