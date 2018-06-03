<?php
namespace app\xmodel;

use think\Model;
use think\Cache;

class Label extends Model{

    protected $autoWriteTimestamp = 'datetime';
	
	/**
	 * 添加标签
	 * @param array $param post提交数据
	 */
	public function addLabel($param){
		$result = $this->allowField(true)->save($param);
		if($result){
			Cache::rm('cacheAllLabel');
			return $result;
		}else{
			return false;
		}
	}
	
	/**
	 * 删除标签
	 * @param int $id 标签ID
	 */
	public function delLabel($id){
		$result = $this->where('id',$id)->delete();
		if($result){
			Cache::rm('cacheAllLabel');
			return $result;
		}else{
			return false;
		}
	}
	
	/**
	 * 编辑标签
	 * @param array $param post提交数据
	 * @param int $id 标签ID
	 */
	public function editLabel($param,$id){
		$result = $this->allowField(['name','status'])->save($param,['id' => $id]);
		if($result){
			Cache::rm('cacheAllLabel');
			return $result;
		}else{
			return false;
		}
	}
	
	/**
	 * 获取所有标签
	 */
	public function getAllLabel(){
		return Cache::remember('cacheAllLabel',function(){
            return $this->select()->toArray();
        },86400);
	}
	
}

?>