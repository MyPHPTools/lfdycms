<?php
return [
	'login_img'=>[//配置在表单中的键名 ,这个会是config[random]
		'title'=>'QQ图标:',//表单的文字
		'type'=>'text',		 //表单的类型：text、textarea、checkbox、radio、select等
		'value'=>'/addons/OAuthQQ/images/login-qq.png',			 //表单的默认值
	],
	'appid'=>[//配置在表单中的键名 ,这个会是config[random]
		'title'=>'QQappid:',//表单的文字
		'type'=>'text',		 //表单的类型：text、textarea、checkbox、radio、select等
		'value'=>'',			 //表单的默认值
	],
	'appkey'=>[//配置在表单中的键名 ,这个会是config[random]
		'title'=>'QQappkey:',//表单的文字
		'type'=>'text',		 //表单的类型：text、textarea、checkbox、radio、select等
		'value'=>'',			 //表单的默认值
	],
	'callback'=>[
		'title'=>'回调地址:',
		'type'=>'copy',
		'value'=>str_replace('admin.php','index.php',U('addons/oauthqq/callback','','',true)),
		'tip'=>'回调地址 域名+/addons/oauthqq/callback'
	],
];