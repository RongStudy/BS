<?php 
namespace app\admin\controller;
use think\Controller;

class Test extends controller{
    public function index(){
        $arr = array('32', '43', '1', '0', '45');
        $len = count($arr);

        $fun = 'quickSort';
        
        switch ($fun) {
            case 'insertSort':
                $arr = $this->insertSort($arr, $len);
                break;
            case 'bubbleSort':
                $arr = $this->bubbleSort($arr, $len);
                break;
            case 'selectSort':
                $arr = $this->selectSort($arr, $len);
                break;
            case 'quickSort':
                $arr = $this->quickSort($arr, $len);
                break;
            default:
                $arr = '默认方法';
                break;
        }
        array_unshift($arr, $fun);
        dump($arr);
    }

    /**
     * [insertSort 插入排序]
     * @param  [type] $arr [待排序集合]
     * @param  [type] $len [待排序集合长度]
     * @return [type]      [返回排序完成的集合]
     */
    public function insertSort($arr, $len){
        $j=0;$i=0;$key;

        for($i=1; $i<$len; $i++){
            $key = $arr[$i];
            $j   = $i-1;
            while($j>=0 && $key<=$arr[$j]){
                $arr[$j+1] = $arr[$j];
                $j--;
            }
            $arr[$j+1] = $key;
        }
        return $arr;
    }

    /**
     * [bubbleSort 冒泡排序]
     * @param  [type] $arr [待排序集合]
     * @param  [type] $len [待排序集合长度]
     * @return [type]      [返回排序完成的集合]
     */
    public function bubbleSort($arr, $len){
        for($i=0; $i<$len; $i++){
            for($j=0; $j<$len; $j++){
                if($arr[$i]<$arr[$j]){
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$i];
                    $arr[$i] = $temp;
                }
            }
        }
        return $arr;
    }

    /**
     * [selectSort 简单选择排序]
     * @param  [type] $arr [待排序集合]
     * @param  [type] $len [待排序集合长度]
     * @return [type]      [返回排序完成的集合]
     */
    public function selectSort($arr, $len){
        for($i=0; $i<$len-1; $i++){
            $k=$i;
            for($j=$i+1; $j<$len; $j++){
                if($arr[$j]<$arr[$k]){
                    $k = $j;
                }
            }
            if($i != $k){
                $temp    = $arr[$i];
                $arr[$i] = $arr[$k];
                $arr[$k] = $temp;
            }
        }
        return $arr;
    }

    /**
     * [quickSort description]
     * @param  [type] $arr   [待排序集合]
     * @param  [type] $left  [左边界]
     * @param  [type] $right [右边界]
     * @return [type]        [description]
     */
    // public function quickSort($arr, $left, $right){
    //     $mid;
    //     if( $left<$right ){
    //         $mid = $this->partition($arr, $left, $right);
    //         $this->quickSort($arr, $left, $mid-1);
    //         $this->quickSort($arr, $mid+1, $right);
    //     }
    //     return $arr;
    // }

    /**
     * [partition description]
     * @param  [type] $arr   [待分割数组]
     * @param  [type] $left  [左边界]
     * @param  [type] $right [右边界]
     * @return [type]        [description]
     */
    // public function partition($arr, $left, $right){
    //     $i; $j; $mid; $temp;
    //     for( $i=$left-1,$j=$left; $j<$right; $j++ ){
    //         if( $arr[$right]>$arr[$j] ){
    //             $i++;
    //             if( $i != $j ){
    //                 $temp    = $arr[$j];
    //                 $arr[$j] = $arr[$i];
    //                 $arr[$i] = $temp;
    //             }
    //         }
    //     }
    //     $i++;
    //     $temp        = $arr[$right];
    //     $arr[$right] = $arr[$i];
    //     $arr[$i]     = $temp;
    //     return $i;
    // }
    function quickSort($arr, $len){
        // if(count($arr)>1){
        //     $k=$arr[0];
        //     $x=array();
        //     $y=array();
        //     $_size=count($arr);
        //     for($i=1;$i<$_size;$i++){
        //         if($arr[$i]<=$k){
        //             $x[]=$arr[$i];
        //         }elseif($arr[$i]>$k){
        //             $y[]=$arr[$i];
        //         }
        //     }

        //     $x=$this->quickSort($x);
        //     $y=$this->quickSort($y);
        //     return array_merge($x,array($k),$y);
        // }else{
        //     return $arr;
        // }
        // 
        if($len>1){
            $k = $arr[0];
            $left = array();
            $right = array();
            for( $i=1; $i<$len; $i++ ){
                if( $arr[$i]<=$k ){
                    $left[]  = $arr[$i];
                }else{
                    $right[] = $arr[$i];
                }
            }
            $left = $this->quickSort($left, count($left));
            $right = $this->quickSort($right, count($right));
            return array_merge( $left, array($k), $right);
        }else{
            return $arr;
        }
    }

    public function test(){
        $str = '这是，哈哈,来来来';
        dump(str_replace(',', '，', $str));
    }

    /**
     * layui图片上传
     */
    public function uploadPhoto(){
        if(request()->isPost()){
            return json(array('code'=>1,',msg'=>'测试'));
        }else{
            return $this->fetch();
        }
        
    }

    public function demo(){
        return $this->fetch();
    }
}

 ?>



