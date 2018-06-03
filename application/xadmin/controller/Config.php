<?php
namespace app\xadmin\controller;
use app\xadmin\model\Config as configM;

//官网配置类
class Config extends Base{
	
	public function configList(){
		
		
		return $this->fetch();
	}
	
}

?>