<?php

namespace app\common\validate;

use think\Validate;

class Admin extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username|管理员账户' => 'require',
        'password|密码' => 'require',
        'oldpass|原密码'=>'require',
        'newpass|新密码'=>'require|different:oldpass', //判断与oldpass是否相同 如果相同报错
        'conpass|确认密码' => 'require|confirm:password',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email|unique:admin',
        'code|验证码' => 'require'
    ];

    // 调用的时候传login就可以验证
    public function sceneLogin()
    {
        return $this->only(['username', 'password']);
    }

    //注册场景验证
    public function sceneRegister()
    {
        return $this->only(['username', 'password', 'conpass', 'nickname', 'email'])
            ->append('username', 'unique:admin');
        //   表示验证username字段的值是否在admin表（不包含前缀）中唯一
    }

    //    重置密码验证场景
    public function sceneReset(){
        return $this->only(['code']);
    }

    // 添加管理员场景
    public function sceneAdd(){
            return $this->only(['username','password','conpass','nickname','email'])->append('username','unique:admin');
    }

    // 编辑管理员场景
    public function sceneEdit(){
        return $this->only(['oldpass','newpass','nickname']);
    }
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];
}
