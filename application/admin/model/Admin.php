<?php
/**
 * Created by PhpStorm.
 * User: qzy
 * Date: 2018/11/7
 * Time: 20:49
 */

namespace app\admin\model;


use think\Model;

class Admin extends Model
{   //添加用户
    function addadmin($data){
        $info['password']=md5($data['password']);
        $info['name']=$data['name'];
        $uid= $this->save($info);
        if ($uid){
            $map=[
              'uid'=>$this->id,
              'group_id'=>$data['group_id']
            ];
            db('auth_group_access')->insert($map);
        }
        return $uid;

    }
    //编辑用户
    function edit($data){
        $info=$this->where('id='.$data['id'])->find();
        $map=[
            'id'=>$data['id'],
            'name'=>$data['name'],
            'password'=>$data['password']?md5($data['password']):$info['password']
        ];
        db('auth_group_access')->where('uid='.$info['id'])->update(['group_id'=>$data['group_id']]);
        return $this->update($map);
    }

    //删除用户
    function dels($id){
        return $this->where('id='.$id)->delete();
    }

    //用户登陆
    function login($data){
        $map=$data['name'];
        $user=$this->field('id,name,password')->where("name='$map'")->find();
        if ($user['password']!=md5($data['password'])){
            return false;
        }
        session('admin_id',$user['id']);
        session('admin_user',$user['name']);
        return true;
    }
}