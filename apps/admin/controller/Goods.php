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
            $map = array();
            $field = 'id, title';
            $goodsType = $model->getType($this->uid, '', $map, $field);
            $this->assign('data', $goodsType);
            return $this->fetch();
        }
    }

    /**
     * 编辑商品
     */
    public function editGoods(){
        if(request()->isPost()){
            $where['gid'] = input('gid');
            $map = input();
            unset($map['gid']);
            if($map['gImg'] == ''){
                unset($map['gImg']);
            }
            if(model('Goods')->editGoods($where, $map)!==false){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $gid = input('gid');
            $goods = model('Goods')->getOne(array('gid'=>$gid));
            $goodsType = model('GoodsType')->getType($this->uid, '', array(), 'id, title');
            $map['id'] = array('in', $goods['gImg']);
            $img = model('Attach')->getPhoto($map);
            $goodsImages = photoPath($img, 1);          // 获取缩略图
            $goodsImagesClarity = photoPath($img, 2);   // 获取大图
            
            $this->assign('img', $goods['gImg']);
            $this->assign('goods', $goods);
            $this->assign('data', $goodsType);
            $this->assign('edit', $goods['gid']);
            $this->assign('goodsImages', $goodsImages);
            $this->assign('goodsImagesClarity', $goodsImagesClarity);
            return $this->fetch('editGoods');
        }
    }

    /**
     * 添加商品种类
     */
    public function addGoodsType(){
        $model = model('GoodsType');
        if(request()->isPost()){
            $map = array();
            $map['uid']   = $this->uid;
            $map['pid']   = input('typeUp');
            $map['sort']  = input('typeSort');
            $map['title'] = input('typeName');

            $id = input('id');  // 判断是新增还是修改
            if($id){
                $map['edittime'] = time();
                $res = $model->where(['id'=>$id])->update($map);
                if($res) {
                    return json(array('code' => 1, 'msg' => '修改成功'));
                }else{
                    return json(array('code'=>0, 'msg'=>'修改失败'));
                }
            }else{
                // 验证是否重复
                $obj = $model->getType($this->uid, '', array('title'=>input('typeName')));
                if($obj){ return json(array('code'=>0, 'msg'=>'已存在此种类')); }

                $map['addtime'] = time();
                $res = $model->save($map);
                if($res){
                    return json(array('code'=>1, 'msg'=>'添加成功'));
                }else{
                    return json(array('code'=>0, 'msg'=>'添加失败'));
                }
            }
        }else{
            $id = input('id');
            if($id){
                $map['id'] = array('eq', $id);
                $list = $model->getType($this->uid, '', $map);
                $this->assign('list', $list);
            }
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
    public function delGoods(){
        $gid = input('gid');
        $map['gid'] = $gid;
        if($gid){
            if(model('Goods')->delGoods($map)){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法请求');
        }
    }

    /**
     * 商品列表
     */
    public function listGoods(){
        // 获取商品
        $map = array();
        $searchData = array();
        $field = 'gid,gTitle,gType,gUnit,gPrice, is_sell';
        $title = input('gName');
        if($title){
            $searchData['title'] = $title;
            $map['gTitle'] = !empty($title)?array('like', '%'.$title.'%'):'';
        }
        $list  = model('Goods')->getAll(10, $field, $map);
        $count = count($list);
        // 获取商品类型
        $gType = model('GoodsType')->getType($this->uid, '', $map = array(), 'id,title');
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('gType', $gType);
        $this->assign('searchData', $searchData);
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
            $gType = model('GoodsType')->getType($this->uid, '', $map = array(), 'id,title');

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
     * 上架下架商品
     */
    public function stopOrStartGoods(){
        $sell_info = '';
        $gid = input('gid');
        $is_sell = input('is_sell');
        if($is_sell == '' || !$gid){
            $this->error('参数错误');
            exit();
        }
        $is_sell = ($is_sell == 1) ? 0 : 1;
        $sell_info = ($is_sell == 1) ? '上架' : '下架';
        $where['gid'] = $gid;
        $map['is_sell'] = $is_sell;
        if(model('Goods')->stopOrStartGoods($where, $map)){
            $this->success($sell_info.'成功');
        }else{
            $this->error($sell_info.'失败');
        }
    }

    /**
     * 商品种类
     * 
     */
    // 1.商品种类列表
    public function listGoodsType(){
        $map = array();
        $searchData = array();
        $title = input('title');    //按名称查询
        $goods_type = input('goods_type');  // 按启用禁用查询

        if($title){
            $searchData['title'] = $title;
            $map['title'] = array('eq', $title);
            $this->assign('title', $title);
        }
        if($goods_type){
            $map['status'] = array('eq', $goods_type);
        }
        $list = model('GoodsType')->getType($this->uid, 10, $map);
        $this->assign('list', $list);
        $this->assign('count', count($list));
        $this->assign('searchData', $searchData);
        return $this->fetch();
    }

    // 2.修改商品种类状态 （启用禁用）
    public function editTypeStatus(){
        $id = input('ids');
        $status = input('status');
        if(!$id || !$status){
            $this->error('系统错误，请稍后再试');
        }else{
            $status = ($status == '1') ? '2' : '1';
            $info = ($status == '1') ? '启用' : '禁用';
            $map['status'] = $status;
            $map['edittime'] = time();
            $res = model('GoodsType')->editStatus($id, $map);
            $res ? $this->success($info.'成功') : $this->error($info.'失败');
        }
    }

    // 删除商品种类
    public function delGoodsType(){
        $id = input('id');
        $list = model('GoodsType')->getType($this->uid);
        $bool = true;
        foreach($list as $k=>$v){
            if($v['pid'] == $id){
                $bool = false;
                break;
            }
        }
        if(!$bool){
            $this->error('有下级分类关联，请先取消关联');
        }else{
            if(model('GoodsType')->where(['id'=>$id])->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }
}

 ?>