<?php
namespace Admin\Model;
use Think\Model;
use Think\Storage;

class UpdateModel extends Model{
	
	/**
     * 检测版本
     */
    public function version(){
		$http = new \Org\Net\Http;
		$upContent=$http->doGet(C('UPDATE_URL')."index.php?s=/Home/ajax/versionUp.html");
		$upArray=json_decode($upContent, true);
		foreach ($upArray['update'] as $param){
			if(tonum($param['version']) > tonum(C('WEB_VERSION'))){
				S('update_list',null);
				S("update_dir",null);
				$update['update']=true;
				$update['version']=$param['version'];
				$update['content']=$param['content'];
				S("update_dir",$param);
				break;
			}
		}
        return $update;
    }
	
	 /**
     * 更新
     */
    public function update(){
		$num=I('num',0);
		$http = new \Org\Net\Http;
		$upArray=$this->upContent();
		$update=S("update");
		$upCode=$http->doGet(C('UPDATE_URL').$upArray[$num]['file']);
		Storage::put($upArray[$num]['name'],$upCode,'update');
		$date['num']=$num+1;
		return $date;
    }
	
	public function upContent(){
		$upContent=S('update_list');
		if(!$upContent){
			$update=S("update_dir");
			$http = new \Org\Net\Http;
			$upContent=$http->doGet(C('UPDATE_URL').$update['file_dir']."downlist.txt");
			S('update_list',$upContent);
		}
		foreach (explode("\n",$upContent) as $k=>$v){
			$upArray=explode("|",$v);
			$date[$k]["file"]=$upArray[0];
			$date[$k]["name"]=$upArray[1];
			$date[$k]["size"]=$upArray[2];
		}
		return $date;
	}
	
	/**
     * 安装更新
     */
	public function install(){
		$upSql=RUNTIME_PATH.'Update/sql.sql';
		$upDel=RUNTIME_PATH.'Update/del.txt';
		if(Storage::has($upSql,'update')){
			$upSqlCode=Storage::read($upSql,'update');
			$upSqlCode = str_replace("\r", "\n", $upSqlCode);
			$upSqlCode = explode(";\n", $upSqlCode);
			$prefix=C('DB_PREFIX');
			$upSqlCode = str_replace(" `lf_", " `{$prefix}", $upSqlCode);
			foreach ($upSqlCode as $value){
				$this->execute($value);
			}
			Storage::unlink($upSql,'update');
		}
		if(Storage::has($upDel,'update')){
			$upDelCode=Storage::read($upDel,'update');
			$upDelCode = str_replace("\r", "\n", $upDelCode);
			$filePath=explode("\n",$upDelCode);
			foreach ($filePath as $v){
				Storage::unlink($v,'update');
			}
			Storage::unlink($upDel,'update');
		}
		M("Config")->where(array('name'=>'WEB_VERSION'))->setField('value',I('version'));
		S('DB_CONFIG_DATA',null);
		S('update_list',null);
		S("update_dir",null);
		action_log('update_sys',I('version'),'1',UID);
		return true;
	}
}