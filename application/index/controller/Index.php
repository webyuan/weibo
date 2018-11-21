<?php
namespace app\index\controller;
use app\index\model\Article;
use app\index\model\Cate;

class Index extends Common
{
    public function index()
    {   //实例化文章模型
        $art=new Article();
        //获取所有文章
        $allArt=$art->getAllArt(4);
        //获取热点文章
        $hot=$art->getHotArt();
        //获取友情链接
        $link=db('link')->select();
        //获取热点推荐
        $rec=$art->getRec();
        //是否推荐分类
        $cate=new Cate();
        $recTop=$cate->getRecTop();
        $this->assign([
            'allArt'=>$allArt,
            'hot'=>$hot,
            'link'=>$link,
            'rec'=>$rec,
            'recTop'=>$recTop,
        ]);
        return view();
    }

}
