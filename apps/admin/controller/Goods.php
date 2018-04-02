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
        $list  = model('Goods')->getAll();
        $count = count($list);
        $this->assign('count', $count);
        $this->assign('list', $list);
        return $this->fetch();
    }
}

 ?>