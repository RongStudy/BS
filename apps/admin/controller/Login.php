<?php 
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;

class Login extends Controller{
    /**
     * 后台登录
     * @return [type] [description]
     */
    public function index(){
        if(request()->isPost()){
            $username = input('username');
            $password = input('password');
            $code = trim(input('code'));

            // 判断验证码是否正确
            if(!$code || !captcha_check($code)){
                return json(array('code'=>0, 'msg'=>'验证码错误'));
            }

            // 判断用户名密码
            if(!empty($username) && !empty($password)){
                $admin_info = model('AuthMember')->login($username, $password);
                if($admin_info){
                    if($admin_info['user_type'] == '1' ){
                        if($admin_info['status'] == '2' ){
                            $this->error('账号被禁用');
                        }else if($admin_info['is_remove'] == '2'){
                            $this->error('账号被删除');
                        }else{
                            // 验证成功，记录登录信息
                            if(model('AuthMember')->updateLoginInfo($admin_info)){
                                $this->success('登录成功');
                            }
                        }
                    }else{
                        $this->error('账号不存在');
                    }
                }else{
                    $this->error('账号或密码有误');
                }
            }
            
        }else{
            if(is_login_admin()){
                $this->redirect(url('Index/index'));
            }else{
                $domain = config('url_domain');
                $this->assign('static', $domain . '/static/' . request()->module());
                return $this->fetch();
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout(){
        Session::clear( 'admin' );
        Session::delete( 'admin' );
        $this->redirect(url('Login/index'));
    }
}

 ?>