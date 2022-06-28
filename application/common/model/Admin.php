<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;
    protected $readonly =['email'];  //只读字段

    // 登录校验
    public function login($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if ($result) {
            if ($result['status'] != 1) {
                // 如果status不等于1 就是被禁用
                return "此账户被禁用";
            }
            // 1表示数据库中有这个用户名和密码且不被禁用
            $sessionData = [
                'id' => $result['id'],
                'nickname' => $result['nickname'],
                'is_super' => $result['is_super']
            ];
            session('admin', $sessionData);
            return 1;
        } else {
            return '用户名密码错误';
        }
    }


    // 注册
    public function register($data){
        $validate = new \app\common\validate\Admin();
        // 验证不通过
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        // 删除某个元素
        // unset($data['conpass']);
        //   allwField如果为true那么只新增数据库的字段 这里我们多了一个conpass字段而数据库字段里没有 要么删除,要么使用该方法
        $result = $this->allowField(true)->save($data);
        // 如果操作成功
        if ($result) {
            // 发送邮箱
            mailto($data['email'], '注册管理员账户成功！', '注册管理员账户成功！');
            return 1;
        } else {
            return "注册失败";
        }
    }

    // 重置密码
    public function reset($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('reset')->check($data)) {
            return $validate->getError();
        }
        if ($data['code'] != session('code')) {
            return "验证码不正确！";
        }
        $adminInfo = $this->where('email', $data['email'])->find();
        $password = mt_rand(10000,99999);
        $adminInfo->password = $password;
        $result = $adminInfo->save();
        if ($result) {
            $content = '恭喜您，密码重置成功！<br>用户名：' . $adminInfo['username'] . '<br>新密码：'
                . $password;
            mailto($data['email'], '密码重置成功', $content);
            return 1;
        }else {
            return '重置密码失败！';
        }
    }

    public function add($data){    //管理员添加方法
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }else{
            $result = $this->allowField(true)->save($data);
            if($result){
                return 1;
            }else{
                return '管理员添加失败';
            }
        }
    }

    public function edit($data){//管理员修改方法
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }else{
            $adminInfo =$this->find($data['id']);
            if($data['oldpass']!= $adminInfo['password']){//判断原密码是否与数据库密码一致
                return  '原密码不正确';
            }
            // if($data['newpass'] == $adminInfo['password']){ //判断数据库原密码是否与新密码是否一致 
            //     return '新密码不能与原密码一致';
            // }
            $adminInfo->password= $data['newpass'];
            $adminInfo->nikname = $data['nickname'];
            $result = $adminInfo->save();
            if($result){
                return 1;
            }else{
                return "管理员修改失败";
            }
        }
    }
}
