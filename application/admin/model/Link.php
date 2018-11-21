<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/10
 * Time: 1:54
 */

namespace app\admin\model;


use think\Model;

class Link extends Model
{

    //通过id找到一条数据
    function getOne($id){
        return $this->where('id='.$id)->find();
    }
    //编辑
    //编辑用户
    function edit($data){
        return $this->update($data);
    }
    //栏目删除
    function dels($id){
            return $this->where('id='.$id)->delete();
    }

}