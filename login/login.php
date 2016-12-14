<?php
/*用户登录*/
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
if ($_POST['submit']) {
	$username=$_POST['username'];
	$password=md5($_POST['password']);

	//从数据库中检索用户名密码是否匹配
	$sql="SELECT * FROM goblin_user WHERE username='$username' AND password='$password'";
	$result=mysql_query($sql);
	$num_rows=@mysql_num_rows($result);

	if ($num_rows==1) {
		//获得用户名
		$row=mysql_fetch_assoc($result);
		//将用户名存入SESSION中
		$_SESSION['username']=$row['username'];
		//跳转到Goblin论坛主页面
		header('Location:../index.php');
	}else{
		ExitMessage("用户名或密码错误","login.php");
	}
}else{
	//引用公用头部
	include('../config/header.inc.php');
	?>
		<div class="h3">用户登录</div><br><br>	
	
		<!-- <legend>Goblin用户登录</legend> -->
		<form action="login.php" method="post" role="form" class="form-horizontal">
				<div class="form-group" form-group-lg>
					<label for="username" class="col-sm-1 control=label">Username</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="username" name="username" placeholder="username">
					</div>
				</div>
				<div class="form-group" form-group-sm>
					<label for="password" class="col-sm-1 control=label">Password</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="password" name="password" placeholder="password">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-4">
						<input type="submit" class="btn btn-primary" value="Login" name="submit">&nbsp;
						<a href="../findpwd/findpwd.html">忘记密码？</a>
					</div>
				</div>
		</form>

<?php
}
//引入公用尾部
include('../config/footer.inc.php');
?>