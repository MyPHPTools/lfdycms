<?php
namespace Admin\Controller;
use Think\Storage;

class TemplateController extends AdminController {

    public function index(){
		if($_GET['path']){
			$path = realpath(C('TPL_PATH').str_replace('*','/',$_GET['path']));
		}else{
			$path = realpath(C('TPL_PATH')."/".C('DEFAULT_TPl')."/");
		}
		$flag = \FilesystemIterator::KEY_AS_PATHNAME;
		$glob = new \FilesystemIterator($path,  $flag);
		foreach ($glob as $name => $file) {
			$info[$name]['title'] = $file->getFilename();
			$info[$name]['type'] = $this->file_type($file->getFilename(),$file->getExtension(),$file->getType());
			$info[$name]['time'] = $file->getATime();
			$info[$name]['size'] = $file->getSize();
			$info[$name]['dir'] = $file->isDir();
			if($file->getType()=="dir"){
				$info[$name]['icon']="icon-folder-open-o text-yellow";
			 	$info[$name]['url']=U("Template/index","path=".$this->file_path($file->getPathname()));
				$info[$name]['edit']='<a href="'.$info[$name]['url'].'">下级目录</a>';
			}else{
				switch ($file->getExtension()){ 
				case "png":
				case "gif":
				case "jpg":
				case "jpeg":
				case "bmp":
					$info[$name]['icon']="icon-file-image-o text-green";
				break;
				case "js":
				case "css":
				case "tpl":
				case "htm":
				case "html":
				case "xml":
					$info[$name]['icon']="icon-file-code-o text-blue";
					$info[$name]['url']=U("Template/edit","path=".$this->file_path($file->getPathname()));
					$info[$name]['edit']='<a href="'.$info[$name]['url'].'">编辑</a>';
				break;
				default:
					$info[$name]['icon']="icon-file-code-o text-blue";
				}
			}
		}
		$file='<a href="'.U("Template/index","path=".$this->dirup($this->file_path($_GET['path']))).'"><span class="icon-reply text-blue"></span> 返回上级目录</a> 当前目录：'.str_replace('*','/',$_GET['path']);
		$this->assign('file', $file);
		$this->assign('info', list_sort_by($info,'dir','desc'));
        $this->meta_title = '模板管理';
        $this->display();
    }
	
	public function edit($path = null){
        if(IS_POST){ //提交表单
			$path = realpath(C('TPL_PATH').str_replace('*','/',I('path')));
            if(Storage::put($path,stripslashes($_POST['content']))==true){
				action_log('update_tpl','path',str_replace('*','/',I('path')),UID);
                $this->success('编辑成功！', U('Template/index',"path=".$this->file_path(dirname($path))));
            } 
        } else {
			$path = realpath(C('TPL_PATH').str_replace('*','/',$_GET['path']));
			$content=Storage::read($path);
			$type=substr(strrchr($path, '.'), 1);
			switch($type){ 
			case "css":
				$mode="css";
			break;
			case "js":
				$mode="application/javascript";
			break;
			default:
				$mode="application/x-httpd-php";
			break;
			}
			$this->assign('title', basename($path));
			$this->assign('path', $this->file_path($path));
			$this->assign('mode', $mode);
            $this->assign('content', $content);
            $this->meta_title = '编辑模板';
            $this->display();
        }
    }
	
	public function config(){
	    if(IS_POST){ //提交表单
			M("Config")->where(array('name'=>'DEFAULT_WEB_TPl'))->setField('value',I('Web_Tpl'));
			M("Config")->where(array('name'=>'DEFAULT_WAP_TPl'))->setField('value',I('Wap_Tpl'));
			S('DB_CONFIG_DATA',null);
			action_log('config_tpl','config',I('Tpl'),UID);
			$this->success('模板设置成功！');
        } else {
			$path = realpath(C('TPL_PATH')."web/");
			$flag = \FilesystemIterator::KEY_AS_PATHNAME;
			$glob = new \FilesystemIterator($path,  $flag);
			foreach ($glob as $name => $file) {
				if($file->getType()=="dir"){
					$info['web'][$name]['title'] = $file->getFilename();
				}
			}
			$this->assign('info', $info);
            $this->meta_title = '设置模板';
            $this->display();
        }
    }
	
	protected function dirup($path){
		if ($path) {
			return substr($path,0,strrpos($path, '*'));
		}else{
			return false;
		}
	}		
	protected function file_path($url){
		return str_replace(array(realpath(C('TPL_PATH')."/"),'\\'),array('','*'),$url);
	}
	protected function file_type($name,$ext,$type){
		switch($name){ 
		case "type.html":
			return "分类模板";
		break;
		case "search.html":
			return "搜索模板";
		break;
		case "player.html":
			return "播放模板";
		break;
		case "movie.html":
			return "内容模板";
		break;
		case "lists.html":
			return "列表模板";
		break;
		case "index.html":
			return "首页模板";
		break;
		case "header.html":
			return "头模板";
		break;
		case "footer.html":
			return "尾模板";
		break;
		default:
			switch($ext){ 
			case "png":
			case "gif":
			case "jpg":
			case "jpeg":
			case "bmp":
				return "图片文件";
			break;
			case "js":
				return "js脚本文件";
			break;
			case "css":
				return "样式文件";
			break;
			default:
				if($type=="dir"){
					return "文件夹";
				}
				return "未知文件";
			}
		}
	}
}
