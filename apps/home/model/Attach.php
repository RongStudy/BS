<?php 
namespace app\home\model;
use think\Model;

class Attach extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_attach';

    public function getGoodsImg($map){
        return \think\Db::table($this->table)->where($map)->select();
    }
    
}


 ?>