<?php 
namespace app\admin\model;
use think\Model;

/**
 * 用户表
 */

class GoodsType extends Model{
    /**
     * 表名
     */
    protected $table = 'bs_goods_type';
    private $formatTree; //用于树型数组完成递归格式的全局变量

    /**
     * 获取数据库记录
     */
    public function getType($map = [], $field = '*'){
        $list = \think\Db::table($this->table)
                    ->where($map)
                    ->field($field)
                    ->select();
        return $list;
    }

    /**
     * 将menu菜单以tree的形式展示出来
     */
    public function getMenuTree(){
        $list = \think\Db::table($this->table)
                    ->where(['status'=>1])
                    ->order('id','asc')
                    ->select();
        return $list;
    }

    /**
     * 将格式数组转换为树
     *
     * @param array $list
     * @param integer $level 进行递归时传递用的参数
     */
    private function _toFormatTree($list,$level=0,$title = 'title') {
        foreach($list as $key=>$val){
            $tmp_str='┃'.str_repeat("&nbsp;&nbsp;┣",$level);
            $tmp_str.="";

            $val['level'] = $level;
            $val['title_show'] =$level==0?'┣'.$val[$title]."&nbsp;":$tmp_str.$val[$title]."&nbsp;";
            if(!array_key_exists('_child',$val)){
                array_push($this->formatTree,$val);
            }else{
                $tmp_ary = $val['_child'];
                unset($val['_child']);
                array_push($this->formatTree,$val);
                $this->_toFormatTree($tmp_ary,$level+1,$title); //进行下一层递归
            }
        }
        return;
    }
    public function toFormatTree($list,$title = 'title',$pk='id',$pid = 'pid',$root = 0){
        $list = list_to_tree($list,$pk,$pid,'_child',$root);
        $this->formatTree = array();
        $this->_toFormatTree($list,0,$title);
        return $this->formatTree;
    }

}


 ?>