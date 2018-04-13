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


    /**
     * 测试layuiTable
     * @return [type] [description]
     */
    public function layuiTable(){
        return $this->fetch();
    }
    public function retinfo(){
        $info = '{"code":0,"msg":"","count":1000,"data":[{"id":10000,"username":"user-0","sex":"女","city":"城市-0","sign":"签名-0","experience":255,"logins":24,"wealth":82830700,"classify":"作家","score":57},{"id":10001,"username":"user-1","sex":"男","city":"城市-1","sign":"签名-1","experience":884,"logins":58,"wealth":64928690,"classify":"词人","score":27},{"id":10002,"username":"user-2","sex":"女","city":"城市-2","sign":"签名-2","experience":650,"logins":77,"wealth":6298078,"classify":"酱油","score":31},{"id":10003,"username":"user-3","sex":"女","city":"城市-3","sign":"签名-3","experience":362,"logins":157,"wealth":37117017,"classify":"诗人","score":68},{"id":10004,"username":"user-4","sex":"男","city":"城市-4","sign":"签名-4","experience":807,"logins":51,"wealth":76263262,"classify":"作家","score":6},{"id":10005,"username":"user-5","sex":"女","city":"城市-5","sign":"签名-5","experience":173,"logins":68,"wealth":60344147,"classify":"作家","score":87},{"id":10006,"username":"user-6","sex":"女","city":"城市-6","sign":"签名-6","experience":982,"logins":37,"wealth":57768166,"classify":"作家","score":34},{"id":10007,"username":"user-7","sex":"男","city":"城市-7","sign":"签名-7","experience":727,"logins":150,"wealth":82030578,"classify":"作家","score":28},{"id":10008,"username":"user-8","sex":"男","city":"城市-8","sign":"签名-8","experience":951,"logins":133,"wealth":16503371,"classify":"词人","score":14},{"id":10009,"username":"user-9","sex":"女","city":"城市-9","sign":"签名-9","experience":484,"logins":25,"wealth":86801934,"classify":"词人","score":75},{"id":10010,"username":"user-10","sex":"女","city":"城市-10","sign":"签名-10","experience":1016,"logins":182,"wealth":71294671,"classify":"诗人","score":34},{"id":10011,"username":"user-11","sex":"女","city":"城市-11","sign":"签名-11","experience":492,"logins":107,"wealth":8062783,"classify":"诗人","score":6},{"id":10012,"username":"user-12","sex":"女","city":"城市-12","sign":"签名-12","experience":106,"logins":176,"wealth":42622704,"classify":"词人","score":54},{"id":10013,"username":"user-13","sex":"男","city":"城市-13","sign":"签名-13","experience":1047,"logins":94,"wealth":59508583,"classify":"诗人","score":63},{"id":10014,"username":"user-14","sex":"男","city":"城市-14","sign":"签名-14","experience":873,"logins":116,"wealth":72549912,"classify":"词人","score":8},{"id":10015,"username":"user-15","sex":"女","city":"城市-15","sign":"签名-15","experience":1068,"logins":27,"wealth":52737025,"classify":"作家","score":28},{"id":10016,"username":"user-16","sex":"女","city":"城市-16","sign":"签名-16","experience":862,"logins":168,"wealth":37069775,"classify":"酱油","score":86},{"id":10017,"username":"user-17","sex":"女","city":"城市-17","sign":"签名-17","experience":1060,"logins":187,"wealth":66099525,"classify":"作家","score":69},{"id":10018,"username":"user-18","sex":"女","city":"城市-18","sign":"签名-18","experience":866,"logins":88,"wealth":81722326,"classify":"词人","score":74},{"id":10019,"username":"user-19","sex":"女","city":"城市-19","sign":"签名-19","experience":682,"logins":106,"wealth":68647362,"classify":"词人","score":51},{"id":10020,"username":"user-20","sex":"男","city":"城市-20","sign":"签名-20","experience":770,"logins":24,"wealth":92420248,"classify":"诗人","score":87},{"id":10021,"username":"user-21","sex":"男","city":"城市-21","sign":"签名-21","experience":184,"logins":131,"wealth":71566045,"classify":"词人","score":99},{"id":10022,"username":"user-22","sex":"男","city":"城市-22","sign":"签名-22","experience":739,"logins":152,"wealth":60907929,"classify":"作家","score":18},{"id":10023,"username":"user-23","sex":"女","city":"城市-23","sign":"签名-23","experience":127,"logins":82,"wealth":14765943,"classify":"作家","score":30},{"id":10024,"username":"user-24","sex":"女","city":"城市-24","sign":"签名-24","experience":212,"logins":133,"wealth":59011052,"classify":"词人","score":76},{"id":10025,"username":"user-25","sex":"女","city":"城市-25","sign":"签名-25","experience":938,"logins":182,"wealth":91183097,"classify":"作家","score":69},{"id":10026,"username":"user-26","sex":"男","city":"城市-26","sign":"签名-26","experience":978,"logins":7,"wealth":48008413,"classify":"作家","score":65},{"id":10027,"username":"user-27","sex":"女","city":"城市-27","sign":"签名-27","experience":371,"logins":44,"wealth":64419691,"classify":"诗人","score":60},{"id":10028,"username":"user-28","sex":"女","city":"城市-28","sign":"签名-28","experience":977,"logins":21,"wealth":75935022,"classify":"作家","score":37},{"id":10029,"username":"user-29","sex":"男","city":"城市-29","sign":"签名-29","experience":647,"logins":107,"wealth":97450636,"classify":"酱油","score":27}]}';
        $page  = input('page');
        $limit = input('limit');

        $info = json_decode($info, true);
        $count = count($info['data']);
        $limit = ($limit>$count) ? $count : $limit;

        $return = array();
        $return['code'] = 0;
        $return['msg']  = '';
        $return['count']= $count;

        $first  = ($page == 1) ? '0' : ($page-1)*$limit;
        $second = ($page == 1) ? ($limit-1) : ($first+$limit-1);
        $second = ($second <= $count) ? $second : $count-1;

        for($i=$first; $i<=$second; $i++){
            $return['data'][] = $info['data'][$i];
        }

        echo json_encode($return);
        
    }
}

 ?>



