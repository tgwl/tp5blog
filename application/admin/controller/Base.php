<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    // 如果不存在session那么回到登录页面
    public function initialize()
    {
        if (!session('?admin.id')) {
            $this->redirect('admin/index/login');
        }
    }


}
