<?php
namespace app\admin\widget;
use think\Controller;
class Layout extends Controller {
	public function menu($name) {
		return $this->fetch('widget/menu', ['name'=>$name]);
	}
	public function modal() {
		return $this->fetch('widget/modal');
	}
	public function nav () {
		return $this->fetch('widget/nav');
	}
}