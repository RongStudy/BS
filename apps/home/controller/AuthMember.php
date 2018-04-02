<?php 
namespace app\home\controller;
use think\Controller;
use think\Request;
use think\Session;

class AuthMember extends controller{
    /**
     * 初始化
     * @return [type] [description]
     */
    public function _initialize(){
        // 获取当前模块名称
        $this->module = request()->module();

        // 获取当前域名
        $this->domain = config('url_domain');

        // 对模板输出全局静态文件根路径
        $this->assign('static', $this->domain.'/static/'.$this->module);

    }

    /**
     * 登录
     * @return [type] [description]
     */
    public function login(){
        if(request()->isPost()){
            if(!captcha_check(input('captcha'))){
                $this->error('验证码不正确');
            }else{
                // $res = action('Login/checkLogin', input());
                $map = [];
                $map['username']  = input('uName');
                $map['user_type'] = '3';
                $field = '*';
                $list = model('AuthMember')->findUser($map, $field);
                if($list){
                    if($list['status'] == 2){
                        $this->error('此用户被禁用');
                    }else if($list['is_remove'] == 2){
                        $this->error('此用户被系统强制删除');
                    }else if($list['is_black']){
                        $this->error('此用户被列入了黑名单');
                    }else{
                        if($list['password'] == cthink_md5(input('uPwd'))){
                            
                        }else{
                            $this->error('密码不正确');
                        }
                    }
                }else{
                    $this->error('没有此用户');
                }
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 注册
     */
    public function register(){
        if(request()->isPost()){
            if(!captcha_check(input('captcha'))){
                $this->error('验证码不正确');
            }else{
                $map = [];
                $map['username'] = input('uPhone');   // 用户手机号
                $map['nickname'] = input('uName');
                $map['password'] = cthink_md5(input('uPwd'));
                $map['user_type'] = '3';
                $map['ctime']    = time();
                $res = model('AuthMember')->createUser($map);
                if($res){
                    $this->success('注册成功，请登录');
                }else{
                    $this->error('注册失败，请稍候重试');
                }
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 退出登录
     */
    public function logout(){
        // 删除登录的token记录
        $where = [];
        $where['uid']   = $this->uid;
        $where['token'] = $this->auth_user['token'];
        db('member_token')->where($where)->delete();
        // 删除session
        Session::clear('home');
    }
}

 ?>