<?php

namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    // 公共模板变量赋值 如果需要在控制器之外进行模板变量赋值，可以使用视图类的share静态方法进行全局公共模板变量赋值
    public function initialize()
    {
        $cates = model('cate')->order('sort', 'desc')->select(); //栏目信息
        $webinfo = model('system')->find();  //网站信息
        $topArticles =model('article')->where('is_top',1)->order('create_time','desc')->limit(10)->select(); //推荐文章 当is_top为1 并且限制只显示10篇
        $viewDate = [
            'cates' => $cates,
            'webInfo' => $webinfo,
            'topArticle'=>$topArticles
        ];
        $this->view->share($viewDate);
        // 全局静态模板变量最终会和前面使用方法赋值的模板变量合并
    }
}
