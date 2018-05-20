<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\Article;

class Other extends Controller{
	public function about(){
		return $this->fetch("about");
	}

	public function contact(){
		return $this->fetch("contact");
	}
}
?>