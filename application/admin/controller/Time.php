<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use think\Paginator;
class Time extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}
	public function index () {
		$count = Db::table('time')->count();
		$time = Db::table('time')->paginate(5);
		return $this->fetch('index', ['count'=>$count, 'time'=>$time]);
	}

	public function add (Request $request) {
		if ( !$request->isPost() ) {
			return $this->fetch('add', ['time'=>time()]);
		}

		$content = input('post.content');
		$titlepic = input('post.titlepic');
		$time = time();

		$data['time_content'] = $content;

		$data['time_image'] = $titlepic;
		$data['time_time'] = $time;

		$result = Db::table('time')->insert($data);

		if ( !$result ) {
			$this->error("添加失败");
		}
		return $this->success("添加成功");
	}

	public function del (Request $request) {
		if ( !$request->isPOST() ) {
			$this->error("非法操作");
		}
		$id = input("post.id");
		$result = Db::table('time')->where('time_id',$id)->delete();
		$data['flag'] = true;
		if ( $result ) {
			$data['msg'] = "删除成功！";
			return $data;
		}
		$data['msg'] = '删除失败！';
		return $data; 
	}
}