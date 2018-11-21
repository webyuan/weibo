<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/13
 * Time: 23:16
 */

namespace app\index\controller;


use app\index\model\Cate;
use think\Controller;

class Common extends Controller
{
    function _initialize()
    {
        //获取分类信息
        $cate=$this->getNavCate();
        //显示面包屑信息
        //如果是文章列表页
        if (input('cate_id')){
            $this->getPosAttr(input('cate_id'));
        }
        //如果文章页
        if (input('art_id')){
            //获取当前文章的分类信息
            $art_id=input('art_id');
            $art=new \app\index\model\Article();
            $article=$art->where('id='.$art_id)->find();
            $this->getPosAttr($article['cateid']);
        }
        //底部推荐分类
        $this->getRecBottom();

    }
    //获取分类信息
    function getNavCate(){
        $cate=db('Cate')->select();
        $list=array();
        //获取主分类信息
        foreach ($cate as $key => $value){
            if ($value['pid']==0){
                $list[]=$value;
            }
        }
        //将二级分类合并到一级分类
       foreach ($list as $k => $v){
            foreach ($cate as $pk => $pv){
                if ($v['id']==$pv['pid']){
                    $list[$k]['children'][]=$pv;
                }
            }
        }
        $this->assign('cate',$list);
    }
    //获取父类分类信息
    function getPosAttr($id){
        $cate=new Cate();
        $posAttr=$cate->getParentInfo($id);
        $this->assign('pos',$posAttr);
    }

    //获取底部推荐分类
    function getRecBottom(){
        $cate=new Cate();
        $data=$cate->getRecBottom();
        $this->assign('recBottom',$data);

    }
}