<?php

namespace app\common\model;

use think\Model;
use think\Db;

class Role extends Model {
    public function rolesAction(){
        return $this->hasOne("role");
    }
}
