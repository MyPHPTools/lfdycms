<?php
// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false ture
define('APP_DEBUG',true);
define('BIND_MODULE','Install');

// 定义应用目录
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH.'/Application/');

spl_autoload_register(function($className){
    $_file = ROOT_PATH . "/" . str_replace('\\', '/', $className) .".php";
    if (file_exists($_file)) {
        require $_file;
    }
});

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单