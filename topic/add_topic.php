<?php
/*发表文章处理程序*/
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");

if (!$_SESSION['username']) {
	//如果用户未登录，显示提示信息
	include('header.inc.php');
	?>
<!-- 	如果用户未登录 -->
	<h3>游客，你好！</h3>
	<p>
		请<a href="../register/create_user.php">注册</a>新用户，或者进行<a href="../login/login.php">登录</a>。
	</p>
	<?php
	include('../config/footer.inc.php');
}else{
	//获得用户信息
	$username=$_SESSION['username'];
	$sql="SELECT * FROM goblin_user WHERE username='$username'";
	$result=mysql_query($sql);
	$info=mysql_fetch_array($result);
	//取得相应的详细信息
	//标题
	$topic=FilterBadWords($_POST['topic']);
	//正文
	$detail=FilterBadWords($_POST['detail']);
	//发帖人
	$name=$_SESSION['username'];
	//邮箱
	$email=$info['email'];
	//是否置顶
	$sticky=$_POST['sticky'];
	//是否锁定
	$locked=$_POST['locked'];
//var_dump($detail);
	//数据合法性检查
	if (!$topic) {
		ExitMessage("请输入标题！");
	}
	if (!$detail) {
		ExitMessage("请输入正文！");
	}

	//判断是否为锁定状态
	if ($locked=="on" && $name=="ADMIN_USER") {
		$locked=1;
	}else{
		$locked=0;
	}

	//判断是否置顶状态
	if ($sticky=="on" && $name=="ADMIN_USER") {
		$sticky=1;
	}else{
		$sticky=0;
	}
	//将数据插入数据库
	$sql="INSERT INTO goblin_topic (topic,detail,name,email,datetime,locked,sticky) VALUES ('$topic','$detail','$name','$email',NOW(),'$locked','$sticky')";
	//var_dump($sql);
	$result=mysql_query($sql) or die(mysql_error());

	if ($result) {
		//数据插入成功后，跳转至论坛主页面
		header("Location:../index.php");
	}else{
		ExitMessage("帖子发布失败，数据库错误！");
	}
}

?>