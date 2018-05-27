<?php
/**
 * author    tangxiaowen
 * mail:     846506584@qq.com
 * Date:     2018/5/26 22:34
 * describe: QQ用户表
 */

namespace app\xmodel;
use think\Model;
use think\Db;

class UserQq extends Model{

    //自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 添加QQ用户
     * @param array postData 提交的QQ用户数据
     * @return
     */
    public function add($postData){
        return $this->insertGetId($postData);
    }

    /**
     * 编辑QQ用户
     * @param array $data 需更新的用户数据
     * @param int $id 主键ID
     * @return array|bool
     */
    public function editQqUser($data,$id){
        return $this->save($data,['id',$id]);
    }





}