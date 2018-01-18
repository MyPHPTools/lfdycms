<?php
namespace Admin\Model;
use Think\Model;

class ToolModel extends Model{
	
	/**
     * 删除影片
     * @return true 删除成功， false 删除失败
     */
    public function remove_movie(){
        $movie=M('movie')->field('id,cover_id,content')->select();
        foreach ($movie as $key => $value) {
            $path=M('picture')->where(array('id'=>$value['cover_id']))->getField('path');
            if($path){
                unlink('.'.$path);
            }
            $imgpreg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
            preg_match_all($imgpreg,htmlspecialchars_decode($value['content']),$img);
            foreach ($img[2] as $k => $v) {
                unlink('.'.$v);
            }
            M('picture')->where(array('id'=>$value['cover_id']))->delete();
            M('movie_url')->where(array('movie_id'=>$value['id']))->delete();
            M('comment')->where(array('mid'=>$value['id']))->delete();
            M('movie')->where(array('id'=>$value['id']))->delete();
        }
	}

    public function remove_user(){
        $users=M('users')->field('id')->select();
        foreach ($users as $key => $value) {
            M('users_follow')->where(array('uid'=>$value['id']))->delete();
            M('pay_log')->where(array('uid'=>$value['id']))->delete();
            M('exchange')->where(array('uid'=>$value['id']))->delete();
            M('favorites')->where(array('uid'=>$value['id']))->delete();
            M('message')->where(array('uid'=>$value['id']))->delete();
            M('comment')->where(array('uid'=>$value['id']))->delete();
            M('users')->where(array('id'=>$value['id']))->delete();
        }
        dropDir('./Uploads/User/');
    }

    public function remove_news(){
        $news=M('news')->field('id,cover_id,content')->select();
        foreach ($news as $key => $value) {
            $path=M('picture')->where(array('id'=>$value['cover_id']))->getField('path');
            if($path){
                unlink('.'.$path);
            }
            $imgpreg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
            preg_match_all($imgpreg,htmlspecialchars_decode($value['content']),$img);
            foreach ($img[2] as $k => $v) {
                unlink('.'.$v);
            }
            M('picture')->where(array('id'=>$value['cover_id']))->delete();
            M('news')->where(array('id'=>$value['id']))->delete();
        }
    }

    public function data_replace(){
        $map=array();
        if($_POST['category']){
            $cid=D('Movie')->getId(I('category'));
            if(is_numeric($cid)){
                $map['category']  = $cid;
            } else {
                $map['category'] = array('in', $cid);
            }
        }
        switch (I('field')) {
            case 'path':
            case 'url':
                $tag_ar=M('movie')->where($map)->getField('cover_id',true);
                $map1['id']=array('in',$tag_ar);
                $data[I('field')] = array('exp','replace('.I('field').',"'.I('str1').'","'.I('str2').'")');
                M('picture')->where($map1)->save($data);
                break;
            case 'movie_url':
                $tag_ar=M('movie')->where($map)->getField('id',true);
                $map1['movie_id']=array('in',$tag_ar);
                $data[I('field')] = array('exp','replace('.I('field').',"'.I('str1').'","'.I('str2').'")');
                M('movie_url')->where($map1)->save($data);
                break;
            case 'movie_player_id':
                $tag_ar=M('movie')->where($map)->getField('id',true);
                $map1['movie_id']=array('in',$tag_ar);
                $data[I('field')] = array('exp','replace('.I('field').',"'.I('s_str1').'","'.I('s_str2').'")');
                M('movie_url')->where($map1)->save($data);
                break;
            default:
                $data[I('field')] = array('exp','replace('.I('field').',"'.I('str1').'","'.I('str2').'")');
                M('movie')->where($map)->save($data);
                break;
        }
    }

    public function data_random(){
       $list = M('movie')->field('id')->select();
       foreach ($list as $key => $value) {
            $data=array();
            foreach (I('field') as $k => $v) {
                $data[$v]=rand(I('str1'),I('str2'));
            }
           M('movie')->where(array('id'=>$value['id']))->save($data);
       }
    }
}
