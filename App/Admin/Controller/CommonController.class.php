<?php
/**
 * @message 公共
 */
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    /**
     * 初始化
     * @return
     */
    private function _init() {
        // 如果已经登录
        $isLogin = $this->isLogin();
        if(!$isLogin) {
            // 跳转到登录页面
            redirect('./admin.php?c=login');
        }
    }

    /**
     * 获取登录用户信息
     * @return array
     */
    public function getLoginUser() {
        return session("user");
    }

    /**
     * 判定是否登录
     * @return boolean
     */
    public function isLogin() {
        $user = $this->getLoginUser();
        if($user && is_array($user)) {
            return true;
        }

        return false;
    }

    public function listorder($model)
    {
        $jump_url = $_SERVER['HTTP_REFERER'];
        if(IS_POST && IS_AJAX)
        {
            $data = $_POST['listorder'];
            try{
                $error = array();
                foreach($data AS $k=>$v)
                {
                    $menuListOrderRes =  D($model)->checkListorder($k,$v);
                    if(!$menuListOrderRes) $error[] = $k;
                }
                if(!empty($error))
                {
                    return show(0,'错误的id是:'.implode('-',$error),array('jump_url'=>$jump_url));
                }
                return show(1,'排序成功',array('jump_url'=>$jump_url));
            }catch(Exception $e)
            {
                return show(0,$e->getMessage());
            }

        }
        exit;
    }
    public function setStatus($model)
    {
        if(IS_POST && IS_AJAX)
        {
            $status =  D($model)->checkStatus($_POST);
            if($status) return show(1,'修改成功');
        }
        exit();
    }

}