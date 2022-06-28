<?php

namespace app\admin\controller;

use think\Controller;

class System extends Base
{
    // 系统设置
    public function set(){
        if(request()->isAjax()){
            $data =[
                'id'=>input('post.id'),
                'webname'=>input('post.webname'),
                'copyright'=>input('post.copyright')
            ];
            $result = model('system')->edit($data);
            if($result ==1){
                $this->success('修改系统设置成功','admin/system/set');
            }else{
                $this->error($result);
            }
        }
        
        // 因为只有一条数据 所以直接find
        $webInfo = model('system')->find();
        $viewData=[
            'webInfo'=>$webInfo
        ];
        $this->assign($viewData);
        return view();
    }
}
