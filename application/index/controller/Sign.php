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
		$password = input("post.password");
		/*if(strlen($username)>16 || strlen($username)<6 || strlen($password)>16 || strlen($password)<6){
			$data = [];
		}else{*/
			$password = md5($password);
			$data = User::where("username = '$username' and password = '$password'")->select();
		//}

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

	//注册ajax
	public function signup(){
		$username = input("post.username");
		$password = input("post.password");
		$email = input("post.email");
		if(strlen($password)>16 || strlen($password)<6){
			return "注册失败";
		}
		$data = User::where("username = '$username'")->select();
		if(count($data)>0){
			return "用户名已存在";
		}else{
			$data = User::create([
				"username" => $username,
				"password" => md5($password),
				"email"  => $email,
				"creation_time" => date("Y-m-d H:m:s",time()),
			]);
			if(count($data) ==1){
				Session("id",$data['id']);
				Session("username",$data['username']);
				return "注册成功";
			}else{
				return '注册失败';
			}
		}
	}
}
?>