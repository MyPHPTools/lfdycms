<?php
// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false ture
define('APP_DEBUG',true);
define('BIND_MODULE','Admin');

// 定义应用目录
define('APP_PATH','./Application/');

if(!is_file(APP_PATH . 'Common/Conf/config.php')){
	header('Location: ./install.php');
	exit;
}

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单