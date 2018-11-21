<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/7
 * Time: 16:04
 */

namespace app\index\controller;

use app\index\model\Article as Art;
class Imglist extends Common
{

    public function index()
    {
        $article=new Art();
        $data=$article->getArticle(input('cate_id'));
        $this->assign('data',$data);
        return view();
    }
}