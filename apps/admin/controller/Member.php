<?php 
namespace app\admin\controller;

class Member extends Base{
	/**
	 * 用户列表
	 */
	public function memberList(){
        $map = [];
        $user_type = input('user_type');
        $userName  = input('username');
        $dateMin   = input('dateMin') ? strtotime(input('dateMin')) : '';
        $dateMax   = input('dateMax') ? strtotime(input('dateMax')) : time();
	    if($userName){
	        $map['username'] = $userName;
        }
        if($dateMin || $dateMax){
	        $map['ctime'] = array('between', array($dateMin, $dateMax));
        }
        if($user_type){
            $map['user_type'] = $user_type;
        }
        $list = model('AuthMember')->searchMember($map);
	    $this->assign('list', $list);
	    return $this->fetch();
	}
}

 ?>