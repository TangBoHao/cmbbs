<?php
/*用户资料修改*/
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
//用户名
$username=$_SESSION['username'];
//如果用于没有登录
if (!$username) {
	ExitMessage("请<b>登录</b>后执行该请求。",'../index.php');
}
?>
<?php
include('../config/header.inc.php');
?>
<h2>编辑个人资料</h2>
<?php
//查询用户资料
$sql="SELECT * FROM goblin_user WHERE username='$username'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
?>
<fieldset>
	<legend>个人资料</legend>
	<form action="update_profile.php" method="post">
		<table>
			<tr>
				<td>登录用户：</td>
				<td><?php echo $rows['username'];  ?></td>
			</tr>
			<tr>
				<td>更新密码：</td>
				<td><input type="password" name="password">密码留空，将不被更新</td>
			</tr>
			<tr>
				<td>电子邮件：</td>
				<td><?php echo $rows['email'];  ?></td>
			</tr>
			<tr>
				<td>真实姓名：</td>
				<td><?php echo $rows['realname'];  ?></td>
			</tr>
		</table>
		<br><br>
		<input type="submit" name="submit" class="button" value="更新个人资料">
	</form>
</fieldset>
<?php
include('../config/footer.inc.php');
?>