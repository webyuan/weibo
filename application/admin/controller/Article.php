<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/9
 * Time: 15:15
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
class Article extends Controller
{
    function add(){
        if (request()->isPost()){
            $article=new ArticleModel();
            //dump(input('post.'));exit();
            $res=$article->save(input('post.'));
            if (!$res){
                $this->error('文章添加失败');
            }
            $this->success('文章添加成功');
        }
        $cate=new CateModel();
        $data=$cate->getCateTree();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //列表展示
    function lst(){
        $data=db('article')
            ->alias('a')
            ->field('a.*,b.cname')
            ->join('bk_cate b','a.cateid=b.id')
            ->order('a.id desc')
            ->paginate(2);
        $this->assign('data',$data);
        return $this->fetch();
    }

    //编辑
    function edit(){
        $article=new ArticleModel();
        if (request()->isPost()){
            //接受修改的数据
            $res=$article->edit(input('post.'));
            if (!$res){
                $this->error('参数错误');
            }
            $this->success('修改成功',url('lst'));

        }
        //树形结构
        $cate=new CateModel();
        $data=$cate->getCateTree();
        $this->assign('data',$data);
        //要修改的数据
        $info=$article->getOne(input('param.id'));
        $info['content']=htmlspecialchars_decode($info['content']);
        $this->assign('info',$info);
        return $this->fetch();
    }
    //删除
    function dels(){
        if (request()->isGet()){
            $article=new ArticleModel();
            $res=$article->dels(input('param.id'));
            if (!$res){
                $this->error('文章删除失败');
            }
            $this->success('文章删除成功');
        }
    }
}