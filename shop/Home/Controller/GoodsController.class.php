<?php 

	namespace Home\Controller;
	use Think\Controller;

	class  GoodsController extends Controller{
		//商品列表
		function showlist(){
			//获得user控制器的number（）方法返回的信息
			//当前UserController会通过自动加载机制引入
			//ThinkPHP/Library/Thinnk.class.php
			$user = new UserController(); 	//  =  $user = A("User");
			echo $user -> number();
			//简便操作
			//echo R("User/number");


			$this->display();
		}
		//商品详细信息
		function detail(){
			$this->display();
		}

		//跨项目、跨模块调用指定控制器
		//$index = A("book://Home/Index");
		//echo $index ->getName();
	}
 ?>