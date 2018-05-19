<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\Article;

class Index extends Controller{
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
		$data = Article::where("1=1")->order("modification_time desc")->select();
		$count = count($data);
		//$this->assign("testassign","ta");
		return $this->fetch('index',[
			"webtitle"    => "AlbertWjw",    //网页标题
			"data"        => $data,
			"count"       => $count,
			"is_sign"     => $is_sign,
			"user_data"   => $user_data
		],[
			//"___CSS__" => "/static/css/"
		]);
	}

	public function page(){
		return 1;
	}
}
?>