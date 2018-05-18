<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\User;

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

	//登录ajax
	public function signin(){
		$username = input("post.username");
		//dump($username);
		$password = input("post.password");
		//dump(User::where("username = '$username'")->select());
		$data = User::where("username = '$username' and password = '$password'")->select();
		//dump($data);
		if(count($data) !=0){
			Session("id",$data[0]['id']);
			Session("username",$data[0]['username']);
			Session("img",$data[0]['peopleimg']);
			return '登录成功';
		}
		else
			return '登录失败';
	}
}
?>