<?php
namespace app\xadmin\controller;
use app\xadmin\model\Category as categoryM;

//分类管理
class Category extends Base{
	
	protected static $categoryM =  null;
	
	public function __construct(){
		parent::__construct();
		if(is_null(self::$categoryM)) self::$categoryM = new categoryM();
	}
	
	
	//分类列表
	public function categoryList(){
		
		if(request()->isAjax()){
			
			//当前请求页数与显示条数
            $page = input('page');
            $nums = input('limit');
            
			//筛选参数
            $param = json_decode(input('param.param','','strip_tags,trim'), true);
            if(isset($param['status'])){
            	if($param['status'] == 0){
            		$where = '';
            	}elseif($param['status'] == 1){
            		$where['status'] = 0;
            	}elseif($param['status'] == 2){
            		$where['status'] = 1;
            	}
            }else{
            	$where = '';
            }
            
            $str_time = $param['str_time']?strtotime($param['str_time']):strtotime(date('Y-1-01', time()));
            $end_time = $param['end_time']?(strtotime($param['end_time'])+86399):strip_tags(time());
            
            
            $countPage = self::$categoryM->where($where)->whereTime('create_time','between',[$str_time,$end_time])->count();
            $data = self::$categoryM->where($where)->whereTime('create_time','between',[$str_time,$end_time])->order('create_time','desc')->page("$page,$nums")->select();
            if(!$data){
            	return josn(['code' => 1,'data' => '','msg' => '没有数据']);
            }
            
            return json(['code' => 0,'count' => $countPage,'data' => $data,'msg' => '']);
		}
		return $this->fetch();
	}
	
	//添加分类
	public function addCategory(){
		
		if(request()->isAjax()){
			//筛选参数
            $param = json_decode(input('param.param','','strip_tags,trim'), true);
            $param = [
            	'name' => trim($param['name']),
            	'status' => trim($param['status']),
            	'create_time' => time(),
            	'__token__' => trim($param['__token__']),
            ];
            $result = $this->validate($param, 'CategoryValidate.add');
            $token = $this->request->token('__token__', 'sha1');
            if ($result !== true) {
                return json(['code' => 0, 'data' => '', 'msg' => $result,'token' => $token]);
            }
            
            $is_exists = self::$categoryM->where('name',$param['name'])->value('id');
            if($is_exists !== null){
            	return json(['code' => -1,'data' => '','msg' => '分类名不能重复','token' => $token]);
            }
            
            $is_result = self::$categoryM->addCategory($param);
            if($is_result === null){
            	return json(['code' => -2,'data' => '','msg' => '添加失败','token' => $token]);
            }
            
            return json(['code' => 1,'data' => '','msg' => '添加成功','token' => $token]);
		}
	}
	
	//删除分类
	public function delCagetory(){
		
		if(request()->isAjax()){
			$result = $this->validate(input('post.'), 'CategoryValidate.get_del');
            $token = $this->request->token('__token__', 'sha1');
            if ($result !== true) {
                return json(['code' => 0, 'data' => '', 'msg' => $result,'token' => $token]);
            }
            
			$result = self::$categoryM->delCategory(input('post.key'));
			if(!$result){
				return json(['code' => -1,'data' => '','msg' => '删除失败','token' => $token]);
			}
			
			return json(['code' => 1,'data' => '','msg' => '删除成功','token' => $token]);
		}
	}
	
	//编辑分类
	public function editCategory(){
		
		if(request()->isAjax()){
			//筛选参数
            $param = json_decode(input('param.param','','strip_tags,trim'), true);
            $param = [
            	'key' => trim($param['key']),
            	'name' => trim($param['name']),
            	'status' => trim($param['status']),
            	'__token__' => trim($param['__token__']),
            ];
            $result = $this->validate($param, 'CategoryValidate.edit');
            $token = $this->request->token('__token__', 'sha1');
            if ($result !== true) {
                return json(['code' => 0, 'data' => '', 'msg' => $result,'token' => $token]);
            }
            
            $find = self::$categoryM->where('id',$param['key'])->find();
            if($find === null){
            	return json(['code' => -1,'data' => '','msg' => '标签不存在','token' => $token]);
            }
            
            $result = self::$categoryM->editCategory($param,$find['id']);
            if(!$result){
            	return json(['code' => -2,'data' => '','msg' => '编辑失败','token' => $token]);
            }
            
			return json(['code' => 1,'data' => '','msg' => '编辑成功','token' => $token]);
		}
	}
	
	
	
	
}

?>