<?php 
namespace app\home\model;
use think\Model;

class AuthMember extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_auth_member';

    /**
     * 用户注册，添加用户
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
    public function createUser($map){
        return \think\Db::table($this->table)->insert($map);
    }

    /**
     * 用户登录
     */
    public function findUser($map, $field = '*'){
        return \think\Db::table($this->table)->field($field)->find($map);
    }
}


 ?>