<?php 
namespace app\api\model;
use think\Model;

class Attach extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_attach';

    /**
     * 获取指定图片
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
    public function getPhoto($map){
        return \think\Db::table($this->table)->where($map)->select();
    }
}


 ?>