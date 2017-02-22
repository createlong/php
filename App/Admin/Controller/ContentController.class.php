<?php
/**
 * @message 文章
 */
namespace Admin\Controller;
use Think\Exception;

class ContentController extends CommonController
{
    public function index()
    {

        if (isset($_REQUEST['catid']) && $_REQUEST['catid']) {
            $cond['catid'] = $_REQUEST['catid'];
            $this->assign('catid', $cond['catid']);
        }
        if (isset($_REQUEST['title']) && $_REQUEST['title']) {
            $cond['title'] = $_REQUEST['title'];
            $this->assign('title', $cond['title']);
        }
        $p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
        $pageSize = 5;

        $contentsRes = D('News')->selects($cond, $p, $pageSize);
        $contentsCount = D('News')->content_count($cond);
        $menu_select = D('Menu')->getBarNav();

//        $pageAjax = new \Think\PageAjax($contentsCount,$pageSize);  //这是一个外部引入的一个Ajax分页类
        $page = new \Think\Page($contentsCount, $pageSize);
        $contentShow = $page->show();
        //简单的 Ajax分页 更高端的电动车
        if(IS_AJAX)
        {
            $p =isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
            $contentsRes = D('News')->selects(array(),$p,$pageSize);
            $this->assign('ContentRes',$contentsRes);
            $this->assign('contentShow',$contentShow);
            $html = $this->fetch('Content:ajaxPage');
            $this->ajaxReturn($html);
        }
        //获取推送位置
        $positions = D('Position')->getNormalPositions(); //推送
        $this->assign('positions',$positions);
        $this->assign('menu_select', $menu_select);
        $this->assign('ContentRes', $contentsRes);
        $this->assign('contentShow', $contentShow);
        $this->display();
    }

    public function add()
    {
        $jump_url = $_SERVER['HTTP_REFERER'];
        //来源
        $copy_from = C('COPY_FROM');
        //标题颜色
        $title_color = C('TITLE_FONT_COLOR');
        //菜单
        $menus = D('Menu')->getBarNav();
        if(IS_POST && IS_AJAX)
        {
           $data = $_POST;
           $news = D('News');
           try{
               if(!$news->create())
               {
                   return show(0,$news->getError());
               }
               $contentInsert = D('News')->insert($data);
               if(!$contentInsert)
               {
                   return show(0,'文章添加失败',array('jump_url'=>$jump_url));
               }
               $cond = array(
                  'content'=>$data['content'],
                  'news_id'=>$contentInsert,
               );
                $newsContentRes = D('NewsContent')->insertContent($cond);
               if(!$newsContentRes)
               {
                   return show(0,'文章内容添加失败',array('jump_url'=>$jump_url));
               }
                   return show(1,'添加成功');
           }catch(Exception $e)
           {
               return show(0,$e->getMessage(),array('jump_url'=>$jump_url));
           }
        }
        $this->assign('menus',$menus);
        $this->assign('copy_from',$copy_from);
        $this->assign('title_color',$title_color);
        $this->display();
    }

    //排序
    public function listorder()
    {
         parent::listorder('News');
        exit();
    }
    //状态
    public function setStatus()
    {
        parent::setStatus('News');
        exit();
    }

    //推送
    public function push()
    {
        $jump_url  = $_SERVER['HTTP_REFERER'];
        if(IS_POST && IS_AJAX)
        {
            $position_id = intval($_POST['position_id']);
            $newsIdArr = $_POST['pushu'];
            if(!$newsIdArr || !isset($newsIdArr))
            {
                return show(0,'请选择要推送的文章');
            }
            if(!$position_id || !isset($position_id))
            {
                return show(0,'请选择要推送的id');
            }

            $news = D('News')->getNewsByIds($newsIdArr);
            if(!$news)
            {
                return show(0,'推送的内容没有找到');
            }
          foreach($news AS $new)
          {
              $data = array(
                  'position_id'=>$position_id,
                  'title'=>$new['title'],
                  'thumb'=>$new['thumb'],
                  'news_id'=>$new['news_id'],
                  'create_time'=>time(),
                  'status'=>1,
              );
              $res = D('PositionContent')->insert($data);
          }

            if(!$res)
            {
                return show(0,'推送失败');
            }
                return show(1,'推送成功',array('jump_url'=>$jump_url));
        }
        exit;
    }


}