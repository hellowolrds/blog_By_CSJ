<?php
namespace app\admin\widget;
use think\Controller;
use think\Session;
class Layout extends Controller {
	public function menu($name) {
		return $this->fetch('widget/menu', ['name'=>$name]);
	}
	public function modal() {
		return $this->fetch('widget/modal');
	}
	public function nav () {
		// 获取用户名
		$user = Session::get('username');
		return $this->fetch('widget/nav', ['user'=>$user]);
	}
}