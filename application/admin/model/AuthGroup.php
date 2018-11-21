<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/12
 * Time: 17:01
 */

namespace app\admin\model;



use think\Model;

class AuthGroup extends Model
{
    //编辑时得到一条数据
    function getOne($id){
        return $this->where('id='.$id)->find();
    }

}