<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/14
 * Time: 10:56
 */

namespace app\index\model;


use think\Model;

class Cate extends Model
{
    //获取所有子分类ids
    function getCateIds($cate_id){
        //获取所有数据
        $list=$this->select();
        $children=$this->fromat($list,$cate_id);
        foreach ($children as $key=>$value){
            $children_id[]=$value['id'];
        }
        $children_id[]=$cate_id;
        $children_id=implode(',',$children_id);
        return $children_id;
    }
    //格式化数据
    function fromat($data,$id){
        $list=array();
        foreach ($data as $key =>$value){
            if ($value['pid']==$id){
                $list[]=$value;
                //通过递归找出所有子分类
                $this->fromat($data,$value['id']);
            }
        }
        return $list;
    }

    //获取当前分类信息及上级分类
   function getParentInfo($cate_id)
    {
        //获取所有数据
        $list=$this->select();
        //通过cateid获取他的pid
        $info=db('cate')->where('id='.$cate_id)->find();
        $pid=$info['pid'];
        if ($pid){
            //格式化获取当前获取父类信息
            $parent=$this->formParent($list,$pid);
        }
        $parent[]=$info;
      return $parent;

    }
    //获取父类信息
    function formParent($data,$pid){
        static $list=array();
        foreach ($data as $key => $value){
            if ($value['id']==$pid){
                $list[]=$value;
                //获取所有的父类信息
                $this->formParent($data,$value['pid']);
            }
        }
        return  $list;
    }

    //获取头部推荐分类
    function getRecTop(){
        return $this->where('rec_top=1')->order('id desc')->limit(6)->select();
    }
    //获取底部推荐分类
    function getRecBottom(){
        return $this->where('rec_bottom=1')->order('id desc')->limit(6)->select();
    }
}