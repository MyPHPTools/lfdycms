<?php
namespace Home\Controller;
use Think\Controller;

class AdController extends Controller {

    public function index($id){
    	$map['adid']=$id;
    	$map['status']=1;
    	$map['create_time']=array('elt',NOW_TIME);
    	$map['end_time']=array('egt',NOW_TIME);
    	$ad=M("Ad")->field('width,height')->where(array('id'=>$id,'status'=>1))->find();
    	$adc=M('AdContent')->where($map)->order('id asc')->find();
    	$html="document.write(\"<a href='".$adc['link']."' target='_blank'><img src='".get_cover($adc['cover_id'],"path")."'></a>\")";
        $this->show($html);
    }
}
