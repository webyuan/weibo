<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/10
 * Time: 1:55
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\Link as LinkModel;

class Link extends Controller
{
    function add(){
        if (request()->isPost()){
            $link=new LinkModel();
            $res=$link->save(input('post.'));
            if (!$res){
                $this->error('新增失败');
            }
            $this->success('新增成功');
        }

        return $this->fetch();
    }

    //显示列表
    //显示栏目列表
    function lst(){
        $data=db('link')->paginate(2);
        $this->assign('data',$data);
        return $this->fetch();
    }

    //编辑
    function edit(){
        $link=new LinkModel();
        if (request()->isPost()){
            //接受修改的数据
            $res=$link->edit(input('post.'));
            if (!$res){
                $this->error('参数错误');
            }
            $this->success('修改成功',url('lst'));

        }
        //要修改的数据
        $info=$link->getOne(input('param.id'));
        $this->assign('info',$info);
        return $this->fetch();
    }

    //删除栏目
    function dels(){
        if (request()->isGet()){
            $link=new LinkModel();
            $res=$link->dels(input('param.id'));
            if (!$res){
                $this->error('删除失败');
            }
            $this->success('删除成功');
        }
    }





}