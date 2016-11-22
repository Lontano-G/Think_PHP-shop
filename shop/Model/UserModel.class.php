<?php 

	//Goods商品数据模型model
	namespace Model;
	use Think\Model;

	//父类Model 在 Think/Libriry/ThinK/Model.class.php
	class UserModel extends Model{
		//一次性获取全部的验证错误
		protected $patchValidate  =  true;
		//实现表单项目验证
		protected $_validate  = array(	
			//验证用户名
			array('username','require','用户名必须填写'),
			array('password','require','密码必须填写'),

			//可以为同一个项目设置多个验证
			array('password2','require','确认密码必须填写'),
			// //与密码的值是否一致
			array('password2','password','两次密码不一致',0,'confirm'),

			//邮箱验证
			array('user_email','email','邮箱格式不正确',2),  // 第四个参数值  为2：值不为空的时候进行验证； 为0：存在字段就验证； 为1：必须验证

			//验证qq    都是数字的  长度5-10   首尾不为0
			//正则验证   /^[1-9]\d{4,9}$/
			array('user_qq','/^[1-9]\d{4,9}$/','请正确填写qq'),

			array('user_tel',"/^[1-9]\d{10}$/",'请正确填写手机号'),
			
			//学历验证   必须选择一个,  值在2,3,4,5范围内即可
			array('user_xueli',"2,3,4,5",'请选择学历',0,'in'),

			//爱好项目至少选择两项以上
			//爱好的值是一个数组，判断其元素个数即可知道结果
			//callback利用当前model里边的一个指定方法进行验证
			array('user_hobby','check_hobby','爱好必须两项以上',0,'callback'),
		);
		//自定义方法验证爱好信息
		//$name 参数是当前被验证的信息
		//$name = $_POST[user_hobby]
		function check_hobby($name){
			if (count($naem)) {
				return false;
			}else{
				return true;
			}
		}
	}
 ?>