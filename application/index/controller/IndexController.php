<?php

namespace app\index\controller;

use think\Controller;
use think\Url;
use think\Db;
use think\Model;
use think\Session;

class IndexController extends Controller {

    public function indexAction() {
        $is_login = Session::get('user_id');

        if (!empty($is_login)) {
            $exit = input('exit/s');
            if ($exit == 1) {
                Session::delete('user_id');
                $result = Db::name('user')->where('user_id', '10')->find();
                $this->assign('user', $result);
                $this->assign('isLogin', 'false');
            } else {
                $this->assign('isLogin', 'true');
                $result = Db::name('user')->where('user_id', $is_login)->find();
                $this->assign('user', $result);
            }
        } else {
            $result = Db::name('user')->where('user_id', '10')->find();
            $this->assign('user', $result);
            $this->assign('isLogin', 'false');
        }


        $result = Db::query('select DISTINCT a.user_header, a.user_nickName,b.title,b.content,b.content_html,b.cover_photo_sm,b.create_date,c.section from think_topic as b inner join think_user as a on (a.user_id = b.userId) inner join think_section as c on (b.sectionId = c.Id) where b.isDelete =0 order by b.Id DESC');
        for ($i = 0; $i < count($result); $i++) {
            if (strlen($result[$i]['content']) > 138) {
                $result[$i]['content'] = mb_substr($result[$i]['content'], 0, 138, 'utf-8') . '...';
            }
        }
        $this->assign('list', ($result));

        $result = Db::name('section')->select();
        $this->assign('section', $result);
        return $this->fetch();
    }
    
    public function index1Action() {
        $is_login = Session::get('user_id');

        if (!empty($is_login)) {
            $exit = input('exit/s');
            if ($exit == 1) {
                Session::delete('user_id');
                $result = Db::name('user')->where('user_id', '10')->find();
                $this->assign('user', $result);
                $this->assign('isLogin', 'false');
            } else {
                $this->assign('isLogin', 'true');
                $result = Db::name('user')->where('user_id', $is_login)->find();
                $this->assign('user', $result);
            }
        } else {
            $result = Db::name('user')->where('user_id', '10')->find();
            $this->assign('user', $result);
            $this->assign('isLogin', 'false');
        }


        $result = Db::query('select DISTINCT a.user_header, a.user_nickName,b.title,b.content,b.content_html,b.cover_photo_sm,b.create_date,c.section from think_topic as b inner join think_user as a on (a.user_id = b.userId) inner join think_section as c on (b.sectionId = c.Id) where b.isDelete =0 order by b.Id DESC');
        for ($i = 0; $i < count($result); $i++) {
            if (strlen($result[$i]['content']) > 138) {
                $result[$i]['content'] = mb_substr($result[$i]['content'], 0, 138, 'utf-8') . '...';
            }
        }
        $this->assign('list', ($result));

        $result = Db::name('section')->select();
        $this->assign('section', $result);
        return $this->fetch();
    }

    public function section3Action() {
        $is_login = Session::get('user_id');

        if (!empty($is_login)) {
            $exit = input('exit/s');
            if ($exit == 1) {
                Session::delete('user_id');
                $result = Db::name('user')->where('user_id', '10')->find();
                $this->assign('user', $result);
                $this->assign('isLogin', 'false');
            } else {
                $this->assign('isLogin', 'true');
                $result = Db::name('user')->where('user_id', $is_login)->find();
                $this->assign('user', $result);
            }
        } else {
            $result = Db::name('user')->where('user_id', '10')->find();
            $this->assign('user', $result);
            $this->assign('isLogin', 'false');
        }


        $result = Db::query('select DISTINCT a.user_header, a.user_nickName,b.title,b.content,b.content_html,b.cover_photo_sm,b.create_date,c.section from think_topic as b  inner join think_user as a on (a.user_id = b.userId) inner join think_section as c on (b.sectionId=c.Id) where b.sectionId="3" and b.isDelete=0 order by b.Id DESC');
        for ($i = 0; $i < count($result); $i++) {
            if (strlen($result[$i]['content']) > 138) {
                $result[$i]['content'] = mb_substr($result[$i]['content'], 0, 138, 'utf-8') . '...';
            }
        }
        $this->assign('list', ($result));

        $result = Db::name('section')->select();
        $this->assign('section', $result);
        return $this->fetch();
    }

    public function section4Action() {
        $is_login = Session::get('user_id');

        if (!empty($is_login)) {
            $exit = input('exit/s');
            if ($exit == 1) {
                Session::delete('user_id');
                $result = Db::name('user')->where('user_id', '10')->find();
                $this->assign('user', $result);
                $this->assign('isLogin', 'false');
            } else {
                $this->assign('isLogin', 'true');
                $result = Db::name('user')->where('user_id', $is_login)->find();
                $this->assign('user', $result);
            }
        } else {
            $result = Db::name('user')->where('user_id', '10')->find();
            $this->assign('user', $result);
            $this->assign('isLogin', 'false');
        }


        $result = Db::query('select DISTINCT a.user_header, a.user_nickName,b.title,b.content,b.content_html,b.cover_photo_sm,b.create_date,c.section from think_topic as b  inner join think_user as a on (a.user_id = b.userId) inner join think_section as c on (b.sectionId=c.Id) where b.sectionId="4" and b.isDelete =0 order by b.Id DESC');
        for ($i = 0; $i < count($result); $i++) {
            if (strlen($result[$i]['content']) > 138) {
                $result[$i]['content'] = mb_substr($result[$i]['content'], 0, 138, 'utf-8') . '...';
            }
        }
        $this->assign('list', ($result));

        $result = Db::name('section')->select();
        $this->assign('section', $result);
        return $this->fetch();
    }

    public function selectAction() {
        $result = Db::query('select Id,data from think_data');

        if (!empty($result)) {
            $this->assign('list', $result);
        } else {
            $this->redirect('admin/admin/error');
        }



        $this->assign('name', 'liucong');
        //print_r($userInfo);

        return $this->fetch();
    }

    public function checkLoginAction() {
        if ($this->request->isPost()) {
            $data = input('post.');
            $result = Db::query('select * from think_user where isDelete = 0 and user_name = ? and user_password= ? ', [$data['user_name'], md5($data['user_password'])]);

            if (empty($result)) {
                exit(json_encode(array('status' => 0, 'msg' => '用户名或密码错误！')));
            } else {
                Session::set('user_id', $result[0]['user_id']);
                $url = session('from_url') ? session('from_url') : url('index/index/index');
                exit(json_encode(array('status' => 1, 'url' => $url)));
            }
        } else {
            $this->redirect('admin/admin/error');
        }
    }

    public function editorAction() {
        $is_login = Session::get('user_id');

        $date = date("YmdHisa");

        if ($this->request->isPost()) {
            $data = input('post.');

            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data['img'], $result)) {
                $type = $result[2];
                $new_file = ROOT_PATH . 'public' . DS . 'static' . DS . 'zuochuang' . DS . 'upload' . DS . 'topic' . DS . $date . '.' . $type;
                $file_path = '__STATIC__/zuochuang/upload/topic/' . $date . '.' . $type;
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $data['img'])))) {
                    
                }
            }



            $result = Db::execute('insert into think_topic(title,content,content_html,create_date,change_date,userId,sectionId,cover_photo_sm,isDelete) values(?,?,?,?,?,?,?,?,0)', [$data['title'], $data['content'], $data['content_html'], date("Y-m-d"), date("Y-m-d"), $is_login, $data['section'], $file_path]);

            if (!empty($result)) {
                exit(json_encode(array('status' => 1, 'msg' => '发布成功！', 'test' => $data['img'])));
            } else {
                exit(json_encode(array('status' => 0, 'msg' => '发布失败！')));
            }
        }

        if (!empty($is_login)) {
            $section = input('section/s');
            if (!empty($is_login)) {
                $this->assign('section', $section);
            } else {
                $this->redirect('admin/admin/error');
            }
        } else {
            $this->error("您未登录", url('index/Index/login'));
        }
        return $this->fetch();
    }

    public function myselfAction() {
        $is_login = Session::get('user_id');

        if (!empty($is_login)) {
            $exit = input('exit/s');
            if ($exit == 1) {
                Session::delete('user_id');
                $result = Db::name('user')->where('user_id', '10')->find();
                $this->assign('user', $result);
                $this->assign('isLogin', 'false');
            } else {
                $this->assign('isLogin', 'true');
                $result = Db::name('user')->where('user_id', $is_login)->find();
                $this->assign('user', $result);

                $result = Db::query('select DISTINCT a.user_id, a.user_header, a.user_nickName,b.title,b.content,b.content_html,b.cover_photo_sm,b.create_date,c.section from think_topic as b  inner join think_user as a on (a.user_id = b.userId) inner join think_section as c on (b.sectionId=c.Id) where a.user_id=? and b.isDelete=0 order by b.Id DESC', [$is_login]);
                $this->assign('list', ($result));
            }
        } else {
            $result = Db::name('user')->where('user_id', '10')->find();
            $this->assign('user', $result);
            $this->assign('isLogin', 'false');
        }
        return $this->fetch();
    }

    public function accSettingAction() {
        $is_login = Session::get('user_id');

        if (!empty($is_login)) {
            $exit = input('exit/s');
            if ($exit == 1) {
                Session::delete('user_id');
                $result = Db::name('user')->where('user_id', '10')->find();
                $this->assign('user', $result);
                $this->assign('isLogin', 'false');
            } else {
                $this->assign('isLogin', 'true');



                $result = Db::name('user')->where('user_id', $is_login)->find();
                $result = Db::query('select a.name as role,b.* from think_user as b inner join think_role as a on (a.Id = b.user_role) where b.user_id =1 ');
                $birth = explode("-", $result[0]['user_birth']);
                
                $this->assign('user', $result[0]);
                $this->assign('birth', $birth);
            }
        } else {
            $result = Db::name('user')->where('user_id', '10')->find();
            $this->assign('user', $result);
            $this->assign('isLogin', 'false');
        }
        return $this->fetch();
    }

    public function testAction() {
        if ($this->request->isPost()) {
            $file = request()->file('img');
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'zuochuang' . DS . 'upload');
            if ($info) {
                echo $info->getSaveName();
                echo $info->getFilename();
            } else {
// 上传失败获取错误信息
                echo $file->getError();
            }
        }
        $date = date("YmdHisa");
        $this->assign('date', $date);

        return $this->fetch();
    }

    public function exportAction() {

        $phpexcelSrc = APP_PATH . '../Classes/PHPExcel.php'; //我们将手动下载的phpexcel放置到了application同级目录
        include "$phpexcelSrc"; //引入phpExcel
        $phpexcel = new \PHPExcel(); //实例化PHPExcel类对象，方便操作即将生成的excel表格
        $phpexcel->setActiveSheetIndex(0); //选中我们生成的excel文件的第一张工作表



        $sheet = $phpexcel->getActiveSheet(); //获取到选中的工作表，方面后面数据插入操作
        //$res = db('userinfo')->field('user_name,password,real_name,register_time')->select(); //获取到要导出的数据，如果有限制条件可以加入where方法
        //此处设置的是生成的excel表的第一行标题
        $res = Db::query('select DISTINCT a.user_nickName,b.title,b.create_date,c.section from think_topic as b inner join think_user as a on (a.user_id = b.userId) inner join think_section as c on (b.sectionId = c.Id) where b.isDelete =0 order by b.Id DESC');

        $section = db('section')->field('section')->select();

        $arr = [
            'user_nickName' => '用户昵称',
            'title' => '文章标题',
            'section' => '文章栏目',
            'create_date' => '发布日期',
        ];
        array_unshift($res, $arr); //将我们上面手动设置的标题信息放到数组中，作为第一行写入数据表



        $currow = 0; //因为我们生成的excel表格的行数是从1开始，所以我们预先设置好一个变量，供下面foreach循环的$k使用
        foreach ($res as $k => $v) {
            $currow = $k + 1; //表示从生成的excel表格的第一行开始插入数据
            $sheet->setCellValue('A' . $currow, $v['user_nickName'])//为A列循环插入用户名数据
                    ->setCellValue('B' . $currow, $v['title'])//为B列循环插入价格数据
                    ->setCellValue('C' . $currow, $v['section'])//为C列循环插入购买数量数据
                    ->setCellValue('D' . $currow, $v['create_date'])//为D列循环插入商品名称数据

            ;
        }



        header('Content-Type: application/vnd.ms-excel'); //设置下载前的头信息
        header('Content-Disposition: attachment;filename="ceshi.xlsx"');
        header('Cache-Control: max-age=0');
        $phpwriter = new \PHPExcel_Writer_Excel2007($phpexcel); //此处的2007代表的是高版本的excel表格
        $phpwriter->save('php://output'); //生成并下载excel表格
        return;

        return view();
    }

    public function test123Action() {
        $DataValidation = APP_PATH . '../Classes/PHPExcel/Cell/DataValidation.php';
        include "$DataValidation"; 
        $phpexcelSrc = APP_PATH . '../Classes/PHPExcel.php'; 
        include "$phpexcelSrc"; 
        $objExcel = new \PHPExcel(); 

        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();
        $objValidation = $objActSheet->getCell("A1")->getDataValidation(); 

        $objValidation->setType('list')
                ->setErrorStyle('stop')
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('输入的值有误')
                ->setError('您输入的值不在下拉框列表内.')
                ->setPromptTitle('设备类型')
                ->setFormula1('"列表项1,列表项2,列表项3"');
        
        $objValidation = $objActSheet->getCell("B1")->getDataValidation(); 

        $objValidation->setType('list')
                ->setErrorStyle('stop')
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('输入的值有误')
                ->setError('您输入的值不在下拉框列表内.')
                ->setPromptTitle('设备类型')
                ->setFormula1('"列表项1,列表项2,列表项3"');
        
        $objValidation = $objActSheet->getCell("D1")->getDataValidation(); 

        $objValidation->setType('list')
                ->setErrorStyle('stop')
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('输入的值有误')
                ->setError('您输入的值不在下拉框列表内.')
                ->setPromptTitle('设备类型')
                ->setFormula1('"列表项1,列表项2,列表项3"');
        

        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="ceshi.xlsx"');
        header('Cache-Control: max-age=0');
        $phpwriter = new \PHPExcel_Writer_Excel2007($objExcel); 
        $phpwriter->save('php://output');
        return;

        return view();
    }

    public function exportTestAction() {
         $result = Db::name('user')->where('user_id', '10')->find();
         $result = Db::query('select a.name, b.user_name,b.user_sex,b.user_realName from think_user as b inner join think_role as a on (a.Id = b.user_role) where b.user_id =1 ');
         print_r($result);
    }

    public function alertAction() {
        phpinfo();
    }

}
