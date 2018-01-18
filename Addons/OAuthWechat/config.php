<?php
return [
	'login_img'=>[//配置在表单中的键名 ,这个会是config[random]
		'title'=>'微信图标:',//表单的文字
		'type'=>'text',		 //表单的类型：text、textarea、checkbox、radio、select等
		'value'=>'/addons/OAuthWechat/images/login-wx.png',			 //表单的默认值
	],
	'login_wechat_web_appid'=>[
		'title'=>'Web登录微信appid:',
		'type'=>'text',
		'value'=>'',
	],
	'login_wechat_web_appsecret'=>[//配置在表单中的键名 ,这个会是config[random]
		'title'=>'Web登录微信appsecret:',//表单的文字
		'type'=>'text',		 //表单的类型：text、textarea、checkbox、radio、select等
		'value'=>'',			 //表单的默认值
	]
];