<?php
namespace app\home\model;
use think\Model;

class GoodsType extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_goods_type';

    /**
     * 获取商品类型
     */
    public function getAll($map = array()){
        return \think\Db::table($this->table)->where($map)->select();
    }

    /**
     * [getPid 获取父pid]
     * @param  array  $map [description]
     * @return [type]      [description]
     */
    public function getPid($map = array()){
        return \think\Db::table($this->table)->where($map)->column('pid');
    }

}


 ?>
