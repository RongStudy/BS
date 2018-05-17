<?php 
namespace app\admin\controller;
use think\Db;
/**
 * 文章
 */
class News extends Base{
	// 文章列表
	public function newsList(){
		$newsModel = Db::table('bs_news');
		$list = $newsModel->paginate(15);
		$this->assign('list', $list);
		return $this->fetch();
	}

	// 文章详情
	public function showDetail(){
		$newsModel = Db::table('bs_news');
		$id = input('id');
		$is_edit = input('is_edit');
		!$id ? $this->error('非法请求') : '';
		$where['id'] = $id;
		$data = $newsModel->where($where)->find();
		if($is_edit){
			$this->assign('is_edit', $is_edit);
		}
		$this->assign('data',$data);
		return $this->fetch();
	}

	// 添加文章
	public function newsOperation(){
		$newsModel = Db::table('bs_news');
		if(request()->post()){
			$data = input('');
			$data['addtime'] = time();
			if($newsModel->insert($data)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			return $this->fetch('newsAdd');
		}
	}

	// 是否展示
	public function controlShow(){
		$newsModel = Db::table('bs_news');
		$id = input('post.ids');
		$is_show = input('post.data');
		$map['is_show'] = ($is_show == 'yes') ? 1 : 0;
		$info = ($is_show == 'yes') ? '展示' : '取消展示';
		if($newsModel->where(['id'=>$id])->update($map)){
			$this->success($info.'成功');
		}else{
			$this->error($info.'失败');
		}
	}

	// 删除文章
	public function delNews(){
		$newsModel = Db::table('bs_news');
		$map['id'] = input('post.ids');
		if($newsModel->where($map)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

	// 修改文章
	public function editNews(){
		$newsModel = Db::table('bs_news');
		if(request()->post()){
			$id = input('ids');
			$map['title'] = input('title');
			$map['content'] = input('content');
			if($newsModel->where(['id'=>$id])->update($map)!==false){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			$id = input('id');
			!$id ? $this->error('非法请求') : '';
			$data = $newsModel->where(array('id'=>$id))->find();
			$this->assign('data', $data);
			return $this->fetch('newsEdit');
		}
	}

}

 ?>