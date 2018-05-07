<?php 
namespace app\home\model;
use think\Model;

class Goods extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_goods';

    public function findPid($map){
        return \think\Db::table($this->table)->where($map)->getField('pid');
    }

    /**
     * 获取商品详情
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
    public function getFind($map){
    	return \think\Db::table($this->table)->where($map)->find();
    }

    /**
     * 获取购物车的商品信息
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
    public function getCartInfo($map, $field){
        return \think\Db::table($this->table)->field($field)->where($map)->select();
    }

    public function getSearch($map, $field = '*'){
        return \think\Db::table($this->table)->field($field)->where($map)->select();
    }

    public function getSearchOrder($order, $map, $field = '*'){
        return \think\Db::table($this->table)->field($field)->where($map)->order($order)->select();
    }

    // 更新库存
    public function updateInvertory($where, $gInvertory){
        return \think\Db::table($this->table)->where($where)->update(['gInvertory'=>$gInvertory]);
    }
}


 ?>