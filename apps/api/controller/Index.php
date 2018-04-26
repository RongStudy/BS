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
    		$tempImgId[] = explode(',', $value['gImg'])[0];
            $goods[$key]['imgId'] = explode(',', $value['gImg'])[0];
    	}
        rsort($tempImgId);
        $tempImgId2 = $tempImgId;
        // dump($tempImgId);

    	$tempImgId = implode(',', $tempImgId);
    	$goodsImg = model('Attach')->getPhoto(['id'=>['in', $tempImgId]]);
    	$img = photoPath($goodsImg ,1);
        // dump($img);

        $img2 = array_combine($tempImgId2, $img);
        foreach ($img2 as $key => $value) {
            foreach ($goods as $k => $v) {
                if($v['imgId'] == $key){
                    $goods[$k]['thumb'] = $value;
                }
            }
        }
    	return json(
            array(
                'status'=>'1', 
                'data'=>array(
                    'goods'=>$goods, 
                    'goods_type'=>$goods_type
                )
            )
        );
    }
}


?>