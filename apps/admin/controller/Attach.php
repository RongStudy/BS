<?php
namespace app\admin\controller;


class Attach extends Base{

	/**
	 * 添加图片
	 */
    public function addImg(){
    	$file  = request()->file('file');
    	if($file){
    		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
    		$image = \think\Image::open(request()->file('file'));

    		// 缩略图处理
    		$thumbName = md5(time());
    		$res = $image->thumb(150, 150, \think\Image::THUMB_CENTER)
    		  		->save(ROOT_PATH . 'public'.DS.'uploads'.DS.'thumb'. DS . $thumbName . '.' . $image->type());

    		if($info){
    			$map['name'] 	  = $info->getFilename();
    			$map['addtime']   = time();
    			$map['extension'] = $info->getExtension();
    			$map['save_path'] = explode('\\', $info->getSaveName())[0];
    			$map['save_name'] = $info->getSaveName();
    			$map['width'] 	  = $image->width();
    			$map['height'] 	  = $image->height();
    			if($res){
    				$map['thumb_name'] = $thumbName. '.' . $image->type();
    				$map['thumb_path'] = 'thumb';
    			}
    			$ret = model('Attach')->addPhoto($map);

    			if($ret){
    				$state = 1;
    				$msg  = $ret; // 数据库自增ID
    				// echo json_encode(array('state'=>1, 'path'=>'./demo'));
    				// return json(array('code'=>1,',msg'=>'测试'));
    				return json(array('state'=>$state, 'path'=>$msg));
    				// return (json_encode(array('state'=>1, 'path'=>'./demo')));
    			}else{
    				$state = 0;
    				$errmsg   = '添加失败';
    				return (json_encode(array('state'=>$state, 'errmsg'=>$errmsg)));
    			}
    		}else{
    			// 上传失败获取错误信息
    			return (json_encode(array('state'=>0, 'errmsg'=>'系统出错')));
    		}
    	}
    }
}

 ?>