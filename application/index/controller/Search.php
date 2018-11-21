<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/16
 * Time: 0:06
 */

namespace app\index\controller;



class Search extends Common
{
    function index(){
        if (request()->isGet()){
            $keywords=input('keywords');
            $data=db('article')->where('title','like',"%$keywords%")->paginate(2);
            $this->assign('data',$data);

            return $this->fetch();
        }

    }
}