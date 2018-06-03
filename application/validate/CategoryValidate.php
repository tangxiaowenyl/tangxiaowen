<?php

namespace app\xiaoa\validate;
use think\Validate;

class CategoryValidate extends Validate{
	
	protected $rule = [
        'name'		=> 'require|max:15',
        'status'	=> 'require|number|max:1',
        'key'		=> 'require|number',
        '__token__' => 'require|token',
    ];
    
    protected $message  =   [
    	'name'		=> ['require' => '分类名不能为空','max' => '分类名不能超过15个字符'],
    	'status'	=> ['require' => '请联系846506584@qq.com','number' => '请联系846506584@qq.com','max' => '请联系846506584@qq.com'],
    	'key'		=> ['require' => '请联系846506584@qq.com','number' => '请联系846506584@qq.com'],
        '__token__' => ['require' => '请联系846506584@qq.com','token' => '请联系846506584@qq.com'],
    ];
    
    protected $scene = [
        'add'		=> ['name','status','__token__'],
        'edit'		=> ['name','key','status','__token__'],
        'get_del'	=> ['key','__token__'],
    ];
    
}

?>