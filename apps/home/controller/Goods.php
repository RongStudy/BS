<?php 
namespace app\home\controller;

class Goods extends Base{

    public function init(){
        if(!empty(session('home'))){
            $this->assign('info', session('home.user_auth'));
        }
        // 获取全部商品种类
        $type = goods_type();
        $this->assign('up_type', $type['up_type']);
        $this->assign('down_type', $type['down_type']);
    }

    /**
     * 商品列表
     */
    public function goodsList(){
        $goodsModel = model('Goods');

        $goods_type_id = input('type');    // 获取传入的商品类型

        $checkType = $goodsModel->findPid(array('id'=>$goods_type_id)); // 检测是否有下级种类

        if($checkType == 0){
        }
    }

    /**
     * 商品详情
     * @return [type] [description]
     */
    public function goodsDetail(){
        $this->init();

        $gid = input('gid');
        if($gid){
            $goodsModel  = model('goods');
            $attachModel = model('Attach');

            // 获取商品信息
            $goods_data = $goodsModel->getFind(array('gid'=>$gid));
            $this->assign('goods_data', $goods_data);

            // 获取商品对应的图片信息
            $img_id = $goods_data['gImg'];
            $map['id'] = array('in', $img_id);
            $img_data  = $attachModel->getGoodsImg($map);
            $img_true_path  = photoPath($img_data, 2);          // 原图
            $img_thumb_path = photoPath($img_data, 1);          // 缩略图
            
            $this->assign('img_path', $img_true_path);
            $this->assign('img_thumb_path', $img_thumb_path);
        }else{
            $this->error('系统出错,请稍后重试');
        }
        return $this->fetch();
    }

    /**
     * 添加购物车
     */
    public function addCart(){
        $data = input('');
        $data['addtime'] = time();
        $data['uid'] = $this->uid;
        if(model('Cart')->insert($data)){
            $this->success('添加购物车成功');
        }else{
            $this->error('添加购物车失败');
        }
    }

    /**
     * 购物车列表
     * @return [type] [description]
     */
    public function listCart(){
        $this->init();
        $list = model('Cart')->getCart(array('uid'=>$this->uid, 'order_status'=>0));   // 获取购物车信息
        $gid  = array_column($list, 'gid');  // 获取商品id
        $gid  = implode(',', $gid);
        $field = 'gid, gTitle, gUnit';

        $goods_data = model('Goods')->getCartInfo(array('gid'=>array('in', $gid)), $field);
        $this->assign('list', $list);
        $this->assign('goods_data', $goods_data);
        return $this->fetch('cart');
    }

    /**
     * 搜索商品
     * @return [type] [description]
     */
    public function searchList(){
        $this->init();
        $search = input('search_input');
        $type   = input('type');
        $goodsModel = model('Goods');
        $price_order = input('price');
        $order  ='';
        if($price_order){
            $order = array('gPrice');
            if($type){
                $map['gType']  = array('eq', $type);
            }else{
                $map['gTitle'] = array('like', '%'.input('search').'%');
            }
        }else if($search!=''){
            $map['gTitle'] = array('like', '%'.$search.'%');
        }else if($type!=''){
            $map['gType'] = array('eq', $type);
        }
        if($order){
            $list = $goodsModel->getSearchOrder($order, $map);
        }else{
            $list = $goodsModel->getSearch($map);
        }
        

        // 获取商品图片
        $img = array_column($list, 'gImg');
        $imgArr = array();
        foreach ($img as $key => $value) {
            $imgArr[] = explode(',', $img[$key])[0];
        }
        $imgArr = implode(',', $imgArr);
        $img = model('Attach')->getGoodsImg(array('id'=>array('in', $imgArr)));
        $img_thumb = photoPath($img);
        
        $this->assign('list', $list);
        $this->assign('search', $search);
        $this->assign('type', $type);
        $this->assign('img_thumb', $img_thumb);
        $this->assign('no_show_order', '1');

        return $this->fetch();
    }

    /**
     * [payment 生成订单]
     * @return [type] [description]
     */
    public function payment(){
        $data = input('');
        $cart_id = $data['cart_id'];
        unset($data['cart_id']);
        if($data){
            $data['uid'] = $this->uid;
            $data['order_sn'] = 'sn_'.timeStr().make_random(3, false);
            $data['pay_status'] = 0;
            $data['send_status'] = 0;
            $data['addtime'] = time();
            if(model('Order')->addOrder($data) && model('Cart')->where(array('id'=>array('in', $cart_id)))->update(array('order_status'=>1))){
                $this->success('成功');
            }else{
                $this->error('系统错误，请稍候重试');
            }
        }else{
            $this->error('系统错误，请稍候重试');
        }
    }

    public function sureOrder(){
        if(request()->isPost()){
            $order_id  = input('order_id');
            $map['pay_name'] = input('pay_name');
            $map['message']  = input('message');
            $map['pay_status']  = '1';
            if(model('Order')->where(array('id'=>$order_id))->update($map)!==false){
                $this->success('付款成功');
            }else{
                $this->error('付款失败');
            }
        }else{
            $this->init();

            // 最新生成的订单
            $orderMap['uid'] = $this->uid;
            $orderData = model('Order')->getOrder($orderMap, 'id desc');

            $gid = $orderData['gid']; // 商品id
            $count = $orderData['count']; //商品数量
            $total_price = $orderData['total_price']; //商品小计
            $all_price = $orderData['all_price']; //商品总计

            $goodsList = model('Goods')->getSearch(array('gid'=>array('in', $gid)), 'gTitle, gUnit, gImg');
            
            $goodsImg = array();
            foreach ($goodsList as $key => $value) {
                $goodsImg[] = explode(',', $value['gImg'])[0];
            }
            $goodsImg = implode(',', $goodsImg);
            $img = model('Attach')->getGoodsImg(array('id'=>array('in', $goodsImg)));
            $img_thumb_path = photoPath($img);

            $count = explode(',', $count);
            $total_price = explode(',', $total_price);

            foreach ($goodsList as $key => $value) {
                $goodsList[$key]['count'] = $count[$key];
                $goodsList[$key]['img_path'] = $img_thumb_path[$key];
                $goodsList[$key]['total_price'] = $total_price[$key];
            }
            // dump($orderData['id']);
            $this->assign('orderid',  $orderData['id']);
            $this->assign('goodsList', $goodsList);
            $this->assign('all_price', $all_price);

            // 收货地址
            $addressList = model('Address')->where(['uid'=>$this->uid])->select();
            $this->assign('address',$addressList);
            
            return $this->fetch();
        }
    }

    /**
     * 结束订单
     * @return [type] [description]
     */
    public function finishOrder(){
        $this->init();

        $orderMap['uid'] = $this->uid;
        $orderData = model('Order')->getOrder($orderMap, 'id desc');
        $pay_name  = array('余额支付','货到付款','支付宝');

        $this->assign('pay_name', $pay_name);
        $this->assign('orderData', $orderData);
        return $this->fetch();
    }

    /**
     * 我的订单
     */
    public function myOrder(){
        if(request()->isPost()){
            $order_id = input('order_id');
            if(model('Order')->where(array('id'=>$order_id))->update(array('send_status'=>2))!==false){
                $this->success('收获成功');
            }else{
                $this->error('系统出错，请重试');
            }
        }else{
            $this->init();

            $orderData = model('Order')->getOrderPage(array('uid'=>$this->uid));
            $pay_name = ['余额支付', '货到付款', '支付宝']; // 支付方式
            $send_status= ['待发货', '已发货', '已收货'];  // 发货状态

            $this->assign('pay_name', $pay_name);
            $this->assign('orderData', $orderData);
            $this->assign('send_status', $send_status);
            
            $this->assign('no_show_order', '1');
            return $this->fetch();
        }
    }
}

 ?>