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
			return $this->fetch('add', ['tab'=>$tabs, 'title'=>'撰写新文章', 'url'=>"/admin/Article/add"]);
		}
		$title = input('post.title');
		$content = input('post.content');
		$keyword = input('post.keywords');
		$describe = input('post.describe');
		$category = input('post.category');
		$tags = input('post.tags');
		$titlepic = input('post.titlepic');
		$lock = input('post.visibility');

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

		$result = Db::table('article')->where('article_id',$id)->update($data);

		if ( !$result ) {
			$this->error("更新失败");
		}
		return $this->success("更新成功", "/admin/Article/index");
	}

	public function del () {
		
	}
}