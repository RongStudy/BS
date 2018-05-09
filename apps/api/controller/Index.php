<?php
namespace app\api\controller;
use think\Controller;

class Index extends Controller{

    /**
     * 楼层信息及商品
     * @return [type] [description]
     */
    public function getFloor(){
        $getMap['is_sell'] = 1;
    	$goods = model('Goods')->getAll($getMap);
    	$tempImg = [];
        $goods_type = model('GoodsType')->getAll();
        // print_r($goods_type);
    	// $goods_type = model('GoodsType')->getAll(array('pid'=>array));

        // 获取商品缩略图(每个商品一张)
        foreach ($goods as $key => $value) {
    		$tempImgId[] = explode(',', $value['gImg'])[0];
            $goods[$key]['imgId'] = explode(',', $value['gImg'])[0];
    	}
        $tempImgId2 = $tempImgId;
    	$tempImgId = implode(',', $tempImgId);
    	$goodsImg = model('Attach')->getPhoto(['id'=>['in', $tempImgId]]);
    	$img = photoPath2($goodsImg ,1);

        foreach ($goods as $key => $value) {
            foreach ($img as $k => $v) {
                if($v['img_id'] == $value['imgId']){
                    $goods[$key]['thumb'] = $v['thumb_p'];
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
