<?php 
namespace app\api\model;
use think\Model;

class Goods extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_goods';

    /**
     * 获取所有商品
     */
    public function getAll(){
        return \think\Db::table($this->table)->select();
    }
    
}


 ?>