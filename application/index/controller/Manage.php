<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\User;
use app\index\model\Article;

class Manage extends Controller{
	public function index(){
		$is_sign = Session("?id");
		$user_data = [];
		if(!$is_sign){
			return $this ->success("请登录",url('index/Sign/index','key=up'));
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

	//添加文章
	public function addArticle(){
		$is_sign = Session("?id");
		$user_data = [];

		$uid = Session("id");
		if(!$uid) //检查用户是否已经登录
			return $this ->success("请先登陆",url('index/Sign/index','key=up'));
		else{
			$user_data =[
				"id"        => Session("id"),
				"username"  => Session("username"),
				"img"       => Session("img"),
			];
			return $this->fetch('manage/add',[
				"is_sign"  => $is_sign,
				"user_data" => $user_data,
			]);
		}
	}

	public function addHandle(){
		$uid = Session("id");
		if(!$uid) return $this ->success("请先登陆",url('index/Sign/index','key=up'));//检查用户是否已经登录
		$title = input("post.title");
		$author = input("post.author");
		$description = input("post.description");
		$content = input("post.content");
		$data = Article::create([
			"uid" => $uid,
			"title" => $title,
			"author" => $author,
			"description" => $description,
			"content"  => $content,
			"creation_time"  => date("Y-m-d H:m:s",time()),
			"modification_time" => date("Y-m-d H:m:s",time())
		]);
		if(count($data) == 1){
			return $this->success("添加成功",url('index/Manage/index'));
		}else{
			return "添加失败，可能数据有误";
		}
	}

	//删除文章（之后改用ajax）
	//TODO?
	public function delArticle(){
		$id = input("get.id");
		$uid = Session("id");
		if(!$uid) return $this ->success("请先登陆",url('index/Sign/index','key=up'));//检查用户是否已经登录
		$data = Article::where("id = $id and uid = $uid")->select();
		dump($data);
		//文章uid与当前用户id一致，可删除文章
		if(count($data) == 1){
			$ret = Article::where("id = $id")->delete();
			if($ret == 1){
				return "删除成功";
			}else if($ret<=0){
				return "删除失败";
			}
		}
		else{
			//文章uid与当前用户id不一致
			return "删除失败，文章id对应错误！";
		}
	}

	public function modifyArticle($id){
		$is_sign = Session("?id");
		$user_data = [];
		$uid = Session("id");
		if(!$uid) //检查用户是否已经登录
			return $this ->success("请先登陆",url('index/Sign/index','key=up'));
		else{
			$data = Article::where("id = $id and uid = $uid")->select();
			if(count($data) != 1) return $this->success("数据有误，请重新修改",url('index/Manage/index'));//如果用户id与文章发布者id不同，返回管理中心
			$user_data =[
				"id"        => Session("id"),
				"username"  => Session("username"),
				"img"       => Session("img"),
			];
			$data = $data[0];
			return $this->fetch('manage/modify',[
				"is_sign"  => $is_sign,
				"user_data" => $user_data,
				"data"   => $data
			]);
		}
	}

	public function modifyHandle(){
		$uid = Session("id");
		if(!$uid) return $this ->success("请先登陆",url('index/Sign/index','key=up'));//检查用户是否已经登录
		$id = input("post.id");
		$title = input("post.title");
		$author = input("post.author");
		$description = input("post.description");
		$content = input("post.content");
		if(count(Article::where("id = $id")->select())>0){
			$data = Article::where("id = $id")->update([
				"uid" => $uid,
				"title" => $title,
				"author" => $author,
				"description" => $description,
				"content"  => $content,
				"modification_time" => date("Y-m-d H:m:s",time())
			]);
			if(count($data) == 1){
				$url = url('index/Manage/index');
				return "<script>window.location.href='$url'</script>";
				//return $this->success("修改成功",url('index/Manage/index'));
			}else{
				return "修改失败，可能数据有误";
			}
		}
	}

	public function upload(){
		$id = Session("id");
		$is_sign = Session("?id");
		$url = url('index/Sign/index','key=up');
		if(!$is_sign) return "<script>alert('请先登录');window.location.href='$url'</script>";
		else{
			$data = User::where("id = $id")->select();
			if(count($data) == 1){
				$user_data =[
					"id"        => Session("id"),
					"username"  => Session("username"),
					"img"       => Session("img"),
				];
				return $this->fetch('upload',[
					"is_sign"  => $is_sign,
					"user_data" => $user_data,
				]);
			}else{
				return "<script>alert('请先登录');window.location.href='$url'</script>";
			}
		}
	}

	public function handleUpload(){
		$id = Session("id");
		$url = url('index/Sign/index','key=up');
		if(!$id) return "<script>alert('请先登录');window.location.href='$url'</script>";
	    // 获取表单上传文件
	    $file = request()->file('img');
	    // 移动到框架应用根目录/public/static/img/peopleimg目录下
	    if($file){
	        $info = $file->rule('md5')->move("../public/static/img/peopleimg/");
	        if($info){
	            // 成功上传后 获取上传信息
	            $data = User::where("id = $id")->update([
	            	"peopleimg" => $info->getSaveName(),
	            ]);
	            Session("img",$info->getSaveName());
	            $url = url('index/manage/index');
	            return "<script>alert('头像上传成功');window.location.href='$url'</script>";
	        }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
	        }
	    }
	}
}
?>