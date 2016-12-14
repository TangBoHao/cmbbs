<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Goblin论坛</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="stylesheet" href="config/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	 <script src="config/bootstrap-3.3.7-dist/jquery-1.12.0.min.js"></script>
	 <script src="config/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<style>
		#packt{
			padding-top: 25px;
			padding-bottom: 25px;
			padding-right: 50px;
			padding-left: 50px;
		}
		
	</style>
</head>
<body>
	<div class="container">
	<!-- 头部内容开始 -->
	<div class="header">
	<h1>Goblin论坛</h1>
	<?php
	//判断用户是否已经登录
	if ($_SESSION['username']) {
	
	?>
	<!-- 用户没有登录的导航条 -->
	<strong><?php echo $_SESSION['username'];?>，欢迎登录</strong> | &nbsp;
	<a href="index.php">首页</a> | &nbsp;
	<a href="profile/view_profile.php">个人资料</a> | &nbsp;
	<a href="login/logoff.php">退出论坛</a>
	<?php }else{ ?>
	<!-- 用户没有登录的导航条 -->
	<strong>你好，游客！</strong>
	<a href="index.php">首页</a> | &nbsp;
	<a href="register/create_user.php">注册</a> | &nbsp;
	<a href="login/login.php">登录</a>
	<?php
	 }//判断结束
	?>
	<br>
	</div>
	<!-- 头部内容结束 -->

	<!-- 主要内容开始 -->
	<div id="packt">

