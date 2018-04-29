<?php
namespace app\admin\controller;

/**
 * 订单
 */
class Order extends Base{
    public function listOrder(){
        $map = array();
        $orderList = model('Order')->getOrderInfo($map);

        $this->assign('pay_name', config('pay_name'));
        $this->assign('send_status', config('send_status'));
        $this->assign('orderList', $orderList);
        return $this->fetch();
    }

    public function send(){
        $id = input('order_id');

        $data['send_status'] = 1;
        $data['send_time']   = time();
        if(model('Order')->sendOrder($id, $data)!==false){
            $this->success('发货成功');
        }else{
            $this->error('发货失败');
        }
    }
}

 ?>