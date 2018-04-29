<?php
namespace app\api\controller;
use think\Controller;

class Goods extends Controller{

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
                $this->error('失败');
            }
        }else{
            $this->error('系统错误，请稍候重试');
        }
    }
}
?>