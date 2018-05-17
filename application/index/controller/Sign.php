<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

class Sign extends Controller{
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
		if($is_sign){
			return $this ->success("已登录","Index/index");
		}
		else{
			return $this->fetch("index",[
				"key"  => $key,
				"is_sign"  => $is_sign
			]);
		}
	}
}
?>