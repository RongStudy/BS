<?php 
namespace app\admin\model;
use think\Model;

class Attach extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_attach';

    /**
     * [addPhoto 添加图片]
     * @param [type] $map [description]
     * @param [return] [自增ID]
     */
    public function addPhoto($map){
        return \think\Db::table($this->table)->insertGetId($map);
    }

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