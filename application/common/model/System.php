<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class System extends Model
{
    use SoftDelete;

    public function edit($data)
    { // 修改系统设置
        $validate = new \app\common\validate\System();
        if (!$validate->check($data)) {
            return $validate->getError();
        } else {
            $webInfo = $this->find($data['id']); //先查询后修改
            $webInfo->webname = $data['webname'];
            $webInfo->copyright = $data['copyright'];
            $result = $webInfo->save();
            if ($result) {
                return 1;
            } else {
                return '修改系统设置失败';
            }
        }
    }
}
