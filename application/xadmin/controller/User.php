<?php
	namespace app\xadmin\controller;
	class Model{
		private static $link=NULL;
		private function __construct(){
			echo '连接数据库成功';
			echo '<br/>';
		}
		
		public static function getLink(){
			if(is_null(self::$link)){
				self::$link=new self;
				echo '单例模式实例化';
				return self::$link;
			}
			return self::$link;
		}
		public function show(){
			echo 'show';
		}
	}


//普通实例化类
//$obj=new Model;
//$obj=new Model;
//$obj=new Model;
//$obj=new Model;
//$obj=new Model;
//$obj->show();

//单例模式实例化类
//单例模式就是实例化一次
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj=Model::getLink();
$obj->show();











?>