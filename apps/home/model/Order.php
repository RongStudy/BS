<?php 
namespace app\home\model;
use think\Model;

class Order extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_order';

    /**
     * [addOrder 插入订单]
     * @param [type] $data [description]
     */
    public function addOrder($data){
        return \think\Db::table($this->table)->insert($data);
    }

    /**
     * 获取订单信息
     */
    public function getOrder($map, $order='id desc'){
        return \think\Db::table($this->table)->where($map)->order($order)->find();
    }
    public function getOrder2($map){
        return \think\Db::table($this->table)->where($map)->find();
    }

    public function getOrderPage($map, $order='id desc'){
        return \think\Db::table($this->table)->where($map)->order($order)->paginate(10);
    }
    
}


 ?>