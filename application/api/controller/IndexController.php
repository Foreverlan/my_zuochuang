<?php
namespace app\api\controller;

use think\Controller;
use think\Url;
use think\Db;
use think\Model;
use think\Session;
use think\Request;
use app\common\model\Role as Role;
use app\admin\model\Data as Data;


class IndexController extends Controller
{
    public function indexAction()
    {
        print_r("api模块下的index控制器的index方法！");
    }
    
    public function demoAction($id='6')
    {
        print_r("api模块下的index控制器的demo方法！ id=".$id);
    }
    
    public function infoAction()
    {
        $roleObj = new Role;
        var_dump($roleObj->select());die;
    }
    
    public function testAction()
    {
//        $data = new Data;
//        $data->data = 'zhangsan';
//        $data->status = '10';
//        $data->save();
//        echo $data->id;
        
        
        $value = array('id'=>'20', 'data'=>'wangwu','status'=>'20');
        //$json = json_encode($value);
        $data = new Data($value);
        //$data->allowField(['data','status'])->save();
        $data->allowField(true)->save($value,false);
        
        
    }
    
}


