<?php 
namespace app\admin\controller;
use think\Db;
/**
 * 文章
 */
class News extends Base{
	public function newsList(){
		$newModel = Db::table('bs_news');
		$list = $newModel->select();
		$this->assign('list', $list);
		return $this->fetch();
	}

	public function newsOperation(){
		$newModel = Db::table('bs_news');
		if(request()->post()){
			$data = input('');
			$data['addtime'] = time();
			if($newModel->insert($data)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}
	}
}

 ?>