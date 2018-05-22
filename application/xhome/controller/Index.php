<?php
/**
 * author    tangxiaowen
 * mail:     846506584@qq.com
 * Date:     2018/5/22 20:35
 * describe: 首页类
 */

namespace app\xhome\controller;
import('Connect2-1.API.qqConnectAPI');

use QC;

class Index extends Common{

    public function index(){



        return $this->fetch();
    }

    /**
     * QQ登录
     */
    public function qqLogin(){
        $QC=new QC();
        $QC->qq_login();


    }

}