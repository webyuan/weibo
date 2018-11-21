<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/12
 * Time: 21:05
 */

namespace app\admin\model;


use think\Model;

class AuthRule extends Model
{
    //获取分类信息
    function getTree(){
        //获取分类
        $list= $this->select();
        //格式化 数据
        $list=$this->fromat($list);
        return $list;
    }
    //格式化分类信息增加lev
    function fromat($data,$id=0){
        static $list=array();
        foreach ($data as $key => $value) {
            if ($value['pid']==$id) {
                $value['dataid']=$this->getparentid($value['id']);
                $list[]=$value;
                //使用递归找出子分类
                $this->fromat($data,$value['id']);
            }
        }
        return $list;
    }

    public function getparentid($authRuleId){
        $AuthRuleRes=$this->select();
        return $this->_getparentid($AuthRuleRes,$authRuleId,True);
    }

    public function _getparentid($AuthRuleRes,$authRuleId,$clear=False){
        static $arr=array();
        if($clear){
            $arr=array();
        }
        foreach ($AuthRuleRes as $k => $v) {
            if($v['id'] == $authRuleId){
                $arr[]=$v['id'];
                $this->_getparentid($AuthRuleRes,$v['pid'],False);
            }
        }
        asort($arr);
        $arrStr=implode('-', $arr);
        return $arrStr;
    }
    //编辑时得到一条数据
    function getOne($id){
        return $this->where('id='.$id)->find();
    }
    //栏目删除
    function dels($id){
        //如果找到了一条数据的pid等于了他的id那么说明他有 子分类则不能删除
        $result=$this->where('pid='.$id)->find();
        if ($result){
            return false;
        }else{
            return $this->where('id='.$id)->delete();
        }
    }
}