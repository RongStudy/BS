<?php 
namespace app\home\controller;

class Index extends Base{
    public function index(){
    	if(!empty(session('home'))){
    		$this->assign('info', session('home.user_auth'));
    	}
        return $this->fetch();
    }
}

 ?>