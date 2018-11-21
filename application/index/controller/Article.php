<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/7
 * Time: 11:22
 */

namespace app\index\controller;

use \app\index\model\Article as Art;
use app\index\model\Cate as Cate;

class Article extends Common
{
    //列表模板
    function index(){
        $art=new Art();
        //获取当前文章的分类信息
        $art_id=input('art_id');
        //赞加一
        $art->where('id='.$art_id)->setInc('click');
        //获取一条文章信息
        $data=$art->getOneArt($art_id);
        //获取热点文章信息
        $hot=$art->getHotArt();
        $this->assign([
            'data'=>$data,
            'hot'=>$hot
        ]);
        return view();
    }


}