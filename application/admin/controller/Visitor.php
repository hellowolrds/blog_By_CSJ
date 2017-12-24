<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use think\Paginator;
class Visitor extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}

	public function index () {
		$count = Db::table('visitor')->count();
		$visitor = Db::table('visitor')->paginate(10);

		return $this->fetch('index', ['count'=>$count, 'visitor'=>$visitor]);
	}
	public function del (Request $request) {
		if ( !$request->isPOST() ) {
			$this->error("非法操作");
		}
		$id = input("post.id");
		$result = Db::table('visitor')->where('v_id',$id)->delete();
		$data['flag'] = true;
		if ( $result ) {
			$data['msg'] = "删除成功！";
			return $data;
		}
		$data['msg'] = '删除失败！';
		return $data; 
	}
}