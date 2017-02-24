<?php
/**
基本配置类
 */
namespace Common\Model;
use Think\Model;
class BasicModel
{
    //读取 F()快速缓存
    public function selects()
    {
        return F('basic_web_config');
    }
    public function save($data = array())
    {
        if(!$data)
        {
            E('没有提交数据');
        }
        $id = F('basic_web_config',$data);
        return $id;
    }



}