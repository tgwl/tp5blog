<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 前台路由
// thinkphp的路由匹配是从上往下的 匹配到了则不继续匹配
 Route::rule('cate/:id', 'index/index/index', 'get');
  // 首页
 Route::rule('/', 'index/index/index', 'get');
//  文章详情页
 Route::rule('article-<id>', 'index/article/info', 'get');
//  注册功能
Route::rule('register', 'index/index/register', 'get|post');
// 登录功能
Route::rule('login', 'index/index/login', 'get|post');
// 退出功能
Route::rule('loginout', 'index/index/loginout', 'post');
// 搜索功能
Route::rule('search', 'index/index/search', 'get');
// 文章评论
Route::rule('comment', 'index/article/comm', 'post');
// 文章投稿
Route::rule('post', 'index/article/post', 'get|post');

// 后台路由
Route::group('admin', function () {
    Route::rule('/', 'admin/index/login', 'get|post');
    Route::rule('register', 'admin/index/register', 'get|post');
    Route::rule('forget', 'admin/index/forget', 'get|post');
    Route::rule('reset', 'admin/index/reset', 'get|post');
    Route::rule('index', 'admin/home/index', 'get');
    Route::rule('loginout', 'admin/home/loginout', 'post');
    Route::rule('catelist', 'admin/cate/list', 'get');
    Route::rule('cateadd', 'admin/cate/add', 'get|post');
    // 栏目排序
    Route::rule('catesort', 'admin/cate/sort', 'post');
    // 栏目编辑  id为可选参数
    Route::rule('cateedit/[:id]', 'admin/cate/edit', 'get|post');
    // 栏目删除
    Route::rule('cateedit', 'admin/cate/del', 'post');
    // 文章列表
    Route::rule('articlelist', 'admin/article/list', 'post|get');
    // 文章添加
    Route::rule('articleadd', 'admin/article/add', 'post|get');
    // 取消或者添加推荐
    Route::rule('articletop', 'admin/article/top', 'post');
    //  文章编辑
    Route::rule('articleedit/[:id]', 'admin/article/edit', 'get|post');
    // 文章删除
    Route::rule('articledel', 'admin/article/del', 'post');
    // 会员列表
    Route::rule('memberlist', 'admin/member/all', 'get');
    // 添加会员
    Route::rule('memberadd', 'admin/member/add', 'get|post');
    // 编辑会员操作
    Route::rule('memberedit/[:id]', 'admin/member/edit', 'get|post');
    // 删除会员`
    Route::rule('memberdel', 'admin/member/del', 'post');
    // 管理员列表
    Route::rule('adminlist', 'admin/admin/all', 'get');
    // 管理员添加
    Route::rule('adminadd', 'admin/admin/add', 'get|post');
    // 操作管理员状态
    Route::rule('adminstatus', 'admin/admin/status', 'post');
    // 编辑管理员
    Route::rule('adminedit/[:id]', 'admin/admin/edit', 'get|post');
    // 删除管理员
    Route::rule('admindel', 'admin/admin/del', 'post');
    // 评论列表
    Route::rule('comment', 'admin/comment/all', 'get');
    // 删除评论 
    Route::rule('commentdel', 'admin/comment/del', 'post');
    // 设置
    Route::rule('set', 'admin/system/set', 'get|post');
   
});
