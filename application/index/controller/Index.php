<?php

namespace app\index\controller;

use think\Controller;

class Index extends Base
{
    // 首页
    public function index()
    {
        // 此处定义空数组是为了如果没有传进来id 下面查询的时候不报错
        $where = [];
        $catename = null;
        // 如果传参有id 那么就是点击到了栏目
        if (input('?id')) {
            $where = [
                'cate_id' => input('id')
            ];
            // 查询栏目的名称 value只填catename就可以直接获取指定字段
            $catename = model('cate')->where('id', input('id'))->value('catename');
        }
        $articles = model('article')->where($where)->order('create_time', 'desc')->paginate(10);
        $viewData = [
            'articles' => $articles,
            'catename' => $catename
        ];
        $this->assign($viewData);
        return view();
    }

    public function register()
    { //注册功能
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
                'verify' => input('post.verify')
            ];
            $result = model('member')->register($data);
            if ($result == 1) {
                $this->success('注册成功', 'index/index/login');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    public function login()
    { //用户登录功能
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'verify' => input('post.verify')
            ];
            $result = model('member')->login($data);
            if ($result == 1) {
                $this->success('登录成功', 'index/index/index');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    public function loginout()
    { //退出登录
        $result = session(null);
        if(session('?index.id')){ //判断session中是否还有index键id值
            $this->error('退出失败');
        }else{
            $this->success('退出成功','index/index/index');
        }
    }

    public function search(){ //搜索  搜索使用的是action直接提交 所以路由后面不用定义类似id一样的值 因为keyword直接传进来
        $where[]=['title','like','%'.input('keyword').'%']; //定义模糊搜索
        $catename = input('keyword');
        $articles = model('article')->where($where)->order('create_time','desc')->paginate(10);
        $viewData = [
           'articles' =>$articles,
           'catename'=>$catename
        ];  //因为index里面已经循环了 articles数组 所以会显示我们搜索的文章 
        $this->assign($viewData);
        return view('index');
    }
}
