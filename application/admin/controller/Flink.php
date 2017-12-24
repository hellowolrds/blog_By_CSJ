<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use think\Paginator;
class Flink extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}
	public function index () {
		$links = Db::table('friendly_link')->paginate(5);
		$count = Db::table('friendly_link')->count();
		return $this->fetch('index', ['link'=>$links, 'count'=>$count]);
	}

	public function add (Request $request) {
		if ( !$request->isPOST() ) {
			return $this->fetch('add', ['time'=>time()]);
		}

		$title = input('post.name');
		$url = input('post.url');
		$imgurl = input('post.imgurl');
		$describe = input('post.describe');
		$target = input('post.target');

		$data['link_name'] = $title;
		$data['link_url'] = $url;
		$data['link_logo'] = $imgurl;
		$data['show_order'] = 1;
		$data['time'] = time();
		$data['status'] = 1;
		$data['opentype'] = $target;
		$data['description'] = $describe;


		$result = Db::table('friendly_link')->insert($data);

		if ( !$result ) {
			$this->error("添加失败");
		}
		return $this->success("添加成功");
	}

	public function edit ($id, Request $request) {
		$result = Db::table('friendly_link')->where('link_id', $id)->find();
		return $this->fetch('edit', ['link'=>$result, 'time'=>time()]);
	}

	public function update() {
		$title = input('post.name');
		$url = input('post.url');
		$imgurl = input('post.imgurl');
		$describe = input('post.describe');
		$target = input('post.target');
		$id = input('post.id');

		$data['link_name'] = $title;
		$data['link_url'] = $url;
		$data['link_logo'] = $imgurl;
		$data['show_order'] = 1;
		$data['time'] = time();
		$data['status'] = 1;
		$data['opentype'] = $target;
		$data['description'] = $describe;


		$result = Db::table('friendly_link')->where('link_id', $id)->update($data);

		if ( !$result ) {
			$this->error("更新失败");
		}
		return $this->success("更新成功", '/admin/Flink/index');
	}

	public function del (Request $request) {
		if ( !$request->isPOST() ) {
			$this->error("非法操作");
		}
		$id = input("post.id");
		$result = Db::table('friendly_link')->where('link_id',$id)->delete();
		$data['flag'] = true;
		if ( $result ) {
			$data['msg'] = "删除成功！";
			return $data;
		}
		$data['msg'] = '删除失败！';
		return $data; 
	}
}