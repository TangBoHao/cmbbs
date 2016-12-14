<?php
require('../config/config.inc.php');
$email = stripslashes(trim($_POST['email'])); 
     
$sql = "select id,username,password,realname from `goblin_user` where `email`='$email'"; 
$query = mysql_query($sql); 
$num = mysql_num_rows($query); 
if($num==0){//该邮箱尚未注册！ 
    ExitMessage('该邮箱尚未注册！');
    exit;     
}else{ 
    $row = mysql_fetch_array($query); 
    $getpasstime = time(); 
    $id = $row['id']; 
    $token = md5($id.$row['username'].$row['password'].$row['realname']);//组合验证码 
    $url = "localhost/goblin/findpwd/reset.php?email=".$email." 
&token=".$token;//构造URL 
    $time = date('Y-m-d H:i'); 
    $result = sendEmail($time,$email,$url); 
    if($result==1){//邮件发送成功 
        $msg = '<p>系统已向您的邮箱发送了一封邮件</p><p>请登录到您的邮箱及时重置您的密码！</p>'; 
        //更新数据发送时间 
        mysql_query("update goblin_user set getpasstime='$getpasstime' where id='$id '"); 
    }else{ 
        $msg = $result; 
    } 
    echo $msg; 
} 

?>