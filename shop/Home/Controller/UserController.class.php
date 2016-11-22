<?php 

	namespace Home\Controller;
	use Think\Controller;

	//Controller父类   ThinkPHP\Library\Think\contorller.class.php
	class  UserController extends Controller{
		//用户注册
		function register(){

			$user = new \Model\UserModel();
			//判断表单是否提交
			if (!empty($_POST)) {
				$z = $user ->create();  
				//只有全部验证通过   $z才为真
				if (!$z) {
					//验证失败 输出错误信息
					//getError() 犯法返回验证失败的信息
					show_bug($user ->getError());
				}else{
					$user ->user_hobby = implode(',',$_POST['user_hobby']);
					$rst = $user -> add();
					if ($rst) {
						$this ->success("注册成功",U("Goods/showlist"));
					}else{
						echo "添加失败";
					}
				}
			}else{
				$this->display();
			}
		}
		//用户登录
		function login(){
			//调用视图display()
			$this->display();
		}

		//输入的action方法不存在时
		// function _empty(){
		// 	echo "对不起，服务器繁忙！";
		// }

		function number(){
			// echo "目前用户注册会员200万。";
		}
	}
 ?>