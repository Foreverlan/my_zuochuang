<?php

namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;

class Userinfo extends Model {
    
    public function data()
    {
        return $this->hasOne('data');
    }
    
    public function getStatusAttrAction($value)
    {
        $user_name = ['admin'=>'超级管理员','liucong'=>'刘聪','zhangsan'=>'张三','lisi'=>'李四'];
        return $user_name[$value];
    }
}
