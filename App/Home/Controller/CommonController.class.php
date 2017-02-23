<?php
/**
 * 前台公共控制器
 */
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller
{
    /**
     * CommonController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $message '错误信息'
     */
    public function error($message = '')
    {
        $message = $message ? $message : '系统发生错误';
        $this->assign('message',$message);
        $this->display('Index:error');
    }

    /**
     * getRank(); 参数有 status状态 limit 10
     * @return mixed
     */
    public function getRank()
    {
        $cond['status'] = 1;
        $res = D('News')->getRank();
        return $res;
    }
}