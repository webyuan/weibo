<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/7
 * Time: 11:22
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
class Admin extends Controller
{
    //列表模板
    function lst(){
        $admin=new \app\admin\model\Admin();
        //获取用户数据
        $data=$admin->select();
        $this->assign('data',$data);
        //分页显示
        $list=$admin->paginate(10);
        $page=$list->render();
        $this->assign('page',$page);
        return $this->fetch();
    }

    //添加模板
    function add(){
        if (Request::instance()->isPost()){
            $data=input('post.');
            //dump($data);exit();
            $admin=new \app\admin\model\Admin();
            $res=$admin->addadmin($data);
            if (!$res){
                $this->error('添加失败');
            }
            $this->success('添加成功',url('lst'));
        }
        $info=db('auth_group')->select();
        $this->assign('info',$info);
        return  view();
    }

    //编辑模板
    function edit(){
        $admin=new \app\admin\model\Admin();
        if (request()->isPost()){
            $res=$admin->edit(input('post.'));
            if (!$res){
                $this->error('参数错误');
            }
            $this->success('修改成功',url('lst'));
        }
        $admin_id=input('param.id');
        $user=$admin->where('id='.$admin_id)->find();
        //获取权限id
        $group=db('auth_group_access')->where('uid='.$admin_id)->find();
        $this->assign('group',$group);
        $this->assign('user',$user);
        //选择权限下拉列表
        $info=db('auth_group')->select();
        $this->assign('info',$info);
        return view();
    }

    //删除一条数据
    function dels(){
        if (request()->isGet()){
            $admin=new \app\admin\model\Admin();
            $res=$admin->dels(input('param.id'));
            if (!$res){
                $this->error('删除失败');
            }
            $this->success('删除成功',url('lst'));
        }
    }

    //用户登陆
    function login(){
        if (\request()->isPost()){
            $admin=new \app\admin\model\Admin();
            $this->check(input('post.captcha'));
            $validate=\think\Loader::validate('Login');
            $data=input('post.');
            if(!$validate->scene('Login.login')->check($data)){
                $this->error($validate->getError());
            }
            $res=$admin->login(input('post.'));
            if (!$res){
                $this->error('用户名或密码错误');
            }
            $this->success('登陆成功',url('lst'));
        }
    }
    //检测验证码
    function check($code=''){
        if (!captcha_check($code)){
            $this->error('验证码错误');
        }
        return true;
    }
}