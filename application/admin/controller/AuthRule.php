<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/12
 * Time: 20:30
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\AuthRule as AuthRuleModel;
class AuthRule extends Controller
{
    function add(){
        if (request()->isPost()){
             //dump(input('post.'));exit();
             $data=input('post.');
             //找到父类的等级
            $prev_data=db('auth_rule')->where('id',$data['pid'])->field('lev')->find();
             if (empty($data['pid'])){
                 $data['lev']=0;
             }else{
                $data['lev']=$prev_data['lev']+1;
             }
            $res=AuthRuleModel::create($data);
            if (!$res){
                $this->error('添加失败');
            }
            $this->success('添加成功');
        }
        $info=AuthRuleModel::select();
        $this->assign('info',$info);

        return $this->fetch();
    }

    function lst(){
        $auth=new AuthRuleModel();
        $data=$auth->getTree();
        //dump($data);exit();
        $this->assign('data',$data);
        return $this->fetch();
    }

    function edit(){
        $auth=new AuthRuleModel();
        if (request()->isPost()){
            $data=input('post.');
            $plevel=db('auth_rule')->where('id',$data['pid'])->field('lev')->find();
            if($plevel){
                $data['lev']=$plevel['lev']+1;
            }else{
                $data['lev']=0;
            }
            $res=db('AuthRule')->update($data);
            if (!$res){
                $this->error('修改失败');
            }
            $this->success('修改成功',url('lst'));
        }
        $data=$auth->getTree();
        //dump($data);exit();
        $this->assign('data',$data);
        //找到当前数据
        $info=$auth->getOne(input('param.id'));
        $this->assign('info',$info);
        return $this->fetch();
    }

    //删除
    function dels(){
        if (request()->isGet()){
            $auth=new AuthRuleModel();
            $res=$auth->dels(input('param.id'));
            if (!$res){
                $this->error('删除失败');
            }
            $this->success('删除成功');
        }
    }

}