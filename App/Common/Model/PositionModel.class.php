<?php
namespace Common\Model;
use Think\Model;

/**
 * 推荐位wmodel操作
 */
class PositionModel extends Model {

	protected $_validate = array(
		array('name','require','推荐位名称不能为空'),
		array('description','require','推荐位描述不能为空'),
	);

	private $_db = '';

	public function __construct() {
		$this->_db = M('position');
	}

	public function selects($data = array()) {

		$conditions = $data;
		$list = $this->_db->where($conditions)->order('id')->select();
		return $list;
	}

	public function find($id) {
		$data = $this->_db->where('id='.$id)->find();
		return $data;
	}
	public function getCount($data=array()) {
		$conditions = $data;
		$list = $this->_db->where($conditions)->count();

		return $list;
	}
    /**
    * 插入相关数据
    * @param  array  $data [description]
    * @return intval
    */
    public function insert($res=array()) {
    	if(!$res || !is_array($res)) {
    		return 0;
    	}
		$res['create_time'] = time();
    	return $this->_db->add($res);
    }

	/**
	 * 通过id更新的状态
	 * @param $id
	 * @param $status
	 * @return bool
	 */
	public function checkStatus($data)
	{
		if(!$data || !is_array($data))
		{
			E('数据异常');
		}
		if($data['status'] == 1)
		{
			return $this->_db->where('id='.$data['id'])->setField('status',$data['status']);
		}elseif($data['status'] == 0)
		{
			return $this->_db->where('id='.$data['id'])->setField('status',$data['status']);
		}
	}

	public function updateById($id, $data) {

		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		if(!$data || !is_array($data)) {
			throw_exception('更新的数据不合法');
		}
		return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录
	}
	// 获取正常的推荐位内容
	public function getNormalPositions() {
		$conditions = array('status'=>1);
		$list = $this->_db->where($conditions)->order('id')->select();
		return $list;
	}


}
