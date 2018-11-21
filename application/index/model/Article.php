<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/14
 * Time: 10:37
 */

namespace app\index\model;


use think\Model;

class Article extends Model
{   //根据分类信息获取文章信息
    function getArticle($cateid){
        //获取所有子分类id
        $cate=new Cate();
        $children_ids=$cate->getCateIds($cateid);
        $data=db('Article')->where("cateid in ($children_ids)")->paginate(3);
        //var_dump($children_ids);exit();
        return $data;
    }
    //根据id获取一条文章
    function getOneArt($id){
        return $this->where('id='.$id)->find();
    }
    //获取热点文章
    function getHotArt(){
        return $this->limit(5)->order('id desc')->select();
    }

    //获取全部文章信息index用
    function getAllArt($limit){
        return $this->order('id desc')->limit($limit)->select();
    }

    //获取热点推荐
    function getRec(){
        return $this->where('is_rec=1')->limit(4)->select();
    }
}
