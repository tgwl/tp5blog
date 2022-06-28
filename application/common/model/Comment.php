<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Comment extends Model
{
    use SoftDelete;  //软删除   

    // 关联文章表  多对一
    public function article()
    {
        return $this->belongsTo('article', 'article_id', 'id');
    }

    // 关联用户表 多对一  外键member_id
    public function member(){
        return $this->belongsTo('member','member_id','id');
    }
    
    public function comm($data){  //用户评论
        $validate  = new \app\common\validate\comment();
        if(!$validate->scene('comm')->check($data)){
            return $validate->getError();
        }else{
            $result = $this->allowField(true)->save($data);
            if($result){
                return 1;
            }else{
                return '用户评论失败';
            }
        }
    }
}
