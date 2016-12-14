<?php
/*文章详情页*/
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
//根据ID获得帖子记录
$id=$_GET['id'];
$sql="SELECT * FROM goblin_topic WHERE id='$id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
//记录不存在
if (!$rows) {
	ExitMessage("该贴记录不存在！","../index.php");
}

//置顶标记
$sticky=$rows['sticky'];
?>
<?php
include('../config/header.inc.php');
?>
<h2><?php echo $rows['topic']; ?></h2>
<em class="info">
	由<a href="view._profile.php?id=<?php echo $rows['name']; ?>">
		<?php echo $rows['name'];   ?>
	</a>于<?php echo $rows['datetime'];  ?>创建
</em>

<p>
	<?php
	//输出整理好的内容
	$detail=nl2br(htmlspecialchars($rows['detail']));//nl2br —在字符串所有新行之前插入 HTML 换行标记;
	echo "<p class='lead'>".$detail."</p>";

	?>
</p>
<?php
if ($rows['locked']) {
	$locked=1;
}
?>
<hr size="1">
<dl>
	<?php
	//获取回复的内容
	$sql="SELECT * FROM goblin_reply WHERE topic_id='$id'";
	$result=mysql_query($sql);
	$num_rows=mysql_num_rows($result);


	if ($num_rows) {
		//循环输出记录内容
		while ($rows=mysql_fetch_array($result)) {
			?>
			<dt>
				<a href="profile/view_profile.php?id=<?php echo $rows['reply_name'];   ?>">
					<?php echo $rows['reply_name'];   ?>
				</a>
				-<em><?php echo $rows['reply_datetime'];   ?></em>
			</dt>
			<dd>
				<p>
					<?php
					//输出整理好的内容
					$reply_detail=nl2br(htmlspecialchars($rows['reply_detail']));
					echo $reply_detail;
					?>
				</p>
			</dd>
			<?php
		}//结束循环
	}else{
		echo "<p><strong>没有跟帖记录</strong></p>";
	}
	//浏览量加1
	$sql="UPDATE goblin_topic SET view=view+1 WHERE id='$id'";
	$result=mysql_query($sql);
	?>
</dl>


<!-- 内容回复表单开始 -->
<filedset>
	<legend>帖子回复</legend>
	<?php
	//判断用户是否已经登录
	if (!$_SESSION['username']) {
		echo '<p>请先<a href="../register/creat_user.php">注册</a>或<a href="../login/login.php">登录</a>后再回帖</p>';
	}else{
		//帖子已经诶被锁定
		if ($locked==1) {
			echo '<p><strong>该贴是被锁定的，无法回帖！</strong></p>';
		}else{
			?>
			<form action="../reply/add_reply.php" name="form1" method="post" id="reply" role="form" class="form-inline">
			<input type="hidden" name="id" value="<?php echo $id;  ?>">
				<table>
					<tr>
						<td valign="top" width="10%"><lable>回帖内容:</lable></td>
						<td>
							<textarea name="reply_detail" cols="45" rows="10" placeholder="Enter your reply"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
						<td><em>请不要使用HTML标签</em></td>
					</tr>
				</table>
				<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="submit" value="回复该贴" class="btn btn-success">
				<input type="reset" name="reset" class="btn btn-default">
			</form>
			<?php
		}
	
	?>
</filedset>
<br>
<!-- 内容回复表单结束 -->

<?php
//如果该用户是管理员，则输出“置顶”、“锁定”、“删除”按钮
if ($_SESSION['username']==ADMIN_USER) {
	?>
	<!-- 管理员操作表单开始 -->
	<fieldset>
		<legend>管理员操作</legend>

		<!-- 显示锁定操作按钮 -->
		<?php
		if ($locked==0) {
			?>
			<form action="../lock/lock_topic.php" name="lock" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<input type="submit" name="submit" value="锁定该贴" class="button">将该贴锁定，其他用户无法回复
			</form>
			<?php
		}else{
			?>
			<form action="../lock/unlock_topic.php" name="lock" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<input type="submit" name="submit" value="解除锁定" class="button">解除锁定，其他人可以回复
			</form>

			<?php
		}
		?>

		<!-- 显示置顶操作按钮 -->
		<?php
		if ($locked==0) {
			?>
			<form action="../stick/stick_topic.php" name="stick" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<input type="submit" name="submit" value="置顶该贴" class="button">将该贴置顶
			</form>
			<?php
		}else{
			?>
			<form action="../stick/unstick_topic.php" name="lock" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<input type="submit" name="submit" value="解除置顶" class="button">取消置顶
			</form>

			<?php
		}
		?>
	<!-- 显示删除操作按钮 -->
	<form action="../topic/del_topic.php" name="delete" method="get">
		<input type="hidden" name="id" value="<?php echo $id;  ?>">
		<input type="submit" name="submit" value="删除帖子" class="button">
		删除该贴与回复内容
	</form>
	</fieldset>
	<?php
}
}
?>
<?php
include('../config/footer.inc.php');
?>

