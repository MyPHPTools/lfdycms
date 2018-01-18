<?php
namespace User\Model;
use Think\Model;

class RecomModel extends Model {

	public function sign($id){
		$map['user_id']=UID;
		$map['type']=2;
		$map['action_id']=M('Action')->getFieldByName('users_sign','id');
		$map['create_time']=array('lt', strtotime("-1 month"));
		M('ActionLog')->where($map)->delete();
		unset($map['create_time']);
        $hasSign=M('ActionLog')->where($map)->order('id desc')->find();
        $count=M('Users')->where('id='.UID)->getField('sign');
		$lastSign=date('Y-m-d',$hasSign['create_time']);
		$today=date('Y-m-d',time());
		if($lastSign==$today){
			return "今天已签到!";
		}
		if($this->isStreakDays($hasSign['create_time'],time()) && $count<7){
			M('Users')-> where('id='.UID)->setInc('sign');
		}else{
			M('Users')-> where('id='.UID)->setField('sign',1);
		}
		$integral=C('USER_SIGN_'.$count);
		M('Users')->where('id='.UID)->setInc('integral',$integral);
		action_log('users_sign','users',$integral,UID);
		return "签到成功,您已连续签到 <font color='red'> {$count} </font> 天,<font color='red'> +{$integral} </font>分!";
	}
	
	public function rlink($uid){
		$map['user_id']=$uid;
		$map['type']=2;
		$map['action_id']=M('Action')->getFieldByName('users_rlink','id');
		$map['create_time']=array('gt', strtotime("-24 hours"));
		$count=M('ActionLog')->where($map)->count();
		if($count>C('USER_RLINK_COUNT')){
			return "5|推广失败,推广数量已到达今日上限!";
		}
		$map['create_time']=array('lt', strtotime("-1 month"));
		M('ActionLog')->where($map)->delete();
		$map['action_ip']= array('eq',ip2long(get_client_ip()));
		$map['create_time']= array('egt',strtotime("-1 month"));
		$link=M('ActionLog')->where($map)->order('id desc')->find();
		if($link){
			return "5|推广失败,请不要重复推广同一用户否则视为作弊!";
		}else{
			$integral=C('USER_RLINK');
			M('Users')->where('id='.$uid)->setInc('integral',$integral);
			action_log('users_rlink','users',$integral,$uid);
			return "6|推广成功,您的推广用户获得 <font color='red'> +{$integral} </font>分,您注册后也可以通过推广赚积分换礼物!";
		}
	}
	
	public function play(){
		$map['user_id']=UID;
		$map['type']=2;
		$map['action_id']=M('Action')->getFieldByName('users_play','id');
		$map['create_time']=array('gt', strtotime("-24 hours"));
		$count=M('ActionLog')->where($map)->count();
		if($count<=C('USER_PLAY_COUNT')){
			$map['create_time']=array('lt', strtotime("-1 month"));
			M('ActionLog')->where($map)->delete();
			unset($map['create_time']);
			$integral=C('USER_PLAY');
			M('Users')->where('id='.UID)->setInc('integral',$integral);
			action_log('users_play','users',$integral,UID);
		}
	}
	
	
	//判断是否连续的两天
    protected function isStreakDays($pre,$latter){
        //时间戳转换为字符串
        $str_pre=date('Ymd',$pre);
        $pre_y=(int)substr($str_pre,0,4);
        $pre_m=(int)substr($str_pre,4,2);
        $pre_d=(int)substr($str_pre,6,2);
        $str_latter=date('Ymd',$latter);
        $latter_y=(int)substr($str_latter,0,4);
        $latter_m=(int)substr($str_latter,4,2);
        $latter_d=(int)substr($str_latter,6,2);
        if($latter_d==1){//是1号的情况
            if($latter_m==1){//如果是1月1号
                if($latter_y-$pre_y>1){//如果不是邻年
                    return false;
                }else{
                    if($pre_m==12 && $pre_d==31){
                        return true;
                    }else{
                        return false;
                    }
                }
            }elseif($latter_m==3){//如果是3月1号
                if($pre_m==2){//是不是2月
                    $flagrunnian=$this->runnian($latter_y);
                    if($flagrunnian){//如果是闰年
                        if($pre_d==29){
                            return true;
                        }else{
                            return false;
                        }
                    }else{//如果不是闰年
                        if($pre_d==28){
                            return true;
                        }else{
                            return false;
                        }
                    }
                }else{
                    return false;
                }
            }elseif($latter_m==2 || $latter_m==4 || $latter_m==6 || $latter_m==8 || $latter_m==9 || $latter_m==11){
                if(($latter_m-$pre_m)==1 && $pre_d==31){
                    return true;
                }else{
                    return false;    
                }
            }else{//如果是5月1号，7月1号，10月1号，12月1号
                if(($latter_m-$pre_m)==1 && $pre_d==30){
                    return true;
                }else{
                    return false;    
                }
            }
        }else{//不是1号的情况
            $result=$latter_d-$pre_d;
            if($result==1){
                return true;
            }else{
                return false;
            }
        }
    }
    protected function runnian($year){
        if(($year%4==0) && ($year % 100!=0) || ($year % 400==0)){
            return true;
        }else{
            return false;
            }
    }
}