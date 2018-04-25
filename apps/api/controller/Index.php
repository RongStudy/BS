<?php
namespace app\api\controller;
use think\Controller;

class Index extends Controller{
    public function getFloor(){
    	$goods = model('Goods')->getAll();
    	$tempImg = [];
    	$goods_type = model('GoodsType')->getAll();
    	
        // 获取商品缩略图(每个商品一张)
        foreach ($goods as $key => $value) {
    		$tempImg[] = explode(',', $value['gImg'])[0];
    	}
    	$tempImg = implode(',', $tempImg);
    	$goodsImg = model('Attach')->getPhoto(['id'=>['in', $tempImg]]);
    	$img = photoPath($goodsImg ,1);

    	return json(
            array(
                'status'=>'1', 
                'data'=>array(
                    'img'=>$img,
                    'goods'=>$goods, 
                    'goods_type'=>$goods_type
                )
            )
        );
    }
}


?>