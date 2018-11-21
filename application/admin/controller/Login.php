<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/8
 * Time: 14:46
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Controller
{   //显示登陆页面
    function index(){
        return $this->fetch();
    }

    //登出操作
    function logout(){
        session(null);
        $this->success('退出成功',url('admin/login/index'));
    }
}