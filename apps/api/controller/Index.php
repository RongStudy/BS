<?php
namespace app\api\controller;
use think\Controller;

class Index extends Controller{

    /**
     * 楼层信息及商品
     * @return [type] [description]
     */
    public function getFloor(){

    	$goods = model('Goods')->getAll();
    	$tempImg = [];
        $goods_type = model('GoodsType')->getAll();
        // print_r($goods_type);
    	// $goods_type = model('GoodsType')->getAll(array('pid'=>array));
    	
        // 获取商品缩略图(每个商品一张)
        foreach ($goods as $key => $value) {
    		$tempImgId[] = explode(',', $value['gImg'])[0];
            $goods[$key]['imgId'] = explode(',', $value['gImg'])[0];
    	}
        rsort($tempImgId);
        $tempImgId2 = $tempImgId;
    	$tempImgId = implode(',', $tempImgId);
    	$goodsImg = model('Attach')->getPhoto(['id'=>['in', $tempImgId]]);
    	$img = photoPath($goodsImg ,1);
        $img2 = array_combine($tempImgId2, $img);
        foreach ($img2 as $key => $value) {
            foreach ($goods as $k => $v) {
                if($v['imgId'] == $key){
                    $goods[$k]['thumb'] = $value;
                }
            }
        }
    	return json(array('status'=>'1', 'data'=>array('goods'=>$goods, 'goods_type'=>$goods_type)));
    }

    /**
     * 商品种类
     * @return [type] [description]
     */
    public function getType(){
        $goodsTypeModel = model('GoodsType');
        $list = $goodsTypeModel->getAll();
        
        $up_type = array();
        $down_type = array();
        foreach ($list as $key => $value) {
            if($value['pid'] == 0){
                $up_type[] = $value;
            }else{
                $down_type[] = $value;
            }
        }

        return json(
            array(
                'status'=>'1',
                'data'=>array(
                    'up_type'=>$up_type,
                    'down_type'=>$down_type,
                ),
            )
        );
    }
}


?>