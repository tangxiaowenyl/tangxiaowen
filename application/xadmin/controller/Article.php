<?php
namespace app\xadmin\controller;

use app\xadmin\model\Article as articleM;
use app\xadmin\model\Category;
use app\xadmin\model\Label;
use think\Db;

//文章管理类
class Article extends Base{
	
	protected static $artielM = null;
	
	public function __construct(){
		parent::__construct();
		if(is_null(self::$artielM)) self::$artielM = new articleM();
	}
	
	/**
	 * 文章列表
	 */
	public function articleList(){
		
		
		
		
		
		return $this->fetch();
	}
	
	/**
	 * 添加文章
	 */
	public function addArticle(){
		
		//获取正常使用中的标签
		$labelM = new Label();
		$labelData = $labelM->getAllLabel();
		foreach($labelData as $k=>$v){
			if($v['status'] == 2){
				unset($labelData[$k]);
			}
		}
		$this->assign('labelData',$labelData);
		
		//获取正常使用中的分类
		$categoryM = new Category();
		$categoryData = $categoryM->getAllCategory();
		foreach($categoryData as $k=>$v){
			if($v['status'] == 2){
				unset($categoryData[$k]);
			}
		}
		$this->assign('categoryData',$categoryData);
		
		
		
		return $this->fetch();
	}
	
	/**
	 * 编辑文章
	 */
	public function editArticle(){
		
		
	}
	
	/**
	 * 删除文章
	 */
	public function delAritlce(){
		
		
	}
	
}

?>