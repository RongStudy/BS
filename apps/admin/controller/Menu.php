<?php 
namespace app\admin\controller;

class Menu extends Base{

    /**
     * 添加菜单
     */
    public function menuAdd(){
        $menu = model('Menu');
        if(request()->isPost()){
            $map = [];
            $map['title']   = input('menuName');
            $map['sort']    = input('menuSort');
            $map['hide']    = input('menuShow');
            $map['url']     = input('menuUrl');
            $map['pid']     = input('menuUp');
            /**
             * 查看Url是否重复
             */
            $res = $menu->getMenus(array('url'=>input('menuUrl')));
            if($res){
                return json(array('code'=>'0', 'msg'=>'已经有这个Url'));
            }

            if($map){
                $res = $menu->save($map);
                if($res){
                    return json(array('code'=>'1', 'msg'=>'添加成功'));
                }else{
                    return json(array('code'=>'0', 'msg'=>'添加失败'));
                }
            }
        }else{
            $tree  = $menu->getMenuTree();          // 返回数据库中的数据
            $menus = $menu->toFormatTree($tree);    // 返回格式化后的数据

            $this->assign('allMenu', $menus);
            return $this->fetch();
        }
    }

    /**
     * 菜单列表
     */
    public function menuList(){
        $menu = model('Menu');
        $pid = input('pid')?input('pid'):0;
        $map['pid'] = $pid;

        $list = $menu->getMenus($map, '', 2, 10);
        // print_r($list);die;
        $count = count($menu->getMenus('', 'id', '', ''));
        $this->assign('title', input('title'));
        $this->assign('list', $list);
        $this->assign('count', $count);
        return $this->fetch();
    }

    /**
     * 停用启用菜单
     */
    public function stopOrStartMenu(){
        $id     = input('ids');
        $status = input('status');

        if($id && $status){
            $map['status'] = $status;
            $res = model('Menu')->stopOrStart($id, $map);
            if($res){
                $code = 1;
                $msg  = '修改成功';
            }else{
                $code = 0;
                $msg  = '修改失败';
            }
        }else{
            $code = 0;
            $msg  = '参数错误';
        }
        return json(array('code'=>$code, 'msg'=>$msg));
    }

    /**
     * 修改菜单
     */
    public function menuEdit(){
        if(request()->isPost()){
            $map = [];
            $map['id']      = input('ids');
            $map['title']   = input('menuName');
            $map['sort']    = input('menuSort');
            $map['hide']    = input('menuShow');
            $map['url']     = input('menuUrl');
            $map['pid']     = input('menuUp');
            if($map){
                $res = model('Menu')->update($map);
                if($res){
                    return json(array('code'=>1, 'msg'=>'修改成功'));
                }else{
                    return json(array('code'=>0, 'msg'=>'修改失败'));
                }
            }else{
                return json(array('code'=>0, 'msg'=>'非法操作'));
            }
        }else{
            $id = input('ids');
            if($id){
                $menu = model('Menu');
                $map['id'] = $id;
                $list = $menu->getOneMenu($map);

                // 获取所有菜单
                $tree  = $menu->getMenuTree();          // 返回数据库中的数据
                $menus = $menu->toFormatTree($tree);    // 返回格式化后的数据
                
                $this->assign('list', $list);
                $this->assign('allMenu', $menus);
                return $this->fetch();
            }else{
                echo '参数错误，请返回';
            }
        }
    }

    /**
     * 删除菜单
     */
    public function menuDel(){
        $map['id']  = input('ids');
        $pid        = input('pids');
        if($map['id']){
            $menu = model('Menu');
            
            if($pid == 0){
                // 查询是否有下级菜单
                $res = $menu->getOneMenu(array('pid'=>input('ids')));
                if($res){
                    return json(array('code'=>0, 'msg'=>'该菜单有下级菜单，如果要删除此菜单，请先将下级菜单删除，您也可以停用该菜单'));
                }else{
                    $res = $menu->delMenu($map);
                    if($res){
                        return json(array('code'=>1, 'msg'=>'删除成功'));
                    }else{
                        return json(array('code'=>0, 'msg'=>'删除失败'));
                    }
                }
            }
        }else{
            echo '参数错误，请返回';
        }
    }
}

 ?>