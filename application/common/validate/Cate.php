<?php

namespace app\common\validate;

use think\Validate;

class Cate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'catename|栏目名称' =>"require|unique:cate",
        'sort|排序'=>"require|number"
    ];
    public function sceneAdd(){
        return $this->only(['catename','sort']);
    }
    public function sceneSort(){
        return $this->only(['sort']);
    }
    public function sceneEdit(){
        return $this->only(['catename']);
    }
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
