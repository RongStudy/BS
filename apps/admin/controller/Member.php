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
	    $this->assign('count', count($list));
	    return $this->fetch();
	}

    /**
     * 用户启用禁用
     */
    public function setStatus(){
        $type   = input('type');    // 区分状态        1：恢复     2：删除/禁用
        $method = input('method');  // 区分启禁、删除  1：启用禁用 2：删除
        $info = '';
        if($method == 1){
            $map['status'] = $type;
            $info = ($type == 2) ? '禁用' : '启用';
        }else if($method == 2){
            $map['is_remove'] = $type;
            $info = ($type == 2) ? '删除用户' : '恢复用户';
        }
        $res = model('AuthMember')->setStatus($map, input('ids'));
        if($res){
            $this->success($info.'成功');
        }else{
            $this->error($info.'失败');
        }
    }
}

 ?>