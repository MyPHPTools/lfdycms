<?php
return array(
	// 'URL_MODEL' => 2,
	'DATA_CACHE_PREFIX'    => 'lf_', // 缓存前缀
    'DATA_CACHE_TYPE'      => 'File', // 数据缓存类型
	/* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'lf_users', //session前缀
    'COOKIE_PREFIX'  => 'lf_users_', // Cookie前缀 避免冲突

    'API_DELETEUSER' => 1,		//note 用户删除 API 接口开关
	'API_RENAMEUSER' => 1,		//note 用户改名 API 接口开关
	'API_GETTAG' => 1,		//note 获取标签 API 接口开关
	'API_SYNLOGIN' => 1,		//note 同步登录 API 接口开关
	'API_SYNLOGOUT' => 1,		//note 同步登出 API 接口开关
	'API_UPDATEPW' => 1,		//note 更改用户密码 开关
	'API_UPDATEBADWORDS' => 1,	//note 更新关键字列表 开关
	'API_UPDATEHOSTS' => 1,		//note 更新域名解析缓存 开关
	'API_UPDATEAPPS' => 1,		//note 更新应用列表 开关
	'API_UPDATECLIENT' => 1,		//note 更新客户端缓存 开关
	'API_UPDATECREDIT' => 1,		//note 更新用户积分 开关
	'API_GETCREDITSETTINGS' => 1,	//note 向 UCenter 提供积分设置 开关
	'API_GETCREDIT' => 1,		//note 获取用户的某项积分 开关
	'API_UPDATECREDITSETTINGS' => 1,	//note 更新应用积分设置 开关

	//返回结果
	'API_RETURN_SUCCEED' => '1',
	'API_RETURN_FAILED' => '-1',
	'API_RETURN_FORBIDDEN' => '-2'
);