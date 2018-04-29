<?php 
namespace app\home\controller;

class Address extends Base{

    /**
     * 增加收货地址
     */
    public function addAddress(){
        if(request()->isPost()){
            $data = input('');
            $data['uid'] = $this->uid;
            $data['addtime'] = time();
            if(model('Address')->insert($data)){
                $this->success('添加成功');
            }else{
                $this->error('添加收货地址失败');
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 我的收货地址
     * @return [type] [description]
     */
    public function myAddress(){
        if(request()->isPost()){

        }else{
            $type = goods_type();
            $this->assign('up_type', $type['up_type']);
            $this->assign('down_type', $type['down_type']);
            $this->assign('no_show_order', '1');


            $addressData = model('Address')->getAddress(array('uid'=>$this->uid));
            $this->assign('addressData', $addressData);
            return $this->fetch();
        }
    }

    /**
     * 删除收货地址
     * @return [type] [description]
     */
    public function delAddress(){
        $id = input('id');
        if($id){
            if(model('Address')->where(['id'=>$id])->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法请求');
        }
    }

    /**
     * 修改收货地址
     */
    public function editAddress(){
        $data = input('');
        $id = input('id');
        unset($data['id']);
        if(model('Address')->editAddress(['id'=>$id], $data)!==false){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }
}

 ?>