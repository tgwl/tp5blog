<?php

namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'title|文章标题' => 'require|unique:article',
        'desc|文章概要' => 'require',
        'content|文章内容' => 'require',
        'tags|标签' => 'require',
        'cate_id|所属栏目' => 'require',
        'is_top|推荐' => 'require'
    ];

    // 添加文章场景
    public function sceneAdd()
    {
        return $this->only(['title', 'desc', 'content', 'tags', 'cate_id']);
    }
    // 文章推荐场景
    public function sceneTop()
    {
        return $this->only(['title', 'desc', 'content', 'tags', 'cate_id']);
    }

    //编辑场景
    public function sceneEdit()
    {
        return $this->only(['title', 'tags', 'is_top', 'cate_id', 'desc', 'content']);
    }

    //投稿场景
    public function scenePost()
    {
        return $this->only(['title', 'tags', 'cate_id', 'desc', 'content']);
    }

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];
}
