<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){

        //首页大图
        $topPic = D('PositionContent')->home_select(array('status'=>1,'position_id'=>1),1);

        $advNew = D('PositionContent')->home_select(array('status'=>1,'position_id'=>1),2); //广告位
        $getRank = $this->getRank(); //文章排行
        $this->assign('result',array(
            'topPic'=>$topPic,
            'advNews'=>$advNew,
            'rankNews'=>$getRank,
        ));
       $this->display();
    }
}