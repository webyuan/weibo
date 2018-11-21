<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/8
 * Time: 19:37
 */

namespace app\admin\model;


use think\Model;

class Cate extends Model
{
    function addCate($data){
       return $this->save($data);
    }

    //获取分类信息
    function getCateTree(){
        //获取分类
        $list= $this->select();
        //格式化 数据
        $list=$this->fromat($list);
        return $list;
    }
    //格式化分类信息增加lev
    function fromat($data,$id=0,$lev=1){
        static $list=array();
        foreach ($data as $key => $value) {
            if ($value['pid']==$id) {
                $value['lev']=$lev;
                $list[]=$value;
                //使用递归找出子分类
                $this->fromat($data,$value['id'],$lev+1);
            }
        }
        return $list;
    }

    //栏目删除
    function dels($id){
        //如果找到了一条数据的pid等于了他的id那么说明他有 子分类则不能删除
        $result=$this->where('pid='.$id)->find();
        if ($result){
            return false;
        }else{
            return $this->where('id='.$id)->delete();
        }
    }
    //编辑时得到一条数据
    function getOne($id){
        return $this->where('id='.$id)->find();
    }

    //修改数据
    function edit($data){
        return $this->update($data);
    }
}