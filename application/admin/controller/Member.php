<?php

namespace app\admin\controller;

use think\Controller;

class Member extends Base
{
    // 会员列表
    public function all()
    {
        $members = model('member')->order('create_time','desc')->paginate(10);
        $viewData=[
            'members'=>$members,
        ];
        $this->assign($viewData);
        return view();
    }

    // 会员添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            $result = model('Member')->add($data);
            if ($result == 1) {
                $this->success('会员添加成功！', 'admin/member/all');
            }else {
                $this->error($result);
            }
        }
        return view();
    }

    // 会员编辑
    public function edit()
    {
        if(request()->isAjax()){
            $data=[
                'id'=>input('post.id'),
                'oldpass'=>input('post.oldpass'),
                'newpass'=>input('post.newpass'),
                'nickname'=>input('post.nickname'),
            ];
            $result = model('member')->edit($data);
            if($result == 1){
                $this->success('会员修改成功','admin/member/all');
            }else{
                $this->error($result);
            }
        }
        $memberInfo = model('member')->find(input('id'));
        $viewData=[
            'memberInfo'=>$memberInfo,
        ];
        $this->assign($viewData);
        return view();
    }

    // 会员删除 
    public function del(){
        // 这里关联预载入的是评论表 为了达到删除用户连他下面的评论都删掉的功能
        $memberInfo = model('member')->with('comments')->find(input('id'));
        // 连同评论表的数据一并删除 
        $result  =$memberInfo->together('comments')->delete();
        if($result){
            $this->success('会员删除成功','admin/member/all');
        }else{
            $this->error('会员删除失败');
        }
    }
}
