<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

return [
	"index"    => "index/Index/index",
	"page/:id" => "index/Page/index",
	"search"   => "index/Search/index",
	"sign"     => "index/Sign/index",
	"ajaxup"     => "index/Sign/signup",
	"ajaxin"     => "index/Sign/signin",
	"imgUpload"  => "index/manage/upload",
	"handleUpload"  => "index/manage/handleUpload",
	"manage"     => "index/Manage/index",
	"add"        => "index/Manage/addArticle",
	"handleAdd"  => "index/Manage/addHandle",
	"delArticle" => "index/Manage/delArticle",
	"modifyArticle" => "index/Manage/modifyArticle",
	"handleModify" => "index/Manage/modifyHandle",
	"exitSign"  => "index/Sign/exitSign",
	"about"     => "index/Other/about",
	"contact"  => "index/Other/contact",
];
