<?php
/*取消置顶操作*/
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
//判断是否为管理员
if ($_SESSION['username']==ADMIN_USER) {
	//取得文章ID
	$id=$_POST['id'];

	//取消置顶
	$sql="UPDATE goblin_topic SET sticky='0' WHERE id='$id'";
	$result=mysql_query($sql);
	if ($result) {
		//跳转页面
		header("Location:../topic/view_topic.php?id=$id");
	}else{
		ExitMessage("取消置顶失败，数据库错误！");
	}
}else{
	ExitMessage("你没有管理员权限，不能执行取消置顶操作！");
}

?>