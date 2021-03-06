<?php
namespace app\index\widget;
use think\Controller;
use think\Session;
class Layout extends Controller {
	public function menu($name) {
		return $this->fetch('widget/menu', ['name'=>$name]);
	} 
	public function head($key, $content, $title) {
		return $this->fetch('widget/head', ['key'=>$key, 'content'=>$content, 'title'=>$title]);
	}
}