<?php 

	namespace Admin\Controller;
	use Think\Controller;


	class ManagerController extends Controller{
		function login(){
        if(!empty($_POST)){
            //验证码校验
            $verify = new \Think\Verify();
            if(!$verify->check($_POST['captcha'])){
                echo "验证码错误";
            } else {
                //判断用户名和密码，在model模型里边制作一个专门方法进行验证
                $user = new \Model\ManagerModel();
                $rst = $user -> checkNamePwd($_POST['mg_username'],$_POST['mg_password']);
                if($rst === false){
                    echo "用户名或密码错误";
                } else {
                    //登录信息持久化$_SESSION
                    session('mg_username',$rst['mg_name']);
                    session('mg_id',$rst['mg_id']);
                    //$this ->redirect($url, $params, $delay, $msg)
                    //$this -> redirect('Index/index',array('id'=>100,'name'=>'tom'),2,'用户马上登陆到后台');
                    $this -> redirect('Index/index');
                }
            }
        } 
        $this -> assign('lang',L());
        $this -> display();
    }

    	//退出登录
		function logout(){
			session(null);
			$this -> redirect('Manager/login');
		}
		//制作专门方法实现验证码生成
		function verifyImg(){
			//以下verify 在之前并没有include引用
			//Think.class.php    autoload()

			$config = array(
				'imageH'    =>  26,               // 验证码图片高度
        		'imageW'    =>  105,               // 验证码图片宽度
        		'fontSize'  =>  16,
        		'fontttf'   => '4.ttf',				//验证码字体
        		'length'    =>  4,               // 验证码位数
			);

			$verify = new \Think\Verify($config);
			$verify ->entry();
		}
	}
 ?>