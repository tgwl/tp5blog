<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    // 重复登录过滤 如果sessin中存在id那么直接跳转到主页
    public function initialize()
    {
        if (session('?admin.id')) {
            $this->redirect('admin/home/index');
        }
    }
    // 后台登录
    public function login()
    {
        // 如果请求是ajax请求
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];
            // model() 可以直接找common下的模型
            $result = model('Admin')->login($data);
            // 如果模型返回的数据为1 那么登录成功
            if ($result == 1) {
                //    success 为系统内置
                $this->success("登陆成功", 'admin/home/index');
            } else {
                // errer 也为系统内置composer require phpmailer/phpmailer
                $this->error($result);
            }
        }
        // 对应 view下index/login
        return view();
    }

    // 注册
    public function register()
    {
        // 如果请求是ajax请求
        if (request()->isAjax()) {
            // 获取从表单传来的数据
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                // 确认密码
                "conpass" => input('post.conpass'),
                "nickname" => input('post.nickname'),
                'email' => input('post.email')
            ];
            $result = model('Admin')->register($data);
            // 返回1代表注册成功
            if ($result == 1) {
                $this->success('注册成功', 'admin/index/login');
            } else {
                $this->error($result);
            }
        }

        // 对应 view下index/register
        return view();
    }


    // 忘记密码 发送验证码
    public function forget()
    {
        if (request()->isAjax()) {
            // 生成验证码
            $code = mt_rand(1000, 9000);
            session('code', $code);
            $data = [
                'email' => input('post.email')
            ];

            $result =  mailto(input('post.email'), '重置密码验证', "您的重置密码验证码是:" . $code);
            if ($result) {
                $this->success('验证码发送成功');
            } else {
                $this->error('验证码发送失败');
            }
        }
        // 默认返回html视图
        return view();
    }

    // 忘记密码 重置密码
    public function reset()
    {
        $data = [
            'code' => input('post.code'),
            'email'=>input('post.email')
        ];
        $result = model('Admin')->reset($data);
        if ($result == 1) {
            $this->success('密码重置成功，请去邮箱查看新密码', 'admin/index/login');
        } else {
            $this->error($result);
        }
    }
}
