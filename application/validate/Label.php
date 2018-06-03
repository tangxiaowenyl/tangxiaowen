<?php

namespace app\validate;
use think\Validate;

class Label extends Validate{

    protected $rule = [
        'name'		=> 'require|unique:label|max:15',
        'status'	=> 'number|max:1',
        'key'		=> 'require|number',
        '__token__' => 'require|token',
    ];
    
    protected $message  =   [
    	'name'		=> ['require' => '标签名不能为空','max' => '标签名不能超过15个字符','unique' => '标签名称重复'],
    	'status'	=> ['require' => '请联系846506584@qq.com','number' => '请联系846506584@qq.com','max' => '请联系846506584@qq.com'],
    	'key'		=> ['require' => '请联系846506584@qq.com','number' => '请联系846506584@qq.com'],
        '__token__' => ['require' => '请联系846506584@qq.com','token' => '请联系846506584@qq.com'],
    ];
    
    protected $scene = [
        'add'		=> ['name','__token__'],
        'edit'		=> ['name','key','status','__token__'],
        'get_del'	=> ['key','__token__'],
    ];

}