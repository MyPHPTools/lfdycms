<?php
namespace User\Model;
use Think\Model;
use Think\Upload;
use Think\Storage;
use Think\Image;

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
        $Upload = new Upload($setting, $driver, $config);
        $info   = $Upload->upload($files);
        if($info){
			foreach ($info as $key => &$value) {
                $value['path'] = substr($setting['rootPath'], 1).$value['savepath'].$value['savename'];	//在模板里的url路径
            }
            return $info; //文件上传成功
        } else {
            $this->error = $Upload->getError();
            return false;
        }
    }
	
	public function cropImg($params){
		$driver = C('PICTURE_UPLOAD');
		$Image = new Image();
		$Image->open($driver['rootPath'].$driver['saveName'].".".$driver['saveExt']);
		$params = explode(',', $params);
		$pdir=$driver['rootPath'].uniqid().".".$driver['saveExt'];
		$Image->crop($params[2],$params[3],$params[0],$params[1])->save($pdir);
		$data["path"]=substr($pdir, 1);
		$delpath = M("Users")->where('id='.UID)->getField('path');
		Storage::unlink($delpath);
		M("Users")->where('id='.UID)->save($data);
		return $pdir;
	}
}
