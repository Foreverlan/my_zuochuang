<?php

namespace app\admin\controller;

use think\Controller;
use think\Url;
use think\Db;
use think\Model;
use think\Session;
use app\admin\model\Userinfo as Userinfo;

class AdminController extends Controller {

    public function indexAction() {
        $userInfo = array();

        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }


        $result = Db::query('select * from think_userinfo where Id = ? and isDelete =0', [$is_login]);

        if (!empty($result)) {

            $userInfo['name'] = $result[0]['real_name'];
            $userInfo['header'] = '__STATIC__/img/' . $result[0]['header'];
        } else {
            $this->redirect('admin/admin/error');
        }

        $this->assign('user', $userInfo);
        $this->assign('iframe', url('admin/Admin/home'));

        //print_r($userInfo);
        return $this->fetch();
    }

    public function errorAction() {
        return $this->fetch();
    }

    public function homeAction() {
        $arr = array();

        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $result = Db::query('select member from think_Visit where Date between ? and ? ', [date("Y-m-d", strtotime("-1 day")), date("Y-m-d")]);
        if (!empty($result)) {
            //  print_r($result);
            $arr['visit_member'] = $result[1]['member'];
            $arr['visit_up'] = $result[1]['member'] - $result[0]['member'];
        } else {
            $this->redirect('admin/admin/error');
        }

        $result = Db::query('select count(*) as sum from think_userinfo union select count(*) from think_userinfo where register_time between ? and ?', [date("Y-m-d", strtotime("-1 day")), date("Y-m-d")]);
        if (!empty($result)) {
            // print_r($result);
            $arr['user_member'] = $result[0]['sum'];
            $arr['user_up'] = $result[1]['sum'];
        } else {
            $this->redirect('admin/admin/error');
        }

        $this->assign('arr', $arr);

        return $this->fetch();
    }

    public function loginAction() {
        $is_login = Session::get('admin_id');
        if (!empty($is_login)) {
            $this->error("您已经登录", url('admin/Admin/index'));
            //$this->redirect('admin/index/home');
        }

        if ($this->request->isPost()) {
            $condition['username'] = $_POST['username'];
            $condition['password'] = $_POST['password'];
            if (!empty($condition['username']) && !empty($condition['password'])) {
                $result = Db::query('select * from think_userinfo where user_name = ? and  password= ? ', [$condition['username'], md5($condition['password'])]);
                if (!empty($result)) {

                    //session('admin_id', $result[0]['Id']);
                    //$_SESSION['admin_id']=$result[0]['Id'];

                    Session::set('admin_id', $result[0]['Id']);


                    $url = session('from_url') ? session('from_url') : url('admin/Admin/index');
                    exit(json_encode(array('status' => 1, 'url' => $url)));
                } else {
                    exit(json_encode(array('status' => 0, 'msg' => '账号密码不正确')));
                }
            } else {
                $data = array('status' => 1);
                exit(json_encode($data));
            }
        }


        return $this->fetch();
    }

    public function userAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $result = Db::query('select * from think_userinfo where Id = ?', [$is_login]);
        if (!empty($result)) {

            $userInfo['name'] = $result[0]['real_name'];
            $userInfo['header'] = '__STATIC__/img/' . $result[0]['header'];
        } else {
            $this->redirect('admin/admin/error');
        }

        $this->assign('user', $userInfo);
        $this->assign('iframe', url('admin/Admin/userList'));
        return $this->fetch('index');
    }

    public function userListAction() {

        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $keywords = input('keywords/s');

        if (!empty($keywords)) {
            $result = Db::query("select * from think_userinfo where user_name like '%" . $keywords . "%'");
        } else {
            $result = Db::query('select * from think_userinfo');
        }
        if (!empty($result)) {
            $this->assign('list', ($result));
        } else {
            $this->redirect('admin/admin/error');
        }
        return $this->fetch();
    }

    public function addUserAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $result = Db::query('select * from think_userinfo where Id = ?', [$is_login]);
        if (!empty($result)) {

            $userInfo['name'] = $result[0]['real_name'];
            $userInfo['header'] = '__STATIC__/img/' . $result[0]['header'];
        } else {
            $this->redirect('admin/admin/error');
        }

        $this->assign('user', $userInfo);
        $this->assign('iframe', url('admin/Admin/userInfo'));
        return $this->fetch('index');
    }

    public function userInfoAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $id = input('Id/s');
        if ($id) {
            $result = Db::query("select * from think_userinfo where Id =?", [$id]);

            $this->assign('info', $result);
        } else {
            $this->assign('info', null);
        }
        $act = empty($id) ? 'add' : 'edit';
        $this->assign('act', $act);
        return $this->fetch();
    }

    public function adminHandleAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $data = input('post.');
        if ($data['act'] == 'add') {
            unset($data['act']);
            unset($data['Id']);

            $result = Db::query('select * from think_userinfo where user_name = ?', [$data['user_name']]);

            if (!empty($result)) {
                $this->error("此用户名已存在，请更换", url('Admin/Admin/userInfo'));
            } else {
                $data['register_time'] = date("Y-m-d");
                $data['password'] = md5($data['password']);
                $data['header'] = 'a3.jpg';
                $r = db('userinfo')->insert($data);
            }
        } else if ($data['act'] == 'edit') {
            unset($data['act']);
            $r = db('userinfo')->where('Id', $data['Id'])->update($data);
        } else if ($data['act'] == 'del' && $data['Id'] > 1) {
            unset($data['act']);
            $r = db('userinfo')->where('Id', $data['Id'])->delete();
            exit(json_encode(1));
        }

        if ($r) {
            $this->success("操作成功", url('Admin/Admin/userList'));
        } else {
            $this->error("操作失败", url('Admin/Admin/userList'));
        }
    }
    
    
    public function userSearchAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $result = Db::query('select * from think_userinfo where Id = ?', [$is_login]);
        if (!empty($result)) {

            $userInfo['name'] = $result[0]['real_name'];
            $userInfo['header'] = '__STATIC__/img/' . $result[0]['header'];
        } else {
            $this->redirect('admin/admin/error');
        }

        $this->assign('user', $userInfo);
        $this->assign('iframe', url('admin/Admin/userSearchList'));
        return $this->fetch('index');
    }
    
    public function userSearchListAction() {

        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $keywords = input('keywords/s');

        if (!empty($keywords)) {
            $result = Db::query("select * from think_user where user_name like '%" . $keywords . "%'");
        } else {
            $result = Db::query('select * from think_user');
        }
        if (!empty($result)) {
            $this->assign('list', ($result));
        } else {
            $this->redirect('admin/admin/error');
        }
        return $this->fetch();
    }
    
    public function userAddAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $result = Db::query('select * from think_user where Id = ?', [$is_login]);
        if (!empty($result)) {

            $userInfo['name'] = $result[0]['real_name'];
            $userInfo['header'] = '__STATIC__/img/' . $result[0]['header'];
        } else {
            $this->redirect('admin/admin/error');
        }

        $this->assign('user', $userInfo);
        $this->assign('iframe', url('admin/Admin/userListInfo'));
        return $this->fetch('index');
    }
    
    public function userListInfoAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $id = input('user_id/s');
        if ($id) {
            $result = Db::query("select * from think_user where Id =?", [$id]);
            $this->assign('info', $result);
        } else {
            $this->assign('info', null);
        }
        $act = empty($id) ? 'add' : 'edit';
        $this->assign('act', $act);
        return $this->fetch();
    }
    
    public function userHandleAction() {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }

        $data = input('post.');
        if ($data['act'] == 'add') {
            unset($data['act']);
            unset($data['Id']);

            $result = Db::query('select * from think_user where user_name = ?', [$data['user_name']]);

            if (!empty($result)) {
                $this->error("此用户名已存在，请更换", url('Admin/Admin/userListInfo'));
            } else {
                $data['register_time'] = date("Y-m-d");
                $data['password'] = md5($data['password']);
                $data['header'] = '__STATIC__/zuochuang/img/userheader.jpg';
                $r = db('user')->insert($data);
            }
        } else if ($data['act'] == 'edit') {
            unset($data['act']);
            $r = db('userinfo')->where('user_id', $data['Id'])->update($data);
        } else if ($data['act'] == 'del' && $data['Id'] > 1) {
            unset($data['act']);
            $r = db('userinfo')->where('user_id', $data['Id'])->delete();
            exit(json_encode(1));
        }

        if ($r) {
            $this->success("操作成功", url('Admin/Admin/userList'));
        } else {
            $this->error("操作失败", url('Admin/Admin/userList'));
        }
    }
    
    

    public function addAdminAction() {
       /* $user_info = new Userinfo;
        $user_info->user_name = 'liucong';
        $user_info->password = md5('q941103.');
        $user_info->save();*/

        //批量添加
        $user = new Userinfo;
        $list = [
            ['user_name' => 'wangwu', 'password' => 'wangwu.com'],
            ['user_name' => 'lisi', 'password' => 'lisi.com']
        ];
        $user->saveAll($list);
    }

    public function deleteAdminAction() {
        $user = Userinfo::get(3);
        $user->delete();

        //批量删除
        //Userinfo::destroy([1, 2, 3]);
    }

    public function updateAdminAction() {
        // save方法第二个参数为更新条件
        $user = new Userinfo;
        $user->save([
            'user_name' => 'zhangsan',
            'password' => md5('zhangsan123')
                ], ['id' => 2]);

        $user = new Userinfo;
        $user->update(['id' => 1, 'name' => 'thinkphp']);

        //批量更新
        $user = new Userinfo;
        $list = [
            ['Id' => 2, 'user_name' => 'thinkphp', 'password' => 'thinkphp@qq.com'],
            ['Id' => 3, 'user_name' => 'onethink', 'password' => 'onethink@qq.com']
        ];
        $user->saveAll($list);
    }

    public function selectAdminAction() {
        $user = Userinfo::get(1);
        echo $user->user_name;
        echo '<br/>';
        $user = Userinfo::get(['user_name' => 'liucong']);
        echo $user->toJson();
        echo '<br/>';
        $list = Userinfo::all([1, 2, 3]);
        foreach ($list as $key => $user) {
            echo $user;
            echo '<br>';
        }
    }

    public function test01Action() {

        $data = array(
            'status' => '1',
            'msg' => urlencode("账号密码不正确"),
        );
        $data = json_encode($data);
        exit(urldecode($data));
    }

    public function test02Action() {
        $subsql = Db::table('think_data')->where(['status' => 1])->field('Id,data  type')->group('Id')->buildSql();
        $list = Db::table('think_userinfo')->alias('a')->join([$subsql => 'w'], 'a.Id = w.Id')->select();
        return json($list);
    }

    public function test03Action() {
        $result = Db::query('select * from think_userinfo where user_name = "liucong"');
        return json($result);

        $data = \think\Cache::get('users');
        return json($data);
    }

    public function test04Action() {
        $result = Db::query('select * from think_userinfo');

        $this->assign('list', ($result));
        return $this->fetch();
    }

    public function showAction() {
        echo "网站的根目录地址：" . __DIR__ . "<br>";
        echo $_SERVER['PATH_INFO'] . "<br>";
        echo config('app_namespace');
    }

}
