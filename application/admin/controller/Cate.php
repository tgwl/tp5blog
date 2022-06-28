<?php

namespace app\admin\controller;

use think\Controller;

class Cate extends Base
{
    //栏目列表
    public function list()
    {
        $cates = model('Cate')->order('sort', 'asc')->paginate(10);
        // 定义一个模板数据变量
        $viewDate = [
            'cates' => $cates
        ];
        $this->assign($viewDate);
        return view();
    }

    // 栏目添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'catename' => input('post.catename'),
                'sort' => input('post.sort')
            ];
            $result = model('Cate')->add($data);
            if ($result == 1) {
                $this->success('添加成功', 'admin/cate/list');
            } else {
                $this->error($result);
            }
        }

        return view();
    }

    // 排序
    public function sort()
    {
        $data = [
            'id' => input('post.id'),
            'sort' => input('post.sort'),
        ];
        $result = model('cate')->sort($data);
        if ($result == 1) {
            $this->success('排序成功', 'admin/cate/list');
        } else {
            $this->error($result);
        }
    }

    // 编辑
    public function edit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'catename' => input('post.catename')
            ];
            $result = model('cate')->edit($data);
            if ($result == 1) {
                $this->success('栏目编辑成功', 'admin/cate/list');
            } else {
                $this->error($result);
            }
        }

        $cateInfo = model("cate")->find(input('id'));
        // 模板变量
        $viewData = [
            'cateInfo' => $cateInfo
        ];
        $this->assign($viewData);
        return view();
    }

    // 栏目删除
    public function del()
    {
  // 关联文章article表和文章表关联的子评论表（嵌套预载入） 因为article model里面有comments方法关联了评论表
        $cateInfo = model('Cate')->with('article,article.comments')->find(input('post.id'));
        // 循环当前栏目的所有文章 k为键 v为值 此处的v就相当于一条一条的文章表article的条目数据
        foreach ($cateInfo['article'] as $k => $v) {
  // 因为文章表article有comments方法且关联了comemnts评论表，所以可以这样将一条文章下的所有评论删除
            $v->together('comments')->delete();
        }
        // 删除关联栏目的文章表
        $result = $cateInfo->together('article')->delete();
        if ($result) {
            $this->success('栏目删除成功！', 'admin/cate/list');
        } else {
            $this->error('栏目删除失败！');
        }
    }
}
