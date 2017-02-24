<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        $news = D('News')->maxcount();
        $newscount = D('News')->content_count(array('status'=>1));
        $positionCount = D('Position')->getCount(array('status'=>1));
        $adminCount = D("User")->getLastLoginUsers();
        $this->assign('news', $news);
        $this->assign('newscount', $newscount);
        $this->assign('positioncount', $positionCount);
        $this->assign('admincount', $adminCount);

        //分配用户
        if(isset($_SESSION['user']))
        {
             $data = $_SESSION['user'];
             $this->assign('name',$data['name']);
        }else{
            redirect('./admin.php?c=login');
        }

        $this->display();
    }
}