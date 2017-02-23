<?php
namespace Common\Model;
use Think\Model;
class NewsContentModel extends Model
{
    public function insertContent($data)
    {
        if(!$data || !is_array($data))
        {
            E('数据错误');
        }
       $data['create_time'] = time();
       $data['content'] = htmlspecialchars($data['content']);
        return $this->add($data);
    }

    //查询单个数据
    public function finds($news_id)
    {
//        $cond['status'] = 1;
        return $this->find(array('news_id'=>$news_id));
    }


}