<?php
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
if (!$_SESSION['username']) {
	ExitMessage("请<b>登录</b>后执行该请求。",'main.php');
}
//获取到数据
$username=$_SESSION['username'];
$email=ClearSpecialChars($_POST['email']);
$realname=ClearSpecialChars($_POST['realname']);
$password=ClearSpecialChars($_POST['password']);

if (!$password) {
	//如果密码为空，则密码项不予更新
	$sql="UPDATE goblin_user SET email='$email',realname='$realname' WHERE username='$username'";
}else{
	$password=md5($password);
	$sql="UPDATE goblin_user SET password='$password', email='$email',realname='$realname' WHERE username='$username'";
}
$result=mysql_query($sql);
if ($result) {
	?>
	<h2>个人资料更新成功</h2>
	<p>您的个人资料已经更新，请<a href="main.php">返回</a>论坛主页</p>
	<?php
}else{
	ExitMessage("记录不存在！");
}
?>