<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use think\Paginator;
class Article extends Controller {
	public function _initialize() {
		if ( !Session::has('username') ) {
			$this->redirect('Login/index', '请先登录');
		}
	}

	public function index () {
		$count = Db::table('article')->count();
		$articles = Db::table('article')->join('article_sort', 'article.tab_id=article_sort.id')->paginate(2);
		return $this->fetch('index', ['count'=>$count, 'articles'=>$articles]);
	}

	public function add (Request $request) {

		if ( !$request->isPOST() ) {
			// 获取栏目
			$tabs = Db::table('article_sort')->select();
			return $this->fetch('add', ['tab'=>$tabs, 'title'=>'撰写新文章', 'url'=>"/admin/Article/add", "time"=>time()]);
		}
		$title = input('post.title');
		$content = input('post.content');
		$keyword = input('post.keywords');
		$describe = input('post.describe');
		$category = input('post.category');
		$tags = input('post.tags');
		$titlepic = input('post.titlepic');
		$lock = input('post.visibility');
		$banner = input('post.banner');

		$data['article_name'] = $title;
		$data['article_time'] = time();
		$data['article_ip'] = $request->ip();
		$data['article_click'] = 0;
		$data['sort_article_id'] = 0;
		$data['tab_id'] = $category;
		$data['article_content'] = $content;
		$data['tags'] = $tags;
		$data['image_url'] = $titlepic;
		$data['lock'] = $lock;
		$data['keywords'] = $keyword;
		$data['description'] = $describe;
		$data['banner_image'] = $banner;

		$result = Db::table('article')->insert($data);

		if ( !$result ) {
			$this->error("添加失败");
		}
		return $this->success("添加成功");
	}

	public function edit ($id,Request $request) {
		if ( !$request->isPOST() ) {
			// 获取栏目
			$tabs = Db::table('article_sort')->select();
			$article = Db::table('article')->where('article_id',$id)->find();
			return $this->fetch('edit', ['tab'=>$tabs, 'title'=>'编辑文章', 'url'=>"/admin/Article/update", 'article'=>$article]);
		}
		
	}

	public function update (Request $request) {
		$title = input('post.title');
		$content = input('post.content');
		$keyword = input('post.keywords');
		$describe = input('post.describe');
		$category = input('post.category');
		$tags = input('post.tags');
		$titlepic = input('post.titlepic');
		$lock = input('post.visibility');
		$id = input('post.id');
		$banner = input('post.banner');

		$data['article_name'] = $title;
		$data['article_time'] = time();
		$data['article_ip'] = $request->ip();
		$data['article_click'] = 0;
		$data['sort_article_id'] = 0;
		$data['tab_id'] = $category;
		$data['article_content'] = $content;
		$data['tags'] = $tags;
		$data['image_url'] = $titlepic;
		$data['lock'] = $lock;
		$data['keywords'] = $keyword;
		$data['description'] = $describe;
		$data['banner_image'] = $banner;

		$result = Db::table('article')->where('article_id',$id)->update($data);

		if ( !$result ) {
			$this->error("更新失败");
		}
		return $this->success("更新成功", "/admin/Article/index");
	}

	public function del (Request $request) {
		if ( !$request->isPOST() ) {
			$this->error("非法操作");
		}
		$id = input("post.id");
		$result = Db::table('article')->where('article_id',$id)->delete();
		$data['flag'] = true;
		if ( $result ) {
			$data['msg'] = "删除成功！";
			return $data;
		}
		$data['msg'] = '删除失败！';
		return $data; 
	}
}