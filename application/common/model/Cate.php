<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Cate extends Model
{
    // 软删除
    use SoftDelete;

    // 关联文章 一对多
    public function article()
    {
        return $this->hasMany('article','cate_id','id');
    }

    //添加栏目
    public function add($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        // allowfield 只添加数据库有的字段
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return "栏目添加失败";
        }
    }

    // /排序
    public function sort($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('sort')->check($data)) {
            return $validate->getError();
        } else {
            $catenInfo = $this->find($data['id']);
            // 将传入的sort字段赋值修改从数据表获取的栏目信息
            $catenInfo->sort = $data['sort'];
            //    保存
            $result = $catenInfo->save();
            if ($result) {
                return 1;
            } else {
                return "排序失败";
            }
        }
    }

    // 栏目编辑
    public function edit($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        } else {
            // 先查询后更新
            $cateInfo = $this->find($data['id']);
            $cateInfo->catname = $data['catename'];
            $result = $cateInfo->save();
            if ($result) {
                return 1;
            } else {
                return "栏目编辑失败";
            }
        }
    }
}
