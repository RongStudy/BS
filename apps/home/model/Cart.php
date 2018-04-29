<?php 
namespace app\home\model;
use think\Model;

class Cart extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_cart';

    /**
     * 获取购物车信息
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
    public function getCart($map){
    	return \think\Db::table($this->table)->where($map)->select();
    }
}


 ?>