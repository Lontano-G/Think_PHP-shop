<?php 

	namespace Admin\Controller;
	use Think\Controller;

class GoodsController extends Controller{

		//商品产品展示
		function showlist1(){
			//使用数据模型model
			//实例化model对象
			//$goods = new \Model\GoodsModel();
			$goods = M('User');
			show_bug($goods);
			//var_dump($goods);

			//$qq = new \Model\QqModel();
			//show_bug($qq);


			$this ->display();
		}



		function showlist2(){
			
			$goods = D('Goods');
			//$info = $goods ->select();
			//show_bug($info);
			// foreach ($info as $k => $v) {
			// 	echo $v['goods_name']."<br />";
			// }

			//价格大于1000的商品
			//$info = $goods -> where("goods_price > 3000 and goods_name like '华%'")->select();

			//查询指定的字段
			//$info = $goods ->field("goods_id,goods_name")->select();

			//限制条件查询
			//$info = $goods ->limit(2,3)->select();

			//分组查询group by   查询当前商品一共的分组信息
			//通过分组设置可以查询每个分组商品的信息
			//例如：每个分组下边有多少商品信息
			//		select category_id count(*) from table group by category_id
			//		每个分组下边商品的价格的算数和是多少
			//       select category_id sum(price) from table group by category_id
			//$info = $goods ->field("goods_category_id")->select();  //有重复的
			//$info = $goods ->field("goods_category_id")->group("goods_category_id")->select();  //没重复的
			//show_bug($info);

			//排序查询
			$info = $goods ->order("goods_price asc")->select();

			$this ->assign('info', $info);

			$this ->display();

		}

		function showlist(){

			$goods = D("Goods");

			//1.获取当前记录的总条数
			$total = $goods ->count();
			$per = 7;

			//2.实例化分页类对象
			$page = new \Component\Page($total , $per);

			//3.拼装sal语句获得每页信息
			$sql = "select * from sw_goods ".$page->limit;
			$info = $goods->query($sql);

			//4.获取页码列表
			$pagelist = $page -> fpage();

			//查询主键值等于2的数据     2.3的数据    select()返回二维数组
			// $info = $goods ->select(2);
			//$info = $goods ->select("2,3");
 	
			//$info = $goods ->find(2);  //返回一维数组
			//var_dump($info);

			//having和 where的区别   where 设置条件，字段必须是数据表中存在的字段    having 设置条件，字段必须是select语句查询出来的字段
			//$info = $goods ->having("goods_price >2500")->select();

			//查看记录多少条
			//echo $goods ->count();
			//echo "<br />";
			//查询价格最大
			//echo $goods ->Max("goods_price");
			//echo "<br />";

			//计算价格大于2500 的商品的总个数
			//echo $goods ->where("goods_price > 2500")->count();

			// $info = $goods ->select();
			$this ->assign('info',$info);
			$this ->assign('pagelist',$pagelist);
			$this ->display();
		}
		//添加商品
		function add1(){
			//添加方式 ：  1. 数组方式添加数据   2.AR方式添加数据
			//add()该方法返回被添加的新纪录的主键ID值

			// 1. 利用数组的方式实现数据添加
			// $goods = D("Goods");
			// $ar = array(
			// 	'goods_name'=>'iphone5s',
			// 	'goods_number'=>545,
			// 	'goods_price'=>5555,
			// );
			// $goods ->add($ar);

			// 2. AR方式添加数据
			$goods = D("Goods");
			$goods ->goods_name = "htc_one";
			$goods ->goods_price = 3456;
			$goods ->goods_number = 4213;
			$goods ->add();


			$this ->display();
		}

		function add(){
			//两个逻辑 1.展示表单  2.接受表单数据
			$goods = D("Goods");
			if (!empty($_POST)) {
				//判断福建是否有上传   如果有则实例化Upload，把附件传到服务器的指定位置,然后把附件的路径名或得到，存入$_POST
				if (!empty($_FILES)) {
					$config = array(
						'rootPath' => './public/',   //图片上传的根目录
						'savePath' => 'upload/',    		//保存路径
					);
					$upload = new \Think\Upload($config);
					//uploadOne会返回上传附件的信息
					$z = $upload ->uploadOne($_FILES['goods_img']);
					if (!$z) {
						show_bug($upload -> getError()); // 获得上传附件产生的信息
					}else{
						//拼装图片的路径名
						$bigimg = $z['savepath'].$z['savename'];
						$_POST['goods_big_img'] = $bigimg; 

						//把已经了的图片制作缩略图  Image.class.php
						$image = new \Think\Image();
						// open();  打开图像资源，通过路径名找到图像
						$srcimg = $upload -> rootPath.$bigimg;
						$image ->open($srcimg);
						$image ->thumb(150,150);
						$smallimg = $z['savepath']."small_".$z['savename'];
						$image ->save($upload -> rootPath.$smallimg);
						$_POST['goods_small_img'] = $smallimg;
					}
				}

				//$goods ->goods_price = 1213;
				//$goods ->goods_number = 56;
				//$goods ->goods_name = "xiaomi";

				//tp框架有方法实现数据收集  数据模型对象 ->create()  该方法对非法的字段会进行自动过滤
				$goods ->create();
				$z = $goods -> add();
				if ($z) {
					//展现一个提示界面，并做页面跳转
					//$this ->success("添加商品成功",U("Goods/showlist"));
					// echo "<script> location.href = 'http://localhost/shop/shop/index.php/Admin/Goods/showlist.html'</script>";
					// $this ->success("添加商品成功",U("Goods/showlist"));
					$this -> redirect('Goods/showlist');
					//echo "success";

				}else{
					// $this ->success("添加商品失败",U("Goods/showlist"));
					$this -> redirect('Goods/showlist');

					//echo "error";
				}

			}else{
				$this->display();
			}
		}

		//产品修改
		function update1(){
			//修改方式 ：  1. 数组方式修改数据   2.AR方式修改数据  同上add（）方法
			$goods= D("Goods");
			$ar = array(
				'goods_name' => "黑莓手机",
				'goods_price' => 2500,
				'goods_id'  => 7,   //注意必须指明需要修改的主键值
			);
			$ret = $goods  -> save($ar);
			//show_bug($ret);

			$this ->display();
		}


		function update($goods_id){
			//查询被修改的商品信息   并传递给页面展示
			$goods = D("Goods");
			if (!empty($_POST)) {

				if (!empty($_FILES)) {
					$config = array(
						'rootPath' => './public/',   //图片上传的根目录
						'savePath' => 'upload/',    		//保存路径
					);
					$upload = new \Think\Upload($config);
					//uploadOne会返回上传附件的信息
					$z = $upload ->uploadOne($_FILES['goods_img']);
					if (!$z) {
						show_bug($upload -> getError()); // 获得上传附件产生的信息
					}else{
						//拼装图片的路径名
						$bigimg = $z['savepath'].$z['savename'];
						$_POST['goods_big_img'] = $bigimg; 

						//把已经了的图片制作缩略图  Image.class.php
						$image = new \Think\Image();
						// open();  打开图像资源，通过路径名找到图像
						$srcimg = $upload -> rootPath.$bigimg;
						$image ->open($srcimg);
						$image ->thumb(150,150);
						$smallimg = $z['savepath']."small_".$z['savename'];
						$image ->save($upload -> rootPath.$smallimg);
						$_POST['goods_small_img'] = $smallimg;
					}
				}

				$goods -> create();  //收集表单数据
				$rst =$goods ->save();
				if ($rst) {
					// echo "<script> location.href = 'http://localhost/shop/shop/index.php/Admin/Goods/showlist.html'</script>";
					$this -> redirect('Goods/showlist');

				}else{
					echo "failure";
				}
			}else{
				$info = $goods->find($goods_id);
				$this ->assign('info',$info);
				$this ->display();
			}
		}
		function del($goods_id){

			$goods = D("Goods");
			//以下三种方式都可以删除数据
			$goods ->delete($goods_id);
			//$ret = $goods ->delete('7,8,9');
			//$ret = $goods ->where('goods_id =6') ->delete();
			//show_bug($ret);
			
			//echo "<script> location.href = 'http://localhost/shop/shop/index.php/Admin/Goods/showlist.html'</script>";
			$this -> redirect('Goods/showlist');

			$this ->display();
		}

		 //设置缓存
	    function s1(){
	        S('name','jack',10);
	        S('age',25);
	        S('addr','北京');
	        S('hobby',array('篮球','排球','棒球'));
	        echo "success";
	    }
	    
	    //读取缓存数据
	    function s2(){
	        echo S('name'),"<br />";
	        echo S('age'),"<br />";
	        echo S('addr'),"<br />";
	        print_r(S('hobby'));echo "<br />";
	    }
	    
	    function s3(){
	        //S('age',null);
	        echo "delete";
	    }
	    
	    function y1(){
	        //外部用户访问的方法
	        show_bug($this -> y2());
	    }
	    function y2(){
	        //被其他方法调用的方法，获得指定信息
	        //第一次从数据库获得，后续在有效期从缓存里边获得
	        $info = S('goods_info');
	        if($info){
	            return $info;
	        } else {
	            //没有缓存信息，就从数据库获得数据，再把数据缓存起来
	            //连接数据库
	            $dt = "apple5s".time();
	            S('goods_info',$dt,10);
	            return $dt;
	        }
	    }
	}
	
 ?>