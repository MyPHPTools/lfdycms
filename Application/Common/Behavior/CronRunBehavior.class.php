<?php
namespace Common\Behavior;
use Think\Behavior;
defined('THINK_PATH') or exit();

class CronRunBehavior  extends Behavior {

	public function run(&$params) {
		$this -> checkTime();
	}

	private function checkTime() {
		if(F('CRON_CONFIG')){
			$crons = F('CRON_CONFIG');
		}
		if (!empty($crons) && is_array($crons)) {
			$update = false;
			foreach ($crons as $key => $cron) {
				if (empty($cron[2]) || $_SERVER['REQUEST_TIME'] > $cron[2]) {
					S('cron_token',true);
					$this->asyncronous(U($cron[0],array('keys'=>$key)));
					$cron[2] = $_SERVER['REQUEST_TIME'] + $cron[1];
					$crons[$key] = $cron;
					$update = true;
				}
			}
			if ($update) {
				F('CRON_CONFIG', $crons);
			}
		}
	}

	protected function  asyncronous($url){
		if(function_exists('fsockopen')){
			$server=$_SERVER['HTTP_HOST'];
		    $fp = fsockopen($server,$_SERVER["SERVER_PORT"],$errno,$errstr,30); 
		    $out = "GET /$url  / HTTP/1.1\r\n";
		    $out .= "Host: $server\r\n";
		    $out .= "Connection: Close\r\n\r\n";
		    fwrite($fp, $out);
		    fclose($fp);
		}else{
			echo '<img style="visibility:hidden;" src="'.$url.'">';
		}
	}
}
