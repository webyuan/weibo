<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/11
 * Time: 18:39
 */

namespace app\admin\validate;


use think\Validate;

class Login extends Validate
{
    protected $rule=[
        'name'=>'require|max:20|min:2',
        'password'=>'require|min:6|max:30',
        'captcha'=>'require'
    ];
    protected $message=[
        'name.require'=>'用户名必须填写',
        'name.min'=>'用户名不得小于2位',
        'name.max'=>'用户名不得大于20位',
        'password.require'=>'密码不得为空',
        'password.min'=>'密码不得小于6位',
        'password.max'=>'密码不得大于30位',
        'captcha'=>'验证码不得为空'
    ];
    protected $scene=[
        'login'=>['name','password'],
    ];
}