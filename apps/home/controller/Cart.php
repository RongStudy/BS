<?php 
namespace app\home\controller;

class Cart extends Base{
    
    /**
     * [delOrder 删除购物车订单]
     * @return [type] [description]
     */
    public function delCart(){
        $map = array();
        $cart_id = input('id');
        $map['uid'] = $this->uid;
        $res = '';
        if($cart_id!=''){
            if($cart_id == 0){
                $res = model('Cart')->where($map)->delete();
            }else{
                $map['id'] = $cart_id;
                $res = model('Cart')->where($map)->delete();
            }
            if($res){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('系统错误，请稍候重试');
        }
    }
}

 ?>