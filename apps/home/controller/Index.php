<?php 
namespace app\home\controller;
use think\Db;

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

    /**
     * 文章详情
     */
    public function newsDetail(){
        if(!empty(session('home'))){
            $this->assign('info', session('home.user_auth'));
        }

        $newsModel = model('News');
        $id = input('id');
        
        if($id){
            $id = think_decrypt($id, config('url_key'));
        }else{
            $this->error('非法请求');
        }
        $data = $newsModel->where(['id'=>$id])->find();
        if($data['is_show'] != 1){
            $this->error('此文章不被展示', 'Index');
        }else{
            $newsModel->where(['id'=>$id])->setInc('show_count');
            $list = $newsModel->where(['is_show'=>1])->order('show_count desc')->select();
            $this->assign('list', $list);
            $this->assign('data', $data);
            return $this->fetch('news');
        }
    }
}

 ?>