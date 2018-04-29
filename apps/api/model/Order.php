<?php 
namespace app\api\model;
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
    
}


 ?>