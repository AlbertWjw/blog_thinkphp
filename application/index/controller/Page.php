<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Article;

class Page extends Controller{
	public function index($id){

		$data = Article::where("id = $id")->select();
		if(count($data)>0){
		return $this->fetch('index',[
			"webtitle"    => "$id - AlbertWjw",    //网页标题
			"data"       => $data[0],        //文章标题
			"count"      => count($data)

			/*"description" => $data[0]['description'],  //文章简介
			"author"      => $data[0]['author'],       //文章作者
			"dateline"    => $data[0]['creation_time'],  //发布时间
			"content"     => $data[0]['content'],      //文章内容
			"id"          => $id             //文章id*/
		]);
		}
		else{
					return $this->fetch('index',[
			"webtitle"    => "$id - AlbertWjw",    //网页标题
			"count"      => count($data)
		]);
		}
	}
}
?>