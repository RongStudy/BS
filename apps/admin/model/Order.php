<?php 
namespace app\admin\model;
use think\Model;

class Order extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_order';

    /**
     * 获取订单
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
    public function getOrderInfo($map){
        return \think\Db::table($this->table)->where($map)->paginate(10);
    }
    

    /**
     * 发货
     * @param  [type] $map  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function sendOrder($id, $data){
        return \think\Db::table($this->table)->where(array('id'=>$id))->update($data);
    }
    
}


 ?>