<?php
namespace app\admin\controller;

use think\Controller;
use think\Url;
use think\Db;
use think\Model;
use think\Session;
use think\Request;
use app\admin\model\Userinfo as Userinfo;
use app\admin\model\Data as Data;

class IndexController extends Controller
{
    public function indexAction()
    {
        $is_login = Session::get('admin_id');
        if (empty($is_login)) {
            $this->error("您未登录", url('admin/Admin/login'));
        }
        
        return $this->fetch();
    }
    
    public function testAction()
    {
//        $data  = new Data;
//        $data->data = 'liucong';
//        $data->status = '1';
//        $data->save();
        
        $data = model('Role');
        $res = $data->select();
        print_r($res);
    }
    
    public function homeAction()
    {
        $arr= array();
        
        $result = Db::query('select * from think_Visit where Date= ? and SystemId=? ', [ date("Y-m-d"), 1 ]);
            if (!empty($result)) {
                $arr["Tvisit"]=$result[0]['Member'];
            } else {
                    exit(json_encode(array('status'=>0,'msg'=>'占无数据')));
         }
         $this->assign('Tvisit',$arr["Tvisit"]);
         
        $result = Db::query('select * from think_Visit where Date= ? and SystemId=? ', [ date("Y-m-d",strtotime("-1 day")), 1]);
            if (!empty($result)) {
                $arr["Yvisit"]=$result[0]['Member'];
                
            } else {
                    exit(json_encode(array('status'=>0,'msg'=>'占无数据')));
            }
            
            $this->assign('Yvisit',$arr["Yvisit"]);
            
        if ($this->request->isPost()) { 
            $SystemId = $_POST['SystemId'];
            
            $result = Db::query('select * from think_Visit where Date= ? and SystemId=? ', [ date("Y-m-d"), $SystemId ]);
            if (!empty($result)) {
                $arr["test"]=$result[0]['Member'];
            } else {
                    exit(json_encode(array('status'=>0,'msg'=>'占无数据')));
            }
            $this->assign('result',$arr["test"]); 
        }
        
        return $this->fetch();
        
        
       /* $arr= array();
        
        $is_login =  Session::get('admin_id');
        if( empty( $is_login ) ){
            Session::set('from_url', url('admin/Index/home'));
            $this->error("您未登陆",url('admin/Admin/login'));    
            //$this->redirect('admin/index/home');
        }
        
        if ($this->request->isPost()) { 
            $SystemId = $_POST['SystemId'];
            
            $result = Db::query('select * from think_Visit where Date= ? and SystemId=? ', [ date("Y-m-d"), 1 ]);
            if (!empty($result)) {
                $arr["Tvisit"]=$result[0]['Member'];
            } else {
                    exit(json_encode(array('status'=>0,'msg'=>'占无数据')));
            }
            
            $result = Db::query('select * from think_Visit where Date= ? and SystemId=? ', [ date("Y-m-d",strtotime("-1 day")), $SystemId ]);
            if (!empty($result)) {
                $arr["Yvisit"]=$result[0]['Member'];
                
            } else {
                    exit(json_encode(array('status'=>0,'msg'=>'占无数据')));
            }
            $this->assign('result',$arr["Tvisit"]);
        }
        
        return $this->fetch();*/
    }


    public function helloAction()
    {
         return $this->fetch();
    }
	
    public function worldAction($name = 'World')
    {
        return 'Hello,' . $name . '！';
    }
	
    protected function test1Action()
    {
        return '这是一个测试方法!';
    }
	
    private function test2Action()
    {
        return '这是一个测试方法!';
    }
    
    public function test3Action(){
        $request = Request::instance();
        // 获取当前域名
        echo 'domain: ' . $request->domain() . '<br/>';
        echo 'file: ' . $request->baseFile() . '<br/>';
        echo 'url: ' . $request->url() . '<br/>';
        echo 'root:' . $request->root() . '<br/>';
        echo 'root with domain: ' . $request->root(true) . '<br/>';
        echo '访问ip地址：' . $request->ip() . '<br/>';
        echo '请求参数：';
dump($request->param());

dump($request->url()); 
    dump($request->baseUrl()); 
    }


    public function urlAction()
    {
        echo Url::build('url2','a=1&b=2');
        echo '<br/>';
        echo url('url2','a=1&b=2');
        echo '<br/>';
        echo url('url2',['a'=>'1','b'=>'2']);
        echo '<br/>';
        echo url('url2',array('a'=>'1','b'=>2));
        echo '<br/>';
        echo url('index/MyView/helloView','a=1&b=2');
        echo '<br/>';
        echo url('helloview/alan');
    }
    
    public function showAction()
    {
        echo "<br>"."网站的根目录地址".__ROOT__." ";  
        echo "<br>"."入口文件地址".__APP__." "; 
        echo "<br>"."当前模块地址".__URL__." "; 
        echo "<br>"."当前url地址".__SELF__." ";
        echo "<br>"."当前操作地址".__ACTION__." ";
        echo "<br>"."当前模块的模板目录".__CURRENT__." ";
        echo "<br>"."当前操作名称".ACTION_NAME." ";
        echo "<br>"."当前项目目录".APP_PATH." ";
        echo "<br>"."当前项目名称".APP_NAME." ";
        echo "<br>"."当前项目的模板目录".APP_TMPL_PATH." ";
        echo "<br>"."项目的公共文件目录".APP_PUBLIC_PATH." ";
        echo "<br>"."项目的配置文件目录".CONFIG_PATH." ";
        echo "<br>"."项目的公共文件目录".COMMON_PATH." ";
        //自动缓存与表相关的全部信息
        echo "<br>"."项目的数据文件目录".DATA_PATH." runtime下的data目录";
        echo "<br>"." ".GROUP_NAME."";
        echo "<br>"." ".IS_CGI."";
        echo "<br>"." ".IS_WIN."";
        echo "<br>"." ".LANG_SET."";
        echo "<br>"." ".LOG_PATH."";
        echo "<br>"." ".LANG_PATH."";
        echo "<br>"." ".TMPL_PATH."";
        //js放入的位置，供多个应用的公共资源
        echo "<br>"." ".WEB_PUBLIC_PATH.""; 
    }
    
}


