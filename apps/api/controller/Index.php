<?php
namespace app\api\controller;
use think\Controller;

class Index extends Controller{
    public function getAll(){
    	$goods = model('Goods')->getAll();
    	$goods_type = model('GoodsType')->getAll();

    	dump($goods);
    }
}


?>