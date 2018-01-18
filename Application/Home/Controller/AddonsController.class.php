<?php
namespace Home\Controller;
use Think\Controller;

class AddonsController extends Controller {

    public function run(){
    	$addon_name     =   trim(I('addon_name'));
        $addon_run         =   trim(I('addon_run'));
        $class          =   get_addon_class($addon_name);
        if(!class_exists($class))
            $this->error('插件不存在');
        $addons  =   new $class;
        $info = $addons->info;
        if(!$info || !$addons->checkInfo())//检测信息的正确性
            $this->error('插件信息缺失');
        $addons->$addon_run();
    }
}
