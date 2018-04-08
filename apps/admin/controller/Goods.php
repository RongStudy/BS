<?php
namespace app\admin\controller;


class Goods extends Base{
    /**
     * 添加商品
     */
    public function addGoods(){
        $code = 0;
        $msg  = '非法访问';
        $model = model('GoodsType');
        if(request()->isPost()){
            $uid = $this->uid;
            $map = input();
            $map['uid'] = $uid;
            $map['addTime'] = time();
            $res = model('Goods')->addGoods($map);
            if($res){
                $code = 1;
                $msg  = '添加成功';
            }else{
                $code = 0;
                $msg  = '添加失败';
            }
            return json(array('code'=>$code, 'msg'=>$msg));
        }else{
            $map = [];
            $field = 'id, title';
            $goodsType = $model->getType($map, $field);
            $this->assign('data', $goodsType);
            return $this->fetch();
        }
    }

    /**
     * 添加商品种类
     */
    public function addGoodsType(){
        $model = model('GoodsType');
        if(request()->isPost()){
            $map = [];
            $map['pid']   = input('typeUp');
            $map['title'] = input('typeName');
            $map['sort'] = input('typeSort');
            $map['addtime'] = time();

            /**
             * 验证是否重复
             */
            $obj = $model->getType(array('title'=>input('typeName')));
            if($obj){
                return json(array('code'=>0, 'msg'=>'已存在此种类'));
            }
            if($map){
                $res = $model->save($map);
                if($res){
                    return json(array('code'=>1, 'msg'=>'添加成功'));
                }else{
                    return json(array('code'=>0, 'msg'=>'添加失败'));
                }
            }
        }else{
            $tree = $model->getMenuTree();
            $data = $model->toFormatTree($tree);
            $this -> assign('allType', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除商品
     * @return [type] [description]
     */
    public function del(){
        return $this->fetch();
    }

    /**
     * 商品列表
     */
    public function listGoods(){
        // 获取商品
        $field = 'gid,gTitle,gType,gUnit,gPrice';
        $map = [];
        $title = input('gName');
        if($title){
            $map['gTitle'] = !empty($title)?array('like', '%'.$title.'%'):'';
        }
        $list  = model('Goods')->getAll(10, $field, $map);
        // echo model('Goods')->getLastSql();die;
        // 获取商品类型
        $gType = model('GoodsType')->getType($map = [], 'id,title');

        $count = count($list);
        $this->assign('count', $count);
        $this->assign('list', $list);
        $this->assign('gType', $gType);
        // print_r($list);die;
        return $this->fetch();
    }

    /**
     * 商品详情
     */
    public function goodsDetail(){
        $gid = input('gids');
        if($gid){
            // 获取商品
            $list  = model('Goods')->getOne(array('gid'=>$gid));
            // 获取商品类型
            $gType = model('GoodsType')->getType($map = [], 'id,title');

            // 图片
            $map['id'] = array('in', explode(',', $list['gImg']));
            $res = model('Attach')->getPhoto($map);
            $imgThumb = photoPath($res, 1);     // 缩略图
            // dump($imgThumb);die;
            $imgClarity = photoPath($res, 2);   // 原图
            $this->assign('list', $list);
            $this->assign('gType', $gType);
            $this->assign('imgThumb', $imgThumb);
            $this->assign('imgClarity', $imgClarity);
            return $this->fetch();
        }else{
            $this->error('非法请求，请稍候重试');
        }
    }

    /**
     * 编辑商品
     */
    public function goodEdit(){
        $gid = input('gid');
        if(request()->isPost()){}else{
            $goods = model('Goods')->getOne(array('gid'=>$gid));
            $goodsType = model('GoodsType')->getType([], 'id, title');
            $map['id'] = array('in', $goods['gImg']);
            $img = model('Attach')->getPhoto($map);
            $goodsImages = photoPath($img, 1);          // 获取缩略图
            $goodsImagesClarity = photoPath($img, 2);   // 获取大图
            $this->assign('img', $img);
            $this->assign('goods', $goods);
            $this->assign('data', $goodsType);
            $this->assign('goodsImages', $goodsImages);
            $this->assign('goodsImagesClarity', $goodsImagesClarity);
            return $this->fetch('addGoods');
        }
    }
}

 ?>