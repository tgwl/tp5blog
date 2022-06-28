<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    // 软删除
    use SoftDelete;
    // 只读字段 即不允许修改的字段
    protected $readonly = ['username', 'email'];

    public function comments()
    {  //关联评论 一对多 
        return $this->hasMany('comment', 'member_id', 'id');
    }
    //会员添加
    public function add($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '会员添加失败！';
        }
    }

    // 会员修改
    public function edit($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        } else {
            // 先查询后修改
            $memberInfo = $this->find($data['id']);
            // 查询传入的密码是否跟数据库里的密码一致
            if ($data['oldpass'] != $memberInfo['password']) {
                return '原密码不正确';
            }
            $memberInfo->password = $data['newpass'];
            $memberInfo->nickname = $data['nickname'];
            $result = $memberInfo->save();
            if ($result) {
                return 1;
            } else {
                return '会员修改失败';
            }
        }
    }

    // 用户注册功能
    public function register($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        } else {
            $result = $this->allowField(true)->save($data);
            if ($result) {
                return 1;
            } else {
                return  '用户注册失败';
            }
        }
    }

    public function login($data)
    { //用户登录功能模型
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        } 
        unset($data['verify']); //将传进来数组的verify字段删除
        $result = $this->where($data)->find(); //进行查询
        if($result){
          $sessionData = [
            'id'=>$result['id'],
            'nickname'=>$result['nickname']
          ];
          session('index',$sessionData ); //保存session到浏览器
            return 1;
        }else{
            return '用户名或者密码错误';
        }
    }
}
