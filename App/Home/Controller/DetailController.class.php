<?php
/**
 * 文章显示页
 */
namespace Home\Controller;
use Think\Controller;
class DetailController extends CommonController
{
    /**
     *
     */
    public function index()
    {
        header('Content-type:text/html;charset=utf8');
        $id = intval($_GET['id']);
        if(!$id || $id<0)
        {
          $this->error('页面不存在');
        }
        $news = D('News')->finds($id);
        if(!$news || $news['status']!=1)
        {
            $this->error('页面错误');
        }
        //更新阅读
        $count = intval($news['count']) + 1;
        D('News')->updateCount($id,$count);
        $news_content = D('NewsContent')->finds($id);
        $news['content'] = htmlspecialchars_decode($news_content['content']);
//        p($news['content']);exit();
        $advNew = D('PositionContent')->home_select(array('status'=>1,'position_id'=>1),2); //广告位
        $getRank = $this->getRank(); //文章排行

        $this->assign('result',array(
            'advNews'=>$advNew,
            'rankNews'=>$getRank,
            'news'=>$news,
            'catid'=>$news['catid'],
        ));
        $this->display();
    }
}