<?php 
namespace app\admin\controller;

class Member extends Base{
	/**
	 * 用户列表
	 */
	public function memberList(){
		$minTime = strtotime(input('datemin'));
		$maxTime = strtotime(input('datemax'));
		$type 	 = input('type') ? $type : '';
		$list = model('AuthMember')->selectMap($minTime, $maxTime, $type);
		dump(model('AuthMember')->getLastSql());
		$this->assign('list', $list);
		return $this->fetch();
	}
}

 ?>