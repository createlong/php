<?php
/**
 * 菜单
 */
namespace Home\Controller;
use Think\Controller;
class CatController extends CommonController
{
    public function index()
    {
        $cid = $_REQUEST['id'];
        if(!$cid)
        {
            $this->error('访问的页面不存在');
        }
        $nav = D('Menu')->finds($cid);
        if(!$nav && $nav['status'] != 1)
        {
            $this->error('访问的页面出错');
        }

        $advNew = D('PositionContent')->home_select(array('status'=>1,'position_id'=>1),2); //广告位
        $getRank = $this->getRank(); //文章排行
        $p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
        $pageSize = 5;
        $cond  = array(
            'status'=>1,
            'thumb'=>array('neq',''),
            'catid'=>$cid,
        );
        $news = D("News")->selects($cond,$p,$pageSize);
        $count  = D('News')->content_count($cond);
        $page = new \Think\Page($count,$pageSize);
        $newShow = $page->show();
        if(IS_AJAX)
        {
            $p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
            $news = D("News")->selects($cond,$p,$pageSize);
            $arr = array(
                'news'=>$news,
                'show'=>$newShow,  //并不需要这玩意
            );
            $this->ajaxReturn($arr);
        }
        $this->assign('result',array(
           'advNews'=>$advNew,
           'rankNews'=>$getRank,
           'catId'=>$cid,
           'listNews'=>$news,
           'newsShow'=>$newShow,
        ));
        $this->display();
    }
}