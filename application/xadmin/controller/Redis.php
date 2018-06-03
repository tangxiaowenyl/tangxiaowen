<?php
namespace app\xadmin\controller;
use app\xadmin\model\Label as labelM;
	
class Redis{
	private static $link = NULL;
	private function __construct(){
		self::$link = new labelM();
	}
	
	public static function getLink(){
		if(is_null(self::$link)){
			return self::$link;
		}
		return self::$link;
	}
}

?>