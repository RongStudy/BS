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
        return \think\Db::table($this->table)->field($field)->where($map)->find();
    }

    /**
     * 登陆成功，记录信息
     */
    public function updateLoginInfo($list){
        $return = false;
        $update = [
            'login_count'       => intval($list['login_count'])+1,
            'last_login_time'   => time()
        ];
        $is_update = \think\Db::table($this->table)
                    ->where(['uid'=>$list['uid']])
                    ->update($update);
        if($is_update){
            session( 'home.session_start_time', time()); //设置开始时间
            session( 'home.user_auth', $list);
            $return = true;
        }
        
        return $return;
    }
}


 ?>