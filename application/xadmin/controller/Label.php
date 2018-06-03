<?php
namespace app\xadmin\controller;
use app\xmodel\Label as labelM;
use think\Db;

class Label extends Base{
	
	private static $labelM = NULL;
	
	public function __construct(){
		parent::__construct();
		self::$labelM = new labelM();
	}
	
	/**
	 * 标签列表
	 */
	public function labelList(){
		
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
            
            
            $countPage = self::$labelM->where('')->whereTime('create_time','between',[$str_time,$end_time])->count();
            $data = self::$labelM->where('')->whereTime('create_time','between',[$str_time,$end_time])->order('create_time','desc')->page("$page,$nums")->select();
            if(!$data){
            	return josn(['code' => 1,'data' => '','msg' => '没有数据']);
            }
            
            return json(['code' => 0,'count' => $countPage,'data' => $data,'msg' => '']);
		}
		return $this->fetch();
	}
	
	/**
	 * 添加标签
	 */
	public function addLabel(){
		
		if(request()->isAjax()){
			//筛选参数
            $param = json_decode(input('param.param','','strip_tags,trim'), true);
            $param = [
            	'name' => trim($param['name']),
            	'__token__' => trim($param['__token__']),
            ];

            $result = $this->validate($param, 'app\validate\Label.add');
            $token = $this->request->token('__token__', 'sha1');
            if ($result !== true) {
                return ['code' => 0, 'data' => '', 'msg' => $result,'token' => $token];
            }

            $is_result = self::$labelM->addLabel($param);
            if($is_result === null){
            	return ['code' => -2,'data' => '','msg' => '添加失败','token' => $token];
            }
            
            return ['code' => 1,'data' => '','msg' => '添加成功','token' => $token];
		}
	}
	
	/**
	 * 删除标签
	 */
	public function delLabel(){
		
		if(request()->isAjax()){
			$result = $this->validate(input('post.'), 'LabelValidate.get_del');
            $token = $this->request->token('__token__', 'sha1');
            if ($result !== true) {
                return json(['code' => 0, 'data' => '', 'msg' => $result,'token' => $token]);
            }
            
			$result = self::$labelM->delLabel(input('post.key'));
			if(!$result){
				return json(['code' => -1,'data' => '','msg' => '删除失败','token' => $token]);
			}
			
			return json(['code' => 1,'data' => '','msg' => '删除成功','token' => $token]);
		}
	}
	
	/**
	 * 编辑标签
	 */
	public function editLabel(){
		
		if(request()->isAjax()){
			//筛选参数
            $param = json_decode(input('param.param','','strip_tags,trim'), true);
            $param = [
            	'key' => trim($param['key']),
            	'name' => trim($param['name']),
            	'status' => trim($param['status']),
            	'__token__' => trim($param['__token__']),
            ];
            
            $result = $this->validate($param, 'LabelValidate.edit');
            $token = $this->request->token('__token__', 'sha1');
            if ($result !== true) {
                return json(['code' => 0, 'data' => '', 'msg' => $result,'token' => $token]);
            }
            
            $find = self::$labelM->where('id',$param['key'])->find();
            if($find === null){
            	return json(['code' => -1,'data' => '','msg' => '标签不存在','token' => $token]);
            }
            
            $result = self::$labelM->editLabel($param,$find['id']);
            if(!$result){
            	return json(['code' => -2,'data' => '','msg' => '编辑失败','token' => $token]);
            }
            
			return json(['code' => 1,'data' => '','msg' => '编辑成功','token' => $token]);
		}
	}
	
	/**
	 * 查询标签
	 */
	public function queryLabel(){
		
		
	}
	
	/**
	 * 获取标签
	 */
	public function getLabel(){
		
		if(request()->isAjax()){
			$result = $this->validate(input('post.'), 'LabelValidate.get_del');
            $token = $this->request->token('__token__', 'sha1');
            if ($result !== true){
                return json(['code' => 0, 'data' => '', 'msg' => $result,'token' => $token]);
            }
            
			$result = self::$labelM->where('id',input('post.key'))->find();
			if($result === null){
				return json(['code' => -1,'data' => '','msg' => '没有标签','token' => $token]);
			}
			
			return json(['code' => 1,'data' => $result,'msg' => '','token' => $token]);
		}
	}
	
}
?>