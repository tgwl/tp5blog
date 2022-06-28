<?php

namespace app\admin\controller;

use think\Controller;
use think\Paginator;

class Article extends Base
{
    // 文章列表
    public function list()
    {
        // 注意这里is-top 降序 在数据表enum枚举值设置中应 '0','1' with是因为我们在article model里面定义了cate方法关联了cate表
        $article  = model('Article')->with('cate')->order(['is_top' => 'desc', 'create_time' => 'desc'])->paginate(10);
        $viewData = [
            'articles' => $article
        ];
        $this->assign($viewData);
        return view();
    }

    // 文章添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'title' => input('post.title'),
                'desc' => input('post.desc'),
                'tags' => input('post.tags'),
                // 有值是他本身 否则为0
                'is_top' => input('post.is_top', 0),
                'cate_id' => input('post.cate_id'),
                'content' => input('post.content')
            ];
            $result = model('Article')->add($data);
            if ($result == 1) {
                return $this->success('添加成功', 'admin/article/list');
            } else {
                return $this->error($result);
            }
        }
        $cates = model('Cate')->select();
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    // 推荐操作
    public function top()
    {
        $data = [
            // 这里相当于给他反转了  如果没有推荐传过来的就是0 而0正好是false所以会变成1
            'is_top' => input('post.is_top') ? 0 : 1,
            'id' => input('post.id')
        ];
        $result = model('article')->top($data);

        if ($result == 1) {
            $this->success('操作成功', 'admin/article/list');
        } else {
            $this->error($result);
        }
    }

    // 编辑操作
    public function edit()
    {
        if (request()->isAjax()) {
            $data = [
                'title' => input('post.title'),
                'content' => input('post.content'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top',0),
                'cate_id' => input('post.cate_id'),
                'id'=>input('post.id'),
                'desc'=>input('post.desc')
            ];
            $result = model('article')->edit($data);
            if($result == 1){
                $this->success('文章修改成功','admin/article/list');
            }else{
                $this->error($result);
            }
        }

        $articleInfo  = model('article')->find(input('id'));
        $cates = model('cate')->select();
        $viewData = [
            'articleInfo' => $articleInfo,
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    // 文章删除
    public function del(){
        // 连同评论表的数据一并删除
        $articleInfo = model('article')->with('comments')->find(input('id'));
        $result  = $articleInfo->together('comments')->delete();
        if($result){
            $this->success('文章删除成功','admin/article/list');
        }else{
            $this->error('文章删除失败');
        }
    }
}
