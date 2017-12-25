<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Blog extends Controller
{
    public function index()
    {
    	$blogs = Db::table('article')->select();
        // 计算分类
        $tabs = Db::table('article_sort')->select();

        $arr = array();


        foreach ($tabs as $key => $value) {
            $arr[$value['sort_article_name']] = array();
            foreach ($blogs as $k => $blog) {
                if ( $blog['tab_id'] == $value['id'] ) {
                    array_push($arr[$value['sort_article_name']], $blog);
                }
                
            }
        }
    	return $this->fetch('index', ['blogs'=>$arr]);
    	
    }


    public function detail($id) {
    	$blog = Db::table('article')->where('article_id', $id)->find();
        $click = $blog['article_click'] + 1;
        Db::table('article')->where('article_id', $id)->update(['article_click'=>$click]);
    	return $this->fetch('detail', ['blog'=>$blog]);
    }
}