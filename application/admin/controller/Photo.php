<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use think\Paginator;
class Photo extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}

	public function index () {
		$count = Db::table('photos')->count();
		$photos = Db::table('photos')->paginate(5);
		return $this->fetch('index', ['count'=>$count, 'photos'=>$photos]);
	}

	public function add (Request $request) {
		if ( !$request->isPost() ) {

			return $this->fetch('add',
				['time'=>time()]
			);
		}

		$title = input('post.title');
		$describe = input('post.describe');
		$titlepic = input('post.titlepic');
		$time = time();

		$data['photo_name'] = $title;
		$data['photo_description'] = $describe;
		$data['upload_time'] = $time;
		$data['photo_src'] = $titlepic;

		$result = Db::table('photos')->insert($data);

		if ( !$result ) {
			$this->error("添加失败");
		}
		return $this->success("添加成功");

	}

	public function edit ($id, Request $request) {
		if ( !$request->isPOST() ) {
			$result = Db::table('photos')->where('photo_id', $id)->find();
			return $this->fetch('edit', ['time'=>time(), 'photo'=>$result]);
		}
	}

	public function update() {
		$title = input('post.title');
		$describe = input('post.describe');
		$titlepic = input('post.titlepic');
		$time = time();

		$id = input('post.id');

		$data['photo_name'] = $title;
		$data['photo_description'] = $describe;
		$data['upload_time'] = $time;
		$data['photo_src'] = $titlepic;

		$result = Db::table('photos')->where('photo_id', $id)->update($data);

		if ( !$result ) {
			$this->error("更新失败");
		}
		return $this->success("更新成功");
	}

	public function del (Request $request) {
		if ( !$request->isPOST() ) {
			$this->error("非法操作");
		}
		$id = input("post.id");
		$result = Db::table('photos')->where('photo_id',$id)->delete();
		$data['flag'] = true;
		if ( $result ) {
			$data['msg'] = "删除成功！";
			return $data;
		}
		$data['msg'] = '删除失败！';
		return $data; 
	}
}