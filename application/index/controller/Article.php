<?php

namespace app\index\controller;

use think\Controller;

class Article extends Base
{
    public function info()
    { //文章详情页                       关联预载入  { comemnts.member}嵌套预载入因为comemnt模型里面有member方法关联member用户表
        $articleInfo = model('article')->with('comments,comments.member')->find(input('id'));
        //    每次访问后info页面 数据库click字段自增1 达到点击数增加的效果
        $articleInfo->setInc('click', 1);
        $top_article=model('article')->where('is_top',1)->select();
        $viewData = [
            'articleInfo' => $articleInfo,
            'top_article'=>$top_article
        ];
        $this->assign($viewData);
        return view();
    }

    public function comm()
    { //文章评论
        $data = [
            'article_id'=>input('post.article_id'),
            'member_id'=>input('post.member_id'),
            'content'=>input('post.content')
        ];
        $result = model('comment')->comm($data);
        if($result ==1){
        $this->success('评论成功');
        }else{
            $this->error($result);
        }
    }

    public function post(){ //投稿功能
        if(request()->isAjax()){
            $data = [
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'cate_id' => input('post.cateid'),
                'desc' => input('post.desc'),
                'content' => input('post.content'),
                'author' => input('post.author')
            ];
            $result = model('Article')->post($data);
            if ($result == 1) {
                $this->success('投稿成功！', 'index/index/index');
            }else {
                $this->error($result);
            }
        }

        // 取出栏目字段
        $cates = model('cate')->select();
        $viewData = [
            'cates'=>$cates
        ];
        $this->assign($viewData);
        return view();
    }
}
