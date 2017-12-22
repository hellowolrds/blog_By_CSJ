<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;

class Tab extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}

	public function index () {
		// 获取栏目数据
		$tabs = Db::table('article_sort')->select();

		return $this->fetch('index', ['tab'=>$tabs]);
	}

	public function add (Request $request) {
		if ( !$request->isPOST() ) {
			$this->error("非法操作！");
		}
		// 获取栏目名
		$name = input('post.name');
		$alias = input('post.alias');
		$data['user_id'] = 0;
		$data['sort_article_name'] = $name;
		$data['nickname'] = $alias;
		$result = Db::table('article_sort')->insert($data);
		if ( !$result ) {
			$this->error("添加失败");
		}
		return $this->success("添加成功！");
	}

	public function del (Request $request) {
		if ( !$request->isGET() ) {
			$this->error("非法操作！");
		}
		$id = input('get.id');
		$result = Db::table('article_sort')->delete($id);

		if ( !$result ) {
			return ['flag'=>'false', 'msg'=>'删除失败'];
		}
		return ['flag'=>'true', 'msg'=>'删除成功'];
	}
}