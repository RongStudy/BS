<?php 
namespace app\home\controller;

class Index extends Base{
    public function index(){
    	if(!empty(session('home'))){
    		$this->assign('info', session('home.user_auth'));
    	}

        // 获取商品种类
    	$type = goods_type();
        $this->assign('up_type', $type['up_type']);
        $this->assign('down_type', $type['down_type']);

        $list = model('Cart')->getCart(array('uid'=>$this->uid, 'order_status'=>0));   // 获取购物车信息
        $gid  = array_column($list, 'gid');  // 获取商品id
        $gid  = implode(',', $gid);
        $field = 'gid, gTitle, gUnit';
        $goods_data = model('Goods')->getCartInfo(array('gid'=>array('in', $gid)), $field);
        $this->assign('list', $list);
        $this->assign('goods_data', $goods_data);
        return $this->fetch();
    }

    public function news(){
        if(!empty(session('home'))){
            $this->assign('info', session('home.user_auth'));
        }
        return $this->fetch();
    }
}

 ?>