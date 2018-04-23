<?php
namespace app\api\controller;
use think\Controller;

class Index extends Controller{
    public function getFloor(){
    	$goods = model('Goods')->getAll();
    	// $goods['gImg'];
    	$tempImg = [];
    	$goods_type = model('GoodsType')->getAll();
    	foreach ($goods as $key => $value) {
    		$tempImg[] = explode(',', $value['gImg'])[0];
    	}
    	
    	$tempImg = implode(',', $tempImg);
    	// dump($tempImg);die;
    	$goodsImg = model('Attach')->getPhoto(['id'=>['in', $tempImg]]);
    	foreach ($goodsImg as $key => $value) {
    		$goods[]
    	}
    	return json(array('status'=>'1', 'data'=>array('goods'=>$goods, 'goods_type'=>$goods_type)));
    }
}


?>