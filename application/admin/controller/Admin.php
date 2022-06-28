<?php

namespace app\admin\controller;

use Symfony\Component\VarDumper\Cloner\Data;
use think\Controller;

class Admin extends Base
{
    //管理员列表
    public function all()
    {
        // status 为枚举类型 0 1  需要修改顺序才可以达到倒叙效果
        $admins = model('admin')->order(['is_super' => 'desc', 'status' => 'desc'])->paginate(10);
        $viewData = [
            'admins' => $admins
        ];
        $this->assign($viewData);
        return view();
    }

    public function add()
    {  //管理员添加
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
            ];
            $result = model('admin')->add($data);
            if ($result == 1) {
                $this->success('管理员添加成功', 'admin/admin/all');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    public function status()
    { //管理员状态操作
        $data = [
            'id' => input('post.id'),
            'status' => input('status') ? 0 : 1   //这里我们进行状态取反 如果传来的是0 则为false 就会变成1 反之亦然   
        ];
        $adminInfo = model('admin')->find($data['id']);
        $adminInfo->status = $data['status'];
        $result = $adminInfo->save();
        if ($result) {
            $this->success('操作成功', 'admin/admin/all');
        } else {
            $this->error('操作失败');
        }
    }

    public function edit()
    { //编辑管理员方法
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'newpass' => input('post.newpass'),
                'oldpass' => input('post.oldpass'),
                'nickname' => input('post.nickname')
            ];
            $result = model('admin')->edit($data);
            if ($result == 1) {
                return $this->success('管理员修改成功', 'admin/admin/all');
            } else {
                return $this->error($result);
            }
        }
        $adminInfo = model('admin')->find(input('id')); //查询数据
        $viewData = [
            'adminInfo' => $adminInfo
        ];
        $this->assign($viewData);
        return view();
    }

    public function del()
    {  // 删除管理员操作
        $adminInfo = model('admin')->find(input('id'));
        $result = $adminInfo->delete();
        if ($result) {
            $this->success('删除管理员成功', 'admin/admin/all');
        } else {
            $this->error('删除管理员失败');
        }
    }
}
