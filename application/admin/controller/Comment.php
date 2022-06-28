<?php

namespace app\admin\controller;

use think\Controller;

class Comment extends Base
{
    public function all()
    {  //评论列表                   因为我们在comemnt model关联了文章表和用户表所以这里关联预载入
        $comments = model('Comment')->with('article,member')->order('create_time', 'desc')->paginate(10);
        $viewData = [
            'comments' => $comments
        ];
        $this->assign($viewData);
        return view();
    }

    public function del()
    { //删除评论
        $commentInfo = model('comment')->find(input('id'));
        $result = $commentInfo->delete();
        if ($result) {
            $this->success('删除评论成功', 'admin/comment/all');
        } else {
            $this->error('删除评论失败');
        }
    }
}
