<?php
/*发表文章页面*/
require('../config/config.inc.php');
include('../config/header.inc.php');
header("Content-type:text/html;charset=utf-8");
?>
<div class="h3">创建新帖子</div><br><br>
<?php

if (!$_SESSION['username']) {
?>
<!-- 如果用户未登录 -->
<h3>游客，你好！</h3>
<p>
	请<a href="../register/create_user.php">注册</a>新用户，或者进行<a href="../login/login.php">登录</a>。
</p>
<?php
}else{
//用户已经登录，显示输入表单
?>

<form action="add_topic.php" method="post" id="postcomment" role="form" class="form-horizontal">
	<div class="form-group" form-group-lg>
		<label for="topic" class="col-xs-2 control=label">话题</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="topic" name="topic" placeholder="Enter your topic title">
		</div>
	</div>
	<div class="form-group" form-group-lg>
		<label for="detail" class="col-xs-2 control=label">正文</label>
		<div class="col-sm-4">
			<textarea name="detail" id="detail" cols="50" rows="10" placeholder="Enter your comments"></textarea>
		</div>
	</div>
	<?php
	//如果是管理员，将显示置顶和锁定功能
	if ($_SESSION['username']=='ADMIN_USER') {
	?>
	<br>将帖子置顶<input type="checkbox" name="sticky" value="on"> 
	<br>锁定该帖子<input type="checkbox" name="locked" value="on"> 
	<?php
	}
	?>
	<br><br>
	<input type="submit" value="立即发布" class="button" name="submit">
	<input type="reset" name="reset" class="button">
</form>
<div class="h4"><abbr>发言注意事项</abbr></div>
<ul>
	<li>所有项目必须填写</li>
	<li>在标题和和正文中不能使用HTML代码</li>
	<li>为了安全起见，请不要在论坛中透露密码等重要信息</li>
</ul>
<?php
}
?>
<?php
//引入公用尾部部分
include('../config/footer.inc.php');
?>

