<?php 
namespace app\admin\model;
use think\Model;

class Goods extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_goods';

    /**
     * 添加商品
     */
    public function addGoods($map){
        $data = \think\Db::table($this->table)->insert($map);
        return $data;
    }

    /**
     * 获取所有商品
     */
    public function getAll($field='*', $map){
        $data = \think\Db::table($this->table)->field($field)->where($map)->select();
        return $data;
    }

    /**
     * 获取商品详情
     */
    public function getOne($map){
        return \think\Db::table($this->table)->find($map);
    }
    
}


 ?>