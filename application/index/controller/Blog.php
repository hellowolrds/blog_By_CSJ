<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Blog extends Controller
{
    public function index()
    {
    	$blogs = Db::table('article')->select();
    	return $this->fetch('index', ['blogs'=>$blogs]);
    	
    }


    public function detail($id) {
    	$blog = Db::table('article')->where('article_id', $id)->find();
    	return $this->fetch('detail', ['blog'=>$blog]);
    }
}