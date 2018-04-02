<?php 
namespace app\home\controller;
use think\Controller;
use think\Request;
use think\Session;

class Login extends controller{
    public function checkLogin($map){
    	$map = [];
    	$map['username'] = $map['uName'];
    	$map['password'] = cthink_md5($map['uPwd']);
        $map['user_type'] = '3';
        return $map;
    }
}

 ?>