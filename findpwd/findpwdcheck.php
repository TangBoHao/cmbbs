<?php
require('../config/config.inc.php');
$email = stripslashes(trim($_POST['email'])); 
     
$sql = "select id,username,password,realname from `goblin_user` where `email`='$email'"; 
$query = mysql_query($sql); 
$num = mysql_num_rows($query); 
if($num==0){//��������δע�ᣡ 
    ExitMessage('��������δע�ᣡ');
    exit;     
}else{ 
    $row = mysql_fetch_array($query); 
    $getpasstime = time(); 
    $id = $row['id']; 
    $token = md5($id.$row['username'].$row['password'].$row['realname']);//�����֤�� 
    $url = "localhost/goblin/findpwd/reset.php?email=".$email." 
&token=".$token;//����URL 
    $time = date('Y-m-d H:i'); 
    $result = sendEmail($time,$email,$url); 
    if($result==1){//�ʼ����ͳɹ� 
        $msg = '<p>ϵͳ�����������䷢����һ���ʼ�</p><p>���¼���������估ʱ�����������룡</p>'; 
        //�������ݷ���ʱ�� 
        mysql_query("update goblin_user set getpasstime='$getpasstime' where id='$id '"); 
    }else{ 
        $msg = $result; 
    } 
    echo $msg; 
} 

?>