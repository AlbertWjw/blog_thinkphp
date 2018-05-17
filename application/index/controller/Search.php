<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Article;
use think\Db;

class Search extends Controller{
	public function index(){
		//dump(input("get.key"));//输出get传入参数

		$is_sign = Session("?id");
		$user_data = [];
		if($is_sign){
			$user_data =[
				"id"        => Session("id"),
				"username"  => Session("username"),
				"img"       => Session("img"),
			];
		}

		$key = input("get.key");
		$data = Article::where("title like '%$key%'")->order("modification_time desc")->select();
		$count = count($data);

		return $this->fetch('index',[
			"webtitle"    => "AlbertWjw",    //网页标题
			"is_sign"     => $is_sign,
			"user_data"   => $user_data,
			"key"         => $key,
			"data"        => $data,
			"count"       => $count
		]);
	}
}
?>