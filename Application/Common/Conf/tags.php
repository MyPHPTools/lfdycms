<?php
return array(
	'app_init'=>array('Common\Behavior\InitHookBehavior'),
	'app_begin' => array('Common\Behavior\CronRunBehavior')
);