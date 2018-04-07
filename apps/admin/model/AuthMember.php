<?php 
namespace app\admin\model;
use think\Model;

/**
 * 用户表
 */

class AuthMember extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_auth_member';

    /**
     * 添加后台管理员
     */
    public function addAdmin(){

    }

    /**
     * 验证登陆操作
     */
    public function login($username, $password){
        $map = [
            'username'  =>   $username,
            'password'  =>   cthink_md5($password)
        ];
        $admin_info = \think\Db::table($this->table)
                    ->where($map)
                    ->field('uid, username, nickname, status, is_remove, login_count, last_login_time, user_type')
                    ->find();
        return $admin_info;
    }

    /**
     * 登陆成功，记录信息
     */
    public function updateLoginInfo($admin_info){
        $return = false;
        $update = [
            'login_count'       => intval($admin_info['login_count'])+1,
            'last_login_time'   => time()
        ];
        $is_update = \think\Db::table($this->table)
                    ->where(['uid'=>$admin_info['uid']])
                    ->update($update);
        if($is_update){
            session( 'admin.session_start_time', time()); //设置开始时间
            session( 'admin.user_auth', $admin_info);
            $return = true;
        }
        
        return $return;
    }

    public function get_info($map, $field){
        $data = \think\Db::table($this->table)
                -> where($map)
                -> field($field)
                -> find();
        return $data;
    }

    /**
     * 搜索用户
     */
    public function searchMember($map){
        return \think\Db::table($this->table)->where($map)->paginate(10);
    }
}


 ?>