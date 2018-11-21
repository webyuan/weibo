<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/12
 * Time: 17:01
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\AuthGroup as AuthGroupModel;
class AuthGroup extends Controller
{
    function add(){
        if (request()->isPost()){

            $data=input('post.');
            $data['rules']=implode(',',$data['rules']);
            //dump($data);exit();
            $res=AuthGroupModel::create($data);
            if (!$res){
                $this->error('添加失败');
            }
            $this->success('添加成功');
        }
        $authRule=new \app\admin\model\AuthRule();
        $authRuleRes=$authRule->getTree();
        $this->assign('data',$authRuleRes);
        return $this->fetch();
    }

    function lst(){
        $data=AuthGroupModel::select();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //删除栏目
    function dels(){
        if (request()->isGet()){
            $res=db('AuthGroup')->delete(input('param.id'));
            if (!$res){
                $this->error('删除失败');
            }
            $this->success('删除成功');
        }
    }

    //栏目编辑
    function edit(){
        $AuthGroup=new AuthGroupModel();
        if (request()->isGet()){
            //找到当前数据
            $info=$AuthGroup->getOne(input('param.id'));

            $info['rules']=explode(',',$info['rules']);
            //dump($info);exit;
            $this->assign('info',$info);
            $authRule=new \app\admin\model\AuthRule();
            $authRuleRes=$authRule->getTree();
            $this->assign('data',$authRuleRes);
            return $this->fetch();
        }else{
            $data=input('post.');
            $data['rules']=implode(',',$data['rules']);
            //dump($data);exit();
            if (!isset($data['status'])){
                $data['status']=0;
            }else{
                $data['status']=1;
            }
            $res=db('AuthGroup')->update($data);
            if (!$res){
                $this->error('修改失败');
            }
            $this->success('修改成功',url('lst'));
        }
    }

}