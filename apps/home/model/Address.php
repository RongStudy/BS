<?php 
namespace app\home\model;
use think\Model;

class Address extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_address';

    /**
     * 获取用户的收货地址
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
    public function getAddress($map){
    	return \think\Db::table($this->table)->where($map)->select();
    }

    /**
     * 修改地址
     */
    public function editAddress($map, $data){
    	return \think\Db::table($this->table)->where($map)->update($data);
    }
}


 ?>