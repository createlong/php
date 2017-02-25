<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends CommonController {
    static $templates;
    public function index($type =''){

        $html = ROOT.'/index'.C('HTML_FILE_SUFFIX');
        if(is_file($html))
        {
            $url = './index.html';
            redirect($url);
        }
        //首页大图
        $topPic = D('PositionContent')->home_select(array('status'=>1,'position_id'=>1),1);
        //首页三小兔
        $threePic = D('PositionContent')->home_select(array('status'=>1,'position_id'=>2),3);
        //广告位
        $advNew = D('PositionContent')->home_select(array('status'=>1,'position_id'=>3),2);
        //文章排行
        $getRank = $this->getRank();
        //显眼的列表
        $newsList = D('News')->home_select(10);
        $this->assign('result',array(
            'topPic'=>$topPic,
            'threePic'=>$threePic,
            'newsList'=>$newsList,
            'advNews'=>$advNew,
            'rankNews'=>$getRank,
        ));
        if($type == 'buildHtml')
        {

            $this->buildHtml('index','./','Index:index');
            self::$templates = HTTP_PATH.'index'.C('HTML_FILE_SUFFIX');

        }else{
            $this->display();
        }

    }

    //获取阅读量
    public function getCount()
    {
      if(IS_POST && IS_AJAX)
      {
          if(!$_POST)
          {
              return show(0,'获取失败');
          }
          $newsIds = array_unique($_POST);
         try{
             $list = D('News')->getNewsByNewsIdIn($newsIds);
         }catch(Exception $e)
         {
              return show(0,$e->getMessage());
         }
          if(!$list)
          {
              return show(0,'数据获取失败');
          }
              return show(1,'success',$list);
      }
    }

    //生成 缓存
    public function build_html()
    {
        $this->index('buildHtml');
        return show(1,'首页缓存成功');
    }
    //自动生成缓存
    public function crontab_build_html()
    {
        if(APP_CRONTAB !=1)
        {
              die('the_file_must_exec_crontab');
        }
        $result = D('Baisc')->select();
        if(!$result['cacheindex'])
        {
            die('系统没有设置开启自动生成首页缓存的内容');
        }
        $this->index('buildHtml');
    }

    //  备份 mysqldump -uroot -p -B obj >F://
}