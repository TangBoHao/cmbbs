<?php
/*注册处理程序*/

require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
//取得要提交的数据，并做处理
$username=ClearSpecialChars($_POST['username']);
$password=$_POST['password'];
$email=ClearSpecialChars($_POST['email']);
$realname=ClearSpecialChars($_POST['realname']);

//检查数据输入的合法性
if (!username) {
	ExitMessage('请输入用户名！');
}
if (!$password) {
	ExitMessage('请输入密码！');
}
if (!$email) {
	ExitMessage('请输入邮箱！');
}else if(!checkEmail($email)){
	ExitMessage('邮箱地址格式错误！');
}

//对密码进行MD5加密
$password=md5($password);

//判断用户是否已经存在
$sql="SELECT * FROM goblin_ser WHERE username='$username'";
$result=mysql_query($Sql);
$num_rows=@mysql_num_rows($result);
if ($num_rows>0) {
	ExitMessage('该用户已经存在！');
}

//创建用户
$sql="INSERT INTO goblin_user (username,password,email,realname,regdate) VALUES ('$username','$password','$email','$realname',NOW())";
$result=mysql_query($sql);
if ($result) {
	?>
	<h2>创建用户</h2>
	<p>您的用户账户已经建立，请单击<a href="../login/login.php">这里</a>登录。</p>
	<?php
}else{

	ExitMessage('用户创建失败，数据库错误！');
}
?>


