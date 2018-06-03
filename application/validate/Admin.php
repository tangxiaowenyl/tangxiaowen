<?php

namespace app\validate;
use think\Validate;

class Admin extends Validate{
    protected $rule = [
        'username'	=> 'require',
        'password'	=> 'require',
        '__token__' => 'require|token',
    ];
    
    protected $message  =   [
    	'username'	=> ['require' => '请输入用户名'],
    	'password'	=> ['require' => '请输入密码'],
        '__token__' => ['require' => '请联系846506584@qq.com','token' => '请联系846506584@qq.com'],
    ];
    
    protected $scene = [
        'login'		=> ['username','password','__token__'],
    ];

}