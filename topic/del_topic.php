<?php
/*删除文章操作处理*/

require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
//判断是否为管理员
if ($_SESSION['username']==ADMIN_USER) {
	//取得文章ID
	$id=$_POST['id'];

	//删除文章
	$sql="DELETE * FROM goblin_topic WHERE id='$id'";
	$result=mysql_query($sql);
	//删除回复
	$sql2="DELETE * FROM goblin_topic WHERE id='$id'";
	$result=mysql_query($sql2);
	if ($result AND $result2) {
		//跳转页面
		header("Location:../index.php");
	}else{
		ExitMessage("删除失败，数据库错误！");
	}
}else{
	ExitMessage("你没有管理员权限，不能执行删除操作！");
}



?>