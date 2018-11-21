<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/7
 * Time: 13:43
 */

namespace app\index\controller;

use app\index\model\Article as Art;


class Artlist extends Common
{
    public function index(){
        $article=new Art();
        $data=$article->getArticle(input('cate_id'));
        $this->assign('data',$data);
        //s

        return view();
    }
}