<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Photo extends Controller
{
    public function index()
    {
    	// 照片墙
        $photos = Db::table('photos')->limit(4)->select();

    	return $this->fetch('index', ['photos'=>$photos]);
    }
}