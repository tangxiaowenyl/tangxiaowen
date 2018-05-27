<?php
/**
 * author    tangxiaowen
 * mail:     846506584@qq.com
 * Date:     2018/5/26 22:34
 * describe: 用户表
 */

namespace app\xmodel;
use think\Model;
use think\Db;

class User extends Model{

    //自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 新增用户数据
     * @param array $data 新增的用户数据
     * @return
     */
    public function addUser($date){
        return $this->insertGetId($date);
    }

    /**
     * 编辑用户信息
     * @param array $data 需更新的数据
     * @param int $id 主键ID
     * @return
     */
    public function editUser($data,$id){
        return $this->save($data,['id'=>$id]);
    }

    /**
     * 根据qq_open_id获取用户关联QQ信息
     * @param string $openId QQ用户openId
     * @param array
     */
    public function getUserJoinQq($open_id){
        $fields = ['q.*','u.*','q.id' => 'qid'];
        return db::name('user')
            ->alias('u')
            ->where('q.qq_open_id',$open_id)
            ->join('user_qq q','u.id = q.user_id')
            ->field($fields)
            ->find();
    }

}