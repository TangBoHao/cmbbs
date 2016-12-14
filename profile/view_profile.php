<?php
/*查看用户资料*/
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
$username=$_SESSION['username'];

//取得用户信息
$sql="SELECT * FROM goblin_user WHERE username='$username'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

if (!$rows) {
	ExitMessage("用户记录不存在！");
}

//用户发帖正文数
$sql="SELECT * FROM goblin_topic WHERE name='".$id."'";
$count_q=mysql_query($sql);
$num_count_q=mysql_fetch_array($count_q);

//用户回复贴数
$sql="SELECT * FROM goblin_reply WHERE name='".$id."'";
$count_a=mysql_query($sql);
$num_count_a=@mysql_fetch_array($count_a);

//计算用户发表的帖子数量
$num_count=$num_count_p+$num_count_a;
?>

<?php
include('../config/header.inc.php');
?>
<?php
//改写电子邮件地址
$mail=$rows['email'];
$mail=str_replace("@", "[at]", $mail);
$mail=str_replace(".", "[dot]",$mail);
?>
<fieldset>
	<legend>个人资料</legend>
	<br>
		<table class="table">
			<tr>
				<td><strong>真实姓名</strong></td>
				<td><?php echo $rows['realname'];  ?></td>
			</tr>
			<tr>
				<td><strong>电子邮件</strong></td>
				<td><?php echo $mail;  ?></td>
			</tr>
			<tr>
				<td><strong>发帖数量</strong></td>
				<td><?php echo $num_count;  ?></td>
			</tr>
		</table>
		<br>
		<input type="button" value="返回首页" onclick="location.href='../index.php'" class="button btn-success btn-xs">
</fieldset>
<?php
include('../config/footer.inc.php');
?>
