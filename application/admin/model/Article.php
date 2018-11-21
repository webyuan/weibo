<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/9
 * Time: 15:15
 */

namespace app\admin\model;


use think\Model;

class Article extends Model
{
    protected static function init()
   {    //钩子前置新增之前操作
       Article::event('before_insert', function ($data) {
            $data['addtime']=time();
            if ($_FILES['thumb']['tmp_name']){
                //获取图片
                $file = request()->file('thumb');
                //移动到该目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    $thumb='/bick/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $data['thumb']=$thumb;
                }else{
                    // 上传失败获取错误信息
                   echo $file->getError();
                }

            }
       });
       //钩子函数修改之前
       Article::event('before_update', function ($data) {
           if ($_FILES['thumb']['tmp_name']){
               //删除旧图片
               $old_info=Article::find($data['id']);

               $thumbpath=$_SERVER['DOCUMENT_ROOT'].$old_info['thumb'];
               if(file_exists($thumbpath)){
                   @unlink($thumbpath);
               }
               //获取图片
               $file = request()->file('thumb');
               //移动到该目录下
               $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
               if($info){
                   $thumb='/bick/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                   $data['thumb']=$thumb;


               }else{
                   // 上传失败获取错误信息
                   echo $file->getError();
               }

           }
       });
    }

    //通过id找到一条数据
    function getOne($id){
        return $this->where('id='.$id)->find();
    }
    //编辑
    //编辑用户
    function edit($data){
        return $this->update($data);
    }
}