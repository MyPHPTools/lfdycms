<?php
try {
	$route=F('route');
   	if(!$route){
		$data=M('route')->select();
		foreach ($data as $key => $value) {
			$route[$value['name']]=json_decode($value['value'],true);
		}
		F('route',$route);
	}
	return array('URL_ROUTE_RULES'=>$route);
}catch(Exception $e){}