<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;

class Api extends Controller {

	public function index () {
		return 'Hello';
	}

	// 获取首页轮播图数据
	public function banner (Request $request) {
		if ( !$request->isGET() ) {
			$this->error ('非法操作');
		}
		// 查询文章
    	$result = Db::query('select * from article order by article_id desc limit 5');

    	return json(['status'=>200, "msg"=>"ok", 'data'=>$result]);
	}

	// 获取首页最近的博客
	public function blog (Request $request) {
		if ( !$request->isGET() ) {
			$this->error ('非法操作');
		}
		// 查询文章
    	$result = Db::query('select * from article limit 4');

    	return json(['status'=>200, "msg"=>"ok", 'data'=>$result]);
	}
	// 首页相册
	public function photo (Request $request) {
		if ( !$request->isGET() ) {
			$this->error ('非法操作');
		}
		$photos = Db::table('photos')->limit(4)->select();
		return json(['status'=>200, "msg"=>"ok", 'data'=>$photos]);
	}
	// 全部博客
	public function all_blog (Request $request) {
		if ( !$request->isGET() ) {
			$this->error ('非法操作');
		}
		$blogs = Db::table('article')->select();

    	return json(['status'=>200, "msg"=>"ok", 'data'=>$blogs]);
	}
	// 全部相册
	public function all_photo (Request $request) {
		if ( !$request->isGET() ) {
			$this->error ('非法操作');
		}
		$photos = Db::table('photos')->select();
		return json(['status'=>200, "msg"=>"ok", 'data'=>$photos]);
	}
	// 全部时光轴
	public function all_time () {
		$time = Db::table('time')->select();

    	$arr = $this->BubbleSort($time);

    	return json(['status'=>200, "msg"=>"ok", 'data'=>$time]);
	}

	// 博客内容
	public function detail() {
		$id = input('get.id');
		$blog = Db::table('article')->where('article_id', $id)->find();
        $click = $blog['article_click'] + 1;
        Db::table('article')->where('article_id', $id)->update(['article_click'=>$click]);
    	return json(['status'=>200, "msg"=>"ok", 'data'=>$blog]);
	}


	// 冒泡排序
	public function BubbleSort($arr) {
	    $len = count($arr);
	    //设置一个空数组 用来接收冒出来的泡
	    //该层循环控制 需要冒泡的轮数
	    for ($i = 1; $i < $len; $i++) {
	        $flag = false;    //本趟排序开始前，交换标志应为假
	        //该层循环用来控制每轮 冒出一个数 需要比较的次数
	        for ($k = 0; $k < $len - $i; $k++) {
	            //从小到大排序
	            if ($arr[$k]['time_time'] < $arr[$k + 1]['time_time']) {
	                $tmp = $arr[$k + 1];
	                $arr[$k + 1] = $arr[$k];
	                $arr[$k] = $tmp;
	                $flag = true;
	            }
	        }
	        if(!$flag) return $arr;
	    }
	}
}
	


