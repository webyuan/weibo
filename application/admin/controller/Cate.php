<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/8
 * Time: 18:58
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Cate as CateModel;
class Cate extends Controller
{   //添加栏目
    function add(){
        if (request()->isPost()){
            //dump(input('post.'));exit;
            $res=CateModel::create(input('post.'));
            if (!$res){
                $this->error('添加失败');
            }
            $this->success('添加成功');
        }
        $cate=new CateModel();
        $data=$cate->getCateTree();
        $this->assign('data',$data);
        return $this->fetch();
    }

    //显示栏目列表
    function lst(){
        $cate=new CateModel();
        $data=$cate->getCateTree();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //栏目编辑
    function edit(){
        $cate=new CateModel();
        if (request()->isGet()){
            //等到树形结构
            $data=$cate->getCateTree();
            $this->assign('data',$data);
            //找到当前数据
            $info=$cate->getOne(input('param.id'));
            $this->assign('info',$info);
            return $this->fetch();
        }else{
            $res=$cate->edit(input('post.'));
            if (!$res){
                $this->error('修改失败');
            }
            $this->success('修改成功',url('lst'));
        }
    }


    //删除栏目
    function dels(){
        if (request()->isGet()){
            $cate=new CateModel();
            $res=$cate->dels(input('param.id'));
            if (!$res){
                $this->error('删除失败');
            }
            $this->success('删除成功');
        }
    }
}