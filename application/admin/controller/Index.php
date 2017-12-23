<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;

class Index extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}
	public function index () {
		
		return view('index');
	}
}