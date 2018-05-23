<?php

namespace app\index\controller;

use think\Controller;
use think\Url;
use think\Db;
use think\Model;
use think\Session;

class LoginController extends Controller {

    public function indexAction() {
        $this->assign('zhanghao', ' ');
        return $this->fetch('register');
    }

    public function registerAction() {
        
        if ($this->request->isPost()) {
            $data = input('post.');
            
            $result = Db::query('select * from think_user where isDelete=0 and user_name = ?', [$data['user_name']]);

            if (!empty($result)) {
                exit(json_encode(array('status' => 0, 'msg' => '用户名已存在！')));
            } else {
                
                $data['register_time'] = date("Y-m-d");
                $data['user_password'] = md5($data['user_password']);
                $data['user_header'] = '__STATIC__/zuochuang/img/userheader.jpg';
                $data['user_nickName'] = $data['user_name'];
                $result = Db::execute('insert into think_user(user_name,user_password,user_header,user_nickName,register_time,isDelete) values(?,?,?,?,?,0)', [$data['user_name'],$data['user_password'],$data['user_header'],$data['user_nickName'],$data['register_time']]);
                if($result)
                {
                    
                    exit(json_encode(array('status' => 1, 'msg' => '注册成功！','zhanghao' => $data['user_name'])));
                }
                else{
                    exit(json_encode(array('status' => 0, 'msg' => '注册失败！','zhanghao' => $data['user_name'])));
                }
                    
            }
            
        }
        
        
        return $this->fetch();
    }

    public function loginAction() {
        $is_login = Session::get('user_id');
        if (!empty($is_login)) {
            $this->error("您已经登录", url('index/Index/index'));
        }   

        if ($this->request->isPost()) {
            $data = input('post.');
            $result = Db::query('select * from think_user where isDelete=0 and user_name = ? and user_password= ? ', [$data['user_name'],md5($data['user_password'])]);

            if (empty($result)) {
                exit(json_encode(array('status' => 0, 'msg' => '用户名或密码错误！')));
            } else {
                Session::set('user_id', $result[0]['user_id']);
                $url = session('from_url') ? session('from_url') : url('index/index/index');
               exit(json_encode(array('status' => 1, 'url' => $url)));
            }
        }
        return $this->fetch();
    }
    
    

}
