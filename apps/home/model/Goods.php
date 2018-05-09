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

    /**
     * [getSearch 搜索商品]
     * @param  [type] $map   [description]
     * @param  string $field [description]
     * @return [type]        [description]
     */
    public function getSearch($map, $field = '*'){
        return \think\Db::table($this->table)->field($field)->where($map)->select();
    }

    /**
     * [getSearchOrder 有排序的搜索商品]
     * @param  [type] $order [description]
     * @param  [type] $map   [description]
     * @param  string $field [description]
     * @return [type]        [description]
     */
    public function getSearchOrder($order, $map, $field = '*'){
        return \think\Db::table($this->table)->field($field)->where($map)->order($order)->select();
    }

    /**
     * [updateInvertory 更新库存]
     * @param  [type] $where      [description]
     * @param  [type] $updateData [description]
     * @return [type]             [description]
     */
    public function updateInvertory($where, $updateData){
        return \think\Db::table($this->table)->where($where)->update($updateData);
    }

    /**
     * [getLike 获取当前分类下销量最高的两个商品]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    public function getLike($where){
        return \think\Db::table($this->table)->where($where)->order('sell_count desc')->limit(2)->select();
    }
}


 ?>
