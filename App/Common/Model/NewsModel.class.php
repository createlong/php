<?php
namespace Common\Model;
use Think\Model;
class NewsModel extends Model
{
    protected $_validate = array(
      array('catid','require','栏目不能为空'),
      array('title','require','标题不能为空'),
      array('small_title','require','短标题不能为空'),
      array('keywords','require','关键字不能为空'),
      array('description','require','描述不能为空'),
    );

    /**
     * 文章的插入
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        if(!is_array($data) || !$data)
        {
            E('数据错误');
        }
        $data['create_time'] = time();
        $data['username'] = '李阳';  //TODO 暂定是本人
        return $this->add($data);
    }

    /**
     * 文章的查询
     * @param array $cond
     * @param $p
     * @param $pageSize
     * @return mixed
     */
    public function selects($cond=array(),$p,$pageSize)
    {
        $condition = $cond;
        $condition['status'] = array('neq',-1);
        if(isset($cond['title']) && $cond['title'])
        {
            $condition['title'] = array('like','%'.$cond['title'].'%');
        }
        if(isset($cond['catid']) && $cond['catid'])
        {
            $condition['catid'] =intval($cond['catid']);
        }
        $offset = ($p-1)*$pageSize;
        return $this->where($condition)
                    ->order('`listorder` desc,`news_id` desc')
                    ->limit($offset,$pageSize)
                    ->select();
    }

    /**
     * @param $cond
     * @return mixed
     * 获取文章的个数
     */
    public function content_count($cond)
    {
       $condition  = $cond;
        if(isset($cond['title']) && $cond['title'])
        {
            $condition['title'] = array('like','%'.$cond['title'].'%');
        }
        if(isset($cond['catid']) && $cond['catid'])
        {
            $condition['catid'] = intval($cond['catid']);
        }
        return $this->where($condition)->count();
    }

    /**
     * 文章的排序
     * @param $news_id
     * @param $listorder
     * @return bool
     */
    public function checkListorder($id,$value)
    {
//        p($id);exit();
        if(!$id || !is_numeric($id))
        {
            E('id不合法');
        }

        $data['listorder'] = $value;
        return $this->where('news_id='.$id)->save($data);
    }
    public function checkStatus($data)
    {
        if(!$data || !is_array($data))
        {
            E('数据异常');
        }
//        p($data);exit();
        if($data['status'] == 1)
        {
            return $this->where('news_id='.$data['id'])->setField('status',$data['status']);
        }elseif($data['status'] == 0)
        {
            return $this->where('news_id='.$data['id'])->setField('status',$data['status']);
        }
    }

    //单挑查询
    public function finds($news_id)
    {

        return $this->find($news_id);
    }

    //查看推送过来的
    public function getNewsByIds($newsIds)
    {
         $newsIdsStr = implode(',',$newsIds);
         $cond['status'] = array('neq',-1);
         $cond['news_id'] = array('in',$newsIdsStr);
        return $this->where($cond)->select();
    }

    /**
     * @param array $cond
     * @param int $limit
     * @return mixed
     */
    public function getRank($cond=array(),$limit=10)
    {
        return $this->where($cond)->limit($limit)->select();
    }

    //获取计数器
    public function getNewsByNewsIdIn($newsIds)
    {
        if(!$newsIds && !is_array($newsIds))
        {
            E('数据异常');
        }
        $cond['news_id'] = array('in',$newsIds);
        return $this->where($cond)->getField('news_id,count');
    }
    //更新
    public function updateCount($id,$count)
    {
        return $this->where('news_id='.$id)->setField('count',$count);
    }

    public function maxcount() {
        $data = array(
            'status' => 1,
        );
        return $this->where($data)->order('count desc')->limit(1)->find();
    }

    //前台更新
    public function home_select($limit)
    {
        $cond = array('status'=>1);
        $this->where($cond)->order('`news_id` desc,`listorder` desc');
        if($limit)
        {
            $this->limit($limit);
        }
        return $this->select();
    }


}