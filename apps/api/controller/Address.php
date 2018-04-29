<?php
namespace app\api\controller;
use think\Controller;

class Address extends Controller{

    public function getAddress(){
        $id = input('id');
        if($id){
            $data = model('Address')->getAddress(['id'=>$id]);
            if($data){
                return json(array('code'=>1, 'msg'=>'获取成功', 'data'=>$data));
            }else{
                return json(array('code'=>0, 'msg'=>'获取失败'));
            }
        }else{
            $this->error('系统错误,请稍候重试');
        }

    }
    
}
?>