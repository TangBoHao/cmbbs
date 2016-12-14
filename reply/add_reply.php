<?php
/*文章添加处理程序*/
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
//判断用户是否登录
if (!$_SESSION['username']) {
	ExitMessage("<b>登录</b>后执行该请求。","../login/login.php");
}

//回帖的ID
$id=$_POST['id'];

//验证帖子已经存在，没有被锁定
$sql="SELECT * FROM Goblin_topic WHERE id='$id'";
$result=mysql_query($sql);
$topic_info=mysql_fetch_array($result);

if (!$topic_info) {
	ExitMessage('帖子记录不存在！','../index.php');
}else if($topic_info['locked']){
	ExitMessage('该贴已被锁定，无法进行回复。','../index.php');
}

//取得用户信息
$username=$_SESSION['username'];
$sql="SELECT * FROM goblin_user WHERE username='$username'";
$result=mysql_query($sql);
$user_info=mysql_fetch_array($result);

//取得提交过来的数据
$reply_name=$_SESSION['username'];
$reply_email=$user_info['email'];
$reply_detail=filterBadWords($_POST['reply_detail']);
if (!$reply_detail) {
	ExitMessage('没有回帖记录！','../index.php');
}
//取得reply_id的最大值
$sql="SELECT Count(reply_id) AS MaxReplyId FROM goblin_reply WHERE topic_id='$id'";
$result=mysql_query($sql);
$rows=mysql_fetch_row($result);

//将reply_id最大值+1,如果没有该值，则设置为1
if ($rows) {
	$Max_id=$rows[0]+1;
}else{
	$Max_id=1;
}
//插入回复的数据
$sql="INSERT INTO goblin_reply (topic_id,reply_id,reply_name,reply_email,reply_detail,reply_datetime) VALUES ('$id','$Max_id','$reply_name','$reply_email','$reply_detail',NOW())";
$result=mysql_query($sql);

if ($result) {
	//跟新reply字段
	$sql="UPDATE Goblin_topic SET reply='$Max_id' WHERE id='$id'";
	$result=mysql_query($sql);

	//页面跳转
	header("Location:../topic/view_topic.php?id=$id");
}else{
	ExitMessage("记录不存在！");
}

?>