<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
    	// 查询文章
    	$result = Db::query('select * from article order by article_id desc limit 5');

    	$blog = Db::query('select * from article limit 4');

        // 照片墙
        $photos = Db::table('photos')->limit(4)->select();

  //   	// 统计访客
  //   	// 获取用户ip
		// $ip = $_SERVER['REMOTE_ADDR'];
		// $time = time();
		// $visitor = '游客'.$time;

		// $data['visitor_time'] = time();
		// $data['visitor_ip'] = $ip;
		// $data['visitor_name'] = $visitor;

		Db::table('visitor')->insert($data);

        return $this->fetch('index', ['banner'=>$result, 'blog'=>$blog, 'photos'=>$photos]);
    }
}
