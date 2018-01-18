<?php
namespace Common\Behavior;
use Think\Behavior;
use Think\Hook;
defined('THINK_PATH') or exit();

// 初始化钩子信息
class InitHookBehavior extends Behavior {

    // 行为扩展的执行入口必须是run
    public function run(&$content){
        if(defined('BIND_MODULE') && BIND_MODULE === 'Install') return;
        $data = S('hooks');
        if(!$data){
			$map['status']  =   1;
			$addons = M('Addons')->where($map)->field('name')->select();
			foreach ($addons as $key => $value) {
				Hook::add($value['name'],get_addon_class($value['name']));
			}
            S('hooks',Hook::get());
        }else{
            Hook::import($data,false);
        }
    }
}