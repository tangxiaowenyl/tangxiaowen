<?php
namespace app\xadmin\controller;
use think\Controller;
use think\Db;

class Login extends Controller{
	
	//登录
	public function index(){
		
		
		//验证是否登录
		if(session('admin.id','','xiao_admin')){
			$this->redirect('index/index');
		}
		
		if(request()->isAjax()){
			$param = json_decode(input('param.param','','strip_tags'),true);
			$result = $this->validate($param, 'app\validate\Admin.login');
            $token = $this->request->token('__token__', 'sha1');
            if (true !== $result) {
                return ['code' => 0,'data' => '','msg' => $result,'token' => $token];
            }

            $data = db('admin')->where('username',$param['username'])->find();
            if($data === null){
            	return json(['code' => -1,'data' => '','msg' => '管理员不存在','token' => $token]);
            }
            
            $password = hash("sha256", $param['password']);
            if($password != $data['password']){
            	return json(['code' => -2,'data' => '','msg' => '密码错误','tokne' => $token]);
            }
            
            session('admin',$data,'xiao_admin');
            
            return json(['code' => 1,'data' => '','url_' => url('xadmin/index/index'),'msg' => '登录成功']);
		}
		
		return $this->fetch();
	}
	
	//退出登录
	public function logOut(){
		session(null, 'xiao_admin');
		$this->redirect('xadmin/label/index');
	}
	
}