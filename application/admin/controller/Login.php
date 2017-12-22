<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\admin\model\User;
class Login extends Controller {
	public function index () {
		return view('index');
	}
	// 判断登录信息是否正确
	public function loginInfo (Request $request) {
		if ( !$request->isPost() ) {
			$this->error("非法操作");
		}
		// 获取数据
		$username = input('post.username');
		$password = input('post.password');
		$yzm = input('post.yzm');

		$data['status'] = 200;

		// 验证码校验
		if(!captcha_check($yzm)) {
			$data['msg'] = '验证码错误!';
			$data['flag'] = false;
			return $data;
		}
		// 校验用户是否存在
		$result = User::get(['user_name'=>$username, 'user_pwd'=>md5($password)]);
		if ( !$result ) {
			$data['msg'] = '用户不存在';
			$data['flag'] = false;
			return $data;
		}
		$data['msg'] = '登录成功！';
		$data['flag'] = true;
		Session::set('username', $username);
		return $data;
	}

	// 退出登录
	public function logout () {
		Session::clear();
		$this->redirect('admin/Login/index');
	}
}