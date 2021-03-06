<?php

namespace app\common\model;

use app\common\validate\Article as ValidateArticle;
use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{
    // 软删除f
    use SoftDelete;

    // 关联栏目表
    public function cate()
    {
        // 多对一 cate表 外键cate_id 主键id
        return $this->belongsTo('Cate', 'cate_id', 'id');
    }

    // 关联评论表  为了删除时一同删除评论   一对多
    public function comments(){
        return $this->hasMany('comment','article_id','id');
    }

    //添加文章
    public function add($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '文章添加失败！';
        }
    }

    //  推荐操作
    public function top($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('top')->check($data)) {
            return $validate->getError();
        } else {
            $articleInfo = $this->find($data['id']);
            $articleInfo->is_top = $data['is_top'];
            $result  = $articleInfo->save();
            // 判断是否更新成功
            if ($result) {
                return 1;
            } else {
                return '操作失败';
            }
        }
    }

    //编辑操作
    public function edit($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        } else {
            $articleInfo = $this->find($data['id']);
            $articleInfo->title = $data['title'];
            $articleInfo->tags = $data['tags'];
            $articleInfo->is_top = $data['is_top'];
            $articleInfo->desc = $data['desc'];
            $articleInfo->content = $data['content'];
            $articleInfo->cate_id = $data['cate_id'];
            $result = $articleInfo->save();
            if ($result) {
                return 1;
            } else {
                return '文章编辑保存失败';
            }
        }
    }

    public function post($data){//投稿功能

        $validate = new \app\common\validate\Article();
        if (!$validate->scene('post')->check($data)) {
            return $validate->getError();
        }
        $result = $this->save($data);
        if ($result) {
            return 1;
        }else {
            return '投稿失败！';
        }
    }
}
