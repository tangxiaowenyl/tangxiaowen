<?php
/**
 * author    tangxiaowen
 * mail:     846506584@qq.com
 * Date:     2018/5/22 20:35
 * describe: 首页类
 */

namespace app\xhome\controller;

use QC;
use think\Db;
use app\xmodel\User;
use app\xmodel\UserQq;
use think\Log;
use Exception;
import('Connect2-1.API.qqConnectAPI');

class Index extends Common{

    private static $userQqModel;
    private static $userModel;

    public function __construct(){
        parent::__construct();
        self::$userQqModel = new UserQq();
        self::$userModel = new User();
    }

    public function index(){
        //如果有get参数的code和state证明是qq接口回调请求
	    if(isset($_GET['state']) && isset($_GET['code'])){
            $qc = new QC;
            //返回的是accesstoken//换取//用户信息的凭证
            $acs = $qc->qq_callback();
            //用户的唯一识别身份证,通过这个openid就可以区分不同的用户
            $openId = $qc->get_openid();
            //将得到的acstoken,和openid,传入qc类中，调用获取用户数据的方法
            $qc = new QC($acs,$openId);
            //获取用户信息数据
            $userInfo = $qc->get_user_info();
            //检测用户是否第一次登录 是新增用户表与QQ用户表 否则更新
            $isData = self::$userModel->getUserJoinQq($openId);
            if($isData == NULL){
                $userInfo['qq_open_id'] = $openId;
                $userInfo['create_time'] = time();
                // 启动事务
                Db::startTrans();
                try{
                    $userData = [
                        'username'   => $userInfo['nickname'],
                        'head_img'   => $userInfo['figureurl_qq_1'],
                        'login_time' => time(),
                        'login_ip'   => request()->ip(),
                        'login_num'  => 1,
                        'create_time'=> time(),
                    ];
                    $userId = self::$userModel->addUser($userData);
                    if(!$userInfo){
                        throw new Exception('5050 QQ登录写入用户表失败');
                    }
                    $userInfo['user_id'] = $userId;
                    $userInfo['qq_login_num'] = 1;
                    $resutl = self::$userQqModel->save($userInfo);
                    if(!$resutl){
                        throw new Exception('5050 QQ登录写入QQ关联表失败');
                    }
                    Db::commit();
                } catch (\Exception $e) {
                    Log::record($e->getMessage());
                    // 回滚事务
                    Db::rollback();
                    echo json_encode(['code' => 5050,'msg' => '系统休假中...','data' => []],JSON_UNESCAPED_UNICODE);die;
                }
                $userData['id'] = $userId;
                session('userInfo', $userData, 'xhome');
            }else{
                // 启动事务
                Db::startTrans();
                try{
                    $userData = [
                        'username'   => $userInfo['nickname'],
                        'head_img'   => $userInfo['figureurl_qq_1'],
                        'login_time' => time(),
                        'login_ip'   => request()->ip(),
                        'login_num'  => $isData['login_num'] + 1,
                        'update_time'=> time(),
                    ];
                    $userId = self::$userModel->editUser($userData,$isData['id']);
                    if(!$userId){
                        throw new Exception('5050 QQ登录更新用户表失败');
                    }
                    $userInfo['id'] = $isData['qid'];
                    $userInfo['qq_login_num'] = $isData['qq_login_num'] + 1;
                    $userInfo['update_time'] = time();
                    $resutl = self::$userQqModel->editQqUser($userInfo,$isData['qid']);
                    if(!$resutl){
                        throw new Exception('5050 QQ登录更新QQ关联表失败');
                    }
                    Db::commit();
                } catch (\Exception $e) {
                    Log::record($e->getMessage());
                    // 回滚事务
                    Db::rollback();
                    echo json_encode(['code' => 5050,'msg' => '系统休假中...','data' => []],JSON_UNESCAPED_UNICODE);die;
                }
                $userData['id'] = $userId;
                session('userInfo', $userData, 'xhome');
            }
            $this->redirect('http://tangxiaowen.com');
        }
        return $this->fetch();
    }

    /**
     * QQ登录
     */
    public function QqLogin(){
        $QC=new QC();
        $QC->qq_login();
    }

    /**
     * QQ登录退出
     */
    public function QqLoginOut(){
        session_unset();/*清除session*/
        session_destroy();/*清除session*/
        $this->redirect('http://tangxiaowen.com');
    }

}