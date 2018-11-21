<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/10
 * Time: 17:11
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\Conf as ConfModel;
class Conf extends Controller
{
    function add(){
        if (request()->isPost()){
            //dump(input('post.'));exit;
            $data=input('post.');
            if ($data['values']){
                $data['values']=str_replace('，',',',$data['values']);
            }
            $res=db('Conf')->insert($data);
            if (!$res){
                $this->error('添加失败');
            }
            $this->success('添加成功');
        }
        return $this->fetch();
    }
    //显示列表
    function lst(){
        $data=db('Conf')->paginate(2);
        $this->assign('data',$data);
        return $this->fetch();
    }
    //显示配置项
    function conf(){
        if (request()->isPost()){
            dump(input('post.'));exit;
        }
        $data=db('Conf')->select();
        //格式化数据
        foreach ($data as $key => $value){
            if ($value['values']){
                $data[$key]['values']=explode(',',$value['values']);
            }
        }
        //dump($data);exit;
        $this->assign('data',$data);
        return $this->fetch();
    }
}