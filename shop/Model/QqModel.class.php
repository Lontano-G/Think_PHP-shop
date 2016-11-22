<?php 

	//Goods商品数据模型model
	namespace Model;
	use Think\Model;

	//父类Model 在 Think/Libriry/ThinK/Model.class.php
	class QqModel extends Model{
		//定义当前模型操作真是的数据表
		protected $trueTableName = 'tencent_qq';
	}
 ?>