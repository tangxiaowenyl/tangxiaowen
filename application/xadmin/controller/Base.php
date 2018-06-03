<?php

namespace app\xadmin\controller;
use think\Controller;

class Base extends Controller{
	
	//全局调用的用户ID
    protected $userid;
	
    public function __construct(){
		parent::__construct();
		//验证是否登录
		if(!session('admin.id','','xiao_admin')){
			$this->redirect('xadmin/login/index');
		}
		
		$this->userid = session('admin.id','','xiao_admin');
    }
    
    
}