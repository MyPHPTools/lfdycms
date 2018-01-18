<?php
namespace Admin\Model;
use Think\Model;
use Think\Upload;
use Think\Storage;

/**
 * 图片模型
 * 负责图片的上传
 */

class PictureModel extends Model{
    /**
     * 自动完成
     * @var array
     */
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    /**
     * 文件上传
     * @param  array  $files   要上传的文件列表（通常是$_FILES数组）
     * @param  array  $setting 文件上传配置
     * @param  string $driver  上传驱动名称
     * @param  array  $config  上传驱动配置
     * @return array           文件上传成功后的信息
     */
    public function upload($files, $setting, $driver = 'Local', $config = null){
        /* 上传文件 */
        $setting['callback'] = array($this, 'isFile');
		$setting['removeTrash'] = array($this, 'removeTrash');
        $Upload = new Upload($setting, $driver, $config);
        $info   = $Upload->upload($files);

        if($info){ //文件上传成功，记录文件信息
            foreach ($info as $key => &$value) {
                /* 已经存在文件记录 */
                if(isset($value['id']) && is_numeric($value['id'])){
                    continue;
                }
                if(C('IMAGE_WATER_ON') && I('get.water')==1){
                    $image = new \Think\Image();
                    $image->open($setting['rootPath'].$value['savepath'].$value['savename'])->water(C('IMAGE_WATER_PIC'),C('IMAGE_WATER_POSITION'))->save($setting['rootPath'].$value['savepath'].$value['savename']);
                }

                /* 记录文件信息 */
                $value['path'] = substr($setting['rootPath'], 1).$value['savepath'].$value['savename'];	//在模板里的url路径
                if($this->create($value) && ($id = $this->add())){
                    $value['id'] = $id;
                } else {
                    //TODO: 文件上传成功，但是记录文件信息失败，需记录日志
                    unset($info[$key]);
                }
            }
            return $info; //文件上传成功
        } else {
            $this->error = $Upload->getError();
            return false;
        }
    }

    /**
     * 检测当前上传的文件是否已经存在
     * @param  array   $file 文件上传数组
     * @return boolean       文件信息， false - 不存在该文件
     */
    public function isFile($file){
        if(empty($file['md5'])){
            throw new \Exception('缺少参数:md5');
        }
        /* 查找文件 */
		$map = array('md5' => $file['md5'],'sha1'=>$file['sha1']);
        return $this->field(true)->where($map)->find();
    }

	/**
	 * 清除数据库存在但本地不存在的数据
	 * @param $data
	 */
	public function removeTrash($data){
		$this->where(array('id'=>$data['id'],))->delete();
	}
	
	public function down_load($url){
		if (C('COLLECT_DOWN_IMG') && strpos($url,'://')>0) {
            $id=$this->isUrl($url);
            if($id){
                return $id['id'];
            }
			if($date=$this->down_img($url)){
				if($file=$this->isFile($date)){
					Storage::unlink($date["path"]);
					return $file['id'];
				}else{
					return $this->data($date)->add();
				}
			}else{
				$date=array("url"=>$url,"status"=>"1","create_time"=>time());
				return $this->data($date)->add();
			}
		}else{
			$id=$this->isUrl($url);
			if($id){
				return $id['id'];
			}else{
				$date=array("url"=>$url,"status"=>"1","create_time"=>time());
				return $this->data($date)->add();
			}
		}
	}
	public function down_img($url){
        $chr = pathinfo($url, PATHINFO_EXTENSION);
        $chr=$chr?".".$chr:".jpg";
		$imgUrl = uniqid();
		$picture=C('PICTURE_UPLOAD');
		$imgPath = date('Y-m-d',time()).'/';
		$filename =$picture['rootPath'].$imgPath.$imgUrl.$chr;
		$collect = new \Org\Net\Http;
		$get_file = $collect->doGet($url);
		if ($get_file){
            if(!in_array(strtolower($chr),array('.jpg','.jpeg','.png','.gif','.bmp'))){
                return false;
            }
			Storage::put($filename,$get_file);
            if(C('IMAGE_WATER_ON')){
                $image = new \Think\Image();
                $image->open($filename)->water(C('IMAGE_WATER_PIC'),C('IMAGE_WATER_POSITION'))->save($filename);
            }
			$date["path"]=substr($filename, 1);
			$date["create_time"]=time();
			$date["md5"]=md5_file($filename);
			$date["sha1"]=sha1_file($filename);
			$date["status"]=1;
			return $date;
		}
	}
	
	public function isUrl($url){
		$map = array('url' => $url);
        return $this->field('id')->where($map)->find();
    }
}
