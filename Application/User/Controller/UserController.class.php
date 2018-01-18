<?php
namespace User\Controller;
use Think\Controller;
/**
 * 用户首页控制器
 */
class UserController extends Controller {

    /**
     * 用户控制器初始化
     */
    protected function _initialize(){
        // 获取当前用户ID
        define('UID',is_user_login());
        if(!UID && REQUEST_METHOD!='OPTIONS'){// 还没登录 跳转到登录页面
            $this->redirect('Public/login');
        }
        /* 读取数据库中的配置 */
        $config =   S('DB_CONFIG_DATA');
        if(!$config){
            $config =  config_lists();
            S('DB_CONFIG_DATA',$config);
        }
        C($config);
        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
		$this->webpath=__ROOT__."/";
		$this->webtitle=C("WEB_SITE_TITLE");
		$this->weblogo=C("WEB_LOGO");
		$this->keywords=C("WEB_SITE_KEYWORD");
		$this->description=C("WEB_SITE_DESCRIPTION");
		$this->icp=C("WEB_SITE_ICP");
		$this->weburl=C("WEB_URL");
		$this->webname=C("WEB_NAME");
		$info = D('Users')->info(UID);
		$info['path']=$info['path']?$info['path']:__ROOT__ . '/Public/' . MODULE_NAME . '/images/user.jpg';
		$this->assign(D('Users')->info(UID));
        C('CACHE_PATH',RUNTIME_PATH."/Cache/".MODULE_NAME."/Web/");
        $this->tplpath=$this->webpath.C("TPL_PATH").'web/'.C("DEFAULT_WEB_TPl");
        C('VIEW_PATH',APP_PATH.MODULE_NAME.'/'.C('DEFAULT_V_LAYER').'/web/');
        define('MOBILE','web');
	}
	
	 /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param array        $base    基本的查询条件
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     *
     * @return array|false
     * 返回数据集
     */
    protected function lists ($model,$where=array(),$order='',$rows=0,$base = array('status'=>array('egt',0)),$field=true){
        $options    =   array();
        $REQUEST    =   (array)I('request.');
        if(is_string($model)){
            $model  =   M($model);
        }
        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);

        $pk         =   $model->getPk();
        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);
        $options['where'] = array_filter(array_merge( (array)$base, /*$REQUEST,*/ (array)$where ),function($val){
            if($val===''||$val===null){
                return false;
            }else{
                return true;
            }
        });
        if( empty($options['where'])){
            unset($options['where']);
        }
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = $rows > 0 ? $rows : 10;
        }
        $page = new \Think\Page($total, $listRows, $REQUEST);
        if($total>$listRows){
            if(is_mobile()){
                $page->setConfig('prev','上一页');
                $page->setConfig('next','下一页');
                $page->setConfig('theme','%UP_PAGE% %DOWN_PAGE%');
            }else{
                $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            }
        }
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);
        $options['limit'] = $page->firstRow.','.$page->listRows;
        $model->setProperty('options',$options);
        return $model->field($field)->select();
    }
}
