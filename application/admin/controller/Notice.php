<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use think\Paginator;
class Notice extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}
	public function index () {
		$notice = Db::table('notice')->paginate(5);
		return $this->fetch('index', ['notice'=>$notice]);
	}
	public function add (Request $request) {
		if ( !$request->isPOST() ) {
			return $this->fetch('add', ['time'=>time()]);
		}
		$title = input('post.title');
		$content = input('post.content');
		$keywords = input('post.keywords');
		$describe = input('post.describe');
		$visibility = input('post.visibility');

		$data['title'] = $title;
		$data['content'] = $content;
		$data['key'] = $keywords;
		$data['description'] = $describe;
		$data['lock'] = $visibility;
		$data['time'] = time();

		$result = Db::table('notice')->insert($data);

		if ( !$result ) {
			$this->error("添加失败");
		}
		return $this->success("添加成功");
	}

	public function edit($id, Request $request) {
		$result = Db::table('notice')->where('Id', $id)->find();
		return $this->fetch('edit', ['notice'=>$result, 'time'=>time()]);
	}

	public function update(Request $request) {
		if ( !$request->isPOST() ) {
			return $this->fetch('add', ['time'=>time()]);
		}
		$title = input('post.title');
		$content = input('post.content');
		$keywords = input('post.keywords');
		$describe = input('post.describe');
		$visibility = input('post.visibility');
		$id = input('post.id');

		$data['title'] = $title;
		$data['content'] = $content;
		$data['key'] = $keywords;
		$data['description'] = $describe;
		$data['lock'] = $visibility;
		$data['time'] = time();

		$result = Db::table('notice')->where('Id', $id)->update($data);

		if ( !$result ) {
			$this->error("更新失败");
		}
		return $this->success("更新成功", 'admin/Notice/index');
	}
}