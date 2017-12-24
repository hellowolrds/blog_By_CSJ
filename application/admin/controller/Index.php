<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use think\Paginator;

class Index extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}
	public function index () {
		$article = Db::table('article')->count();
		$flink = Db::table('friendly_link')->count();
		$userCount = Db::table('user')->count();
		$username = Session::get('username');
		$sysos = $_SERVER["SERVER_SOFTWARE"];
		$sysversion = PHP_VERSION;

		$visitor = Db::table('visitor')->count();
		return $this->fetch('index', ['article'=>$article, 'flink'=>$flink, 'username'=>$username, 'time'=>time(), 'userCount'=>$userCount, 'sysos'=>$sysos,'sysversion'=>$sysversion, 'visitor'=>$visitor]);
	}
}