<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Article;

class Search extends Controller{
	public function index(){
		//dump(input("get.key"));//输出get传入参数
		$key = input("get.key");
		$data = Article::where("title like '%$key%'")->order("id desc")->select();
		$count = count($data);

		return $this->fetch('index',[
			"webtitle"    => "AlbertWjw",    //网页标题
			"key"         => $key,
			"data"        => $data,
			"count"       => $count
		]);
	}
}
?>