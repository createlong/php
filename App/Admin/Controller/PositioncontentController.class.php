<?php
/**
 * Created by PhpStorm.
 *推送内容
 */
namespace Admin\Controller;
use Think\Controller;
class PositioncontentController extends Controller
{
    public function index()
    {
        $this->display();
    }

    public function insert()
    {
        //写入推荐位
        $position = D('Position')->getNormalPositions();
        if(IS_POST && IS_AJAX)
        {
            if(!isset($_POST['title']) || !$_POST['title'])
            {
                return show(0,'没有填写标题');
            }
            if(!isset($_POST['position_id']) || !$_POST['position_id'])
            {
                return show(0,'还没选择推荐位');
            }
            if(!isset($_POST['url']) || !isset($_POST['news_id']))
            {
                return show(0,'url和news_id不能同时为空');
            }
            if(!isset($_POST['thumb']) || !$_POST['thumb'])
            {
                if(isset($_POST['news_id']))
                {
                     $res = D('News')->find($_POST['news_id']);
                }
            }
        }
        $this->assign('positions',$position);
        $this->display();
    }
}