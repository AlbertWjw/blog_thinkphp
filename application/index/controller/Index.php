<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Article;

class Index extends Controller{
	public function index(){

		$key = input("get.key");
		$data = Article::all();
		$count = count($data);
		//$this->assign("testassign","ta");
		return $this->fetch('index',[
			"webtitle"    => "AlbertWjw",    //网页标题
			"data"        => $data,
			"count"       => $count
		],[
			//"___CSS__" => "/static/css/"
		]);
	}

	public function page(){
		return 1;
	}
}
?>