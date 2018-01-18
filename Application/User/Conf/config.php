<?php
/**
 * 用户配置文件
 */
return array(
    /* 数据缓存设置 */
    'DATA_CACHE_PREFIX'    => 'lf_user_', // 缓存前缀
    'DATA_CACHE_TYPE'      => 'File', // 数据缓存类型

    /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => false, //自动子目录保存文件
		'subName'  => '', //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => './Uploads/User/', //保存根路径
		'savePath' => '', //保存路径
		'saveName' => 'temp', //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => 'jpg', //文件保存后缀，空则使用原后缀
		'replace'  => true, //存在同名是否覆盖
		'hash'     => false, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）

    'PICTURE_UPLOAD_DRIVER'=>'local',
    //本地上传文件驱动配置
    'UPLOAD_LOCAL_CONFIG'=>array(),
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/web/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/web/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/web/js',
        '__WAPIMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/wap/images',
        '__WAPCSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/wap/css',
        '__WAPJS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/wap/js',
    ),

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'lf_users', //session前缀
    'COOKIE_PREFIX'  => 'lf_users_', // Cookie前缀 避免冲突
    'VAR_SESSION_ID' => 'session_id',	//修复uploadify插件无法传递session_id的bug

    'TMPL_ACTION_ERROR'   =>  'Public/dispatch_jump',
    'TMPL_ACTION_SUCCESS'   =>  'Public/dispatch_jump',
);