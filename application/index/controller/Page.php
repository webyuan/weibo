<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/7
 * Time: 16:04
 */

namespace app\index\controller;


class Page extends Common
{
    public function index()
    {
        $cateid=input('cate_id');
        $data=db('cate')->where('id='.$cateid)->find();
        $this->assign('data',$data);
        return view();
    }
}