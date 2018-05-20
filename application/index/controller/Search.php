<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Article;

class Search extends Controller{
	public function index(){
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
		$data = Article::where("title like '%$key%'")->order("id desc")->select();
		$count = count($data);

		return $this->fetch('index',[
			"is_sign"     => $is_sign,
			"user_data"   => $user_data,
			"key"         => $key,
			"data"        => $data,
			"count"       => $count
		]);
	}
}
?>