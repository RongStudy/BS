<?php 
namespace app\home\controller;
use think\Controller;
use think\Request;
use think\Session;

class Base extends controller{

    public $uid = 0;
    public $auth_user = [];

    /**
     * 模块
     */
    public $module = '';

    /**
     * 控制器名称
     */
    public $controller = '';

    /**
     * 行为名称
     */
    public $action = '';

    /**
     * 登录用户token
     */
    public $token = '';

    /**
     * 全局操作初始化方法
     * @return [type] [description]
     */
    public function _initialize(){

        $configSession = config( 'session' );
        //判断会话是否过期
        if( time()-session( 'home.session_start_time' ) > $configSession['expire'] ){
            // 如果session时间到期，就删除session
            Session::clear('home');
            Session::delete('home');
        }else{
            session( 'home.session_start_time', time() );   //重新设置开始时间
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
        Session::has('home')                && $this->auth_user = session('home.user_auth');
        isset( $this->auth_user['token'] )  && $this->token     = $this->auth_user['token']; 
        isset( $this->auth_user['uid'] )    && $this->uid       = $this->auth_user['uid'];

        if( strtolower( $this->controller ).'/'.strtolower( $this->action ) == 'index/index' ){
            // 首页不验证登录
        }else{
            // 检测当前是否登录
            if(!is_login_home()){
                $this->redirect( url( 'AuthMember/login' ) );
            }
        }
        $this->assign('auth_user', $this->auth_user);
        $this->assign('uid', $this->uid);
        $this->assign('token', $this->token);
    }
}



 ?>