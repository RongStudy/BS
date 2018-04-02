<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 全局md5加密
 */
function cthink_md5($str){
    $key = 'cthink';
    if(config('enstring')){
        $key = config('enstring');
    }
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 判断系统后台是否登录
 */
function is_login_admin(){
    $return     = false;
    $session    = session('admin.user_auth');
    if(!empty($session)){
        $return = $session;
    }
    return $return;
}

/**
 * 判断用户端是否已登录
 */
function is_login_home(){
    $return  = false;
    $session = session('home.user_auth');
    if(!empty($session)){
        $return = $session;
    }
    return $return;
}


/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) { 
    // 创建Tree
    $tree = [];
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 图片路径
 * $type == 1：获取缩略图
 * $type != 1：获取原图
 */
function photoPath($data, $type = 1){
    $imgPath = [];
    if($type == 1){
        foreach ($data as $key => $value) {
            $imgPath[] = config('url_domain').'/public/uploads/'.$value['thumb_path'].'/'.$value['thumb_name'];
        }
    }else{
        foreach ($data as $key => $value) {
            $imgPath[] = config('url_domain').'/public/uploads/'.$value['save_path'].'/'.$value['name'];
        }
    }
    return $imgPath;
}