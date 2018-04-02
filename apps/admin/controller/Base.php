<?php 
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;

class Base extends controller{
    /**
     * 模块
     */
    public $module;

    /**
     * 域名
     */
    public $domain;

    /**
     * 登陆后记录用户id
     */
    public $uid = '';

    /**
     * 用户名
     */
    public $username = '';

    /**
     * 用户昵称
     */
    public $nickname = '';

    /**
     * 控制器名称
     */
    public $controller = '';

    /**
     * 行为名称
     */
    public $action = '';

    /**
     * 授权后菜单
     */
    public $menu = [];

    /**
     * 全局操作初始化方法
     * @return [type] [description]
     */
    protected function _initialize(){
        $user =session('admin');
        $configSession = config( 'session' );
        //判断会话是否过期
        if( time()-session( 'admin.session_start_time' ) > $configSession['expire'] ){
            // 如果session时间到期，就删除session
            Session::clear('admin');
            Session::delete('admin');
        }else{
            session( 'admin.session_start_time', time() );   //重新设置开始时间
        }

        // 检测当前是否登录
        if(!is_login_admin()){
            $url = url('Login/index');
            echo '<script>top.window.location.href="'.$url.'"</script>';
        }else{
            $this->uid = $user['user_auth']['uid'];
            $this->username = $user['user_auth']['username'];
        }

        // 获取当前模块名称
        $this->module       = request()->module();

        // 获取当前控制器名称
        $this->controller   = request()->controller();

        // 获取行为名称
        $this->action       = request()->action();

        //获取当前域名
        $this->domain       = config('url_domain');

        // 对模板输出全局静态文件根路径
        $this->assign('static', '/static/'.$this->module);

        // 返回用户数据
        Session::has('admin')               &&  $this->auth_user = session('admin.user_auth');
        isset( $this->auth_user['token'] )  &&  $this->token     = $this->auth_user['token']; 
    }
}



 ?>