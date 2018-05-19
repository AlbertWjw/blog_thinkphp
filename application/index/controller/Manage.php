<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\Article;

class Manage extends Controller{
	public function index(){
		$is_sign = Session("?id");
		$user_data = [];
		if(!$is_sign){
			return $this ->success("请登录","Index/index");
		}else{
			$user_data =[
				"id"        => Session("id"),
				"username"  => Session("username"),
				"img"       => Session("img"),
			];
		}
		$uid = Session('id');
		$data = Article::where("uid = $uid")->select();
		//$data = Article::all();
		//dump($data);
		return $this->fetch("index",[
			"is_sign"    => $is_sign,
			"user_data"  => $user_data,
			"data"     => $data
		]);
	}
}
?>