<?php 

	header("content-type:text/html,charset=utf-8");

	//制作一个输出调试函数
	function show_bug($msg){
		echo "<pre style='color:red'>";
		var_dump($msg);
		echo "</pre>";

	}

	//定义css。images.js常量
	define("SITE_URL","/localhost/");
	define("CSS_URL","/shop/shop/public/Home/css/");
	define("IMG_URL","/shop/shop/public/Home/images/");
	define("JS_URL","/shop/shop/public/Home/js/");


	define("ADMIN_CSS_URL","/shop/shop/public/Admin/css/");
	define("ADMIN_IMG_URL","/shop/shop/public/Admin/img/");
	define("ADMIN_JS_URL","/shop/shop/public/Admin/js/");

	//为上传图片设置路径
	// define("IMG_UPLOAD","/shop/shop/public/upload/");
	define("IMG_UPLOAD","/shop/shop/public/");



	//把目前tp模式由生产你是变成开发调试模式
	define('APP_DEBUG', true);

	//引入框架的核心程序
	include "../ThinkPHP/ThinkPHP.php";
 ?>