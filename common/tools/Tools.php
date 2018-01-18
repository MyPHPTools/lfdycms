<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 18-1-18
 * Time: 上午11:45
 */

namespace common\tools;


class Tools
{
    /**
     * 生成目录
     * @access public
     * @param string $path 目录位置与名称
     * @return void
     * @author wodrow <wodrow451611cv@gmail.com | 1173957281@qq.com>
     */
    public static function createDir($path)
    {
        return is_dir($path) or (self::createDir(dirname($path)) and mkdir($path, 0777));
    }

    public static function test()
    {
        echo 123456;exit;
    }
}