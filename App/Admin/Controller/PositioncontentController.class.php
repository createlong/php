<?php
/**
 * Created by PhpStorm.
 *推送内容
 */
namespace Admin\Controller;
use Think\Controller;
class PositioncontentController extends CommonController
{
    public function index()
    {
        if(isset($_REQUEST['title']) && $_REQUEST['title'])
        {
            $cond['title'] = $_REQUEST['title'];
        }
        if(isset($_REQUEST['position_id'])&& $_REQUEST['position_id'])
        {
            $cond['position_id'] = $_REQUEST['position_id'];
            $this->assign('positionId',$_REQUEST['position_id']);
        }
        $p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
        $pageSize = 10;
//
        $PositionContentRes = D('PositionContent')->selects($cond,$p,$pageSize);
        $PositionCount = D('PositionContent')->count($cond);
        $page = new \Think\Page($PositionCount,$pageSize);
        $PositionShow =  $page->show();
        $this->assign('PositionContentRes',$PositionContentRes);
        $this->assign('PositionShow',$PositionShow);
        //获取推荐位的推位
        $position = D('Position')->getNormalPositions();
        $this->assign('position',$position);
        $this->display();
    }

    public function add()
    {
        //写入推荐位
        $position = D('Position')->getNormalPositions();

        $this->assign('positions',$position); //写入
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
                     if($res && is_array($res))
                     {
                         $_POST['thumb'] = $res['thumb'];
                     }
                }else{
                    return show(0,'缩略图不能为空');
                }
            }
            $positionCId = D('PositionContent')->insert($_POST);
            if(!$positionCId)
            {
                return show(0,'推荐的内容不能为空');
            }
                return show(1,'推荐成功');
        }

        $this->display();
    }

    /** 修改状态 */
    public function setStatus()
    {
        parent::setStatus('PositionContent');
        exit();
    }
    //** 修改排序 */
    public function listorder()
    {
        parent::listorder('PositionContent');
        exit();
    }

}