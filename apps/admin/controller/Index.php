<?php
namespace app\admin\controller;


class Index extends Base{
    public function index(){
        // dump(APP_PATH);die;
        /**
         * 获取菜单
         */
        $top  = [];  // 上级菜单
        $down = []; // 下级菜单
        $map['hide'] = 1;
        $map['status'] = 1;
        $menu = model('Menu')->getMenus($map);

        foreach ($menu as $key => $value) {
            if($value['pid'] == 0){
                $top[] = $value;
            }else{
                $down[] = $value;
            }
        }

        $this->assign('top',$top);
        $this->assign('down',$down);
        return $this->fetch();
    }
    /**
     * 显示欢迎页
     */
    public function welcome(){
        if(is_login_admin()){
            $map = [];
            $login_info = session('admin')['user_auth'];
            $map['username'] = $login_info['username'];
            $field = 'username, nickname, login_count, last_login_time';
            $admin_info = model('AuthMember')->get_info($map, $field);
            $admin_info['domain']   = config('url_domain');
            $admin_info['ip']       = request()->ip();
            $admin_info['local_time'] = time();
            $this->assign('admin_info', $admin_info);
        }
        return $this->fetch();
    }
}
