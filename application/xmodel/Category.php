<?php
namespace app\xiaoa\model;

use think\Model;
use think\Cache;

class Category extends Model{
	
	/**
	 * 添加分类
	 * @param array $param post提交数据
	 */
	public function addCategory($param){
		$resutl = $this->allowField(['name','status','create_time'])->save($param);
		if($resutl){
			Cache::rm('cacheAllCategory');
			return $resutl;
		}else{
			return false;
		}
	}
	
	/**
	 * 删除分类
	 * @param int $id 分类ID
	 */
	public function delCategory($id){
		$resutl = $this->where('id',$id)->delete();
		if($resutl){
			Cache::rm('cacheAllCategory');
			return $resutl;
		}else{
			return false;
		}
	}
	
	/**
	 * 编辑分类
	 * @param array $param post提交数据
	 * @param int $id 分类ID
	 */
	public function editCategory($param,$id){
		$resutl = $this->allowField(['name','status'])->save($param,['id' => $id]);
		if($resutl){
			Cache::rm('cacheAllCategory');
			return $resutl;
		}else{
			return false;
		}
	}
	
	/**
	 * 获取所有分类
	 */
	public function getAllCategory(){
		return Cache::remember('cacheAllCategory',function(){
            return $this->select()->toArray();
       	},86400);
	}
	
}
?>