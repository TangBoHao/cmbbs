<?php
require('../config/config.inc.php');

header("Content-type:text/html;charset=utf-8");

$token = stripslashes(trim($_GET['token'])); //stripslashes — 反引用一个引用字符串
$email = stripslashes(trim($_GET['email'])); 

if($_POST['submit']){   
       $password=trim($_POST['password']);  
       $conf_pwd=trim($_POST['password']);  
       if ($password==$conf_pwd) {
          $password=md5($password);
          $sql="update goblin_user set password='$password' where email='$email'";
           $result=mysql_query($sql); 
           
           if($result){
            echo "密码重置成功，马上<a href='../login/login.php'>登录</a>";

           }else{
            ExitMessage("密码重置失败，数据库错误！");
           }
       }else{
        ExitMessage("新密码与确认密码不一致！");  
       }
      
    } else{
        
        $sql = "select * from goblin_user where email='$email'"; 
         
        $query = mysql_query($sql); 
        $row = mysql_fetch_array($query); 
        if($row){ 

            $mt = md5($row['id'].$row['username'].$row['password'].$row['realname']);

            if($mt==$token){ 
                if(time()-$row['getpasstime']>24*60*60){ //一天过期
                    $msg = '该链接已过期！'; 
                }else{ ?>
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Goblin论坛</title>
                         <meta name="viewport" content="width=device-width, initial-scale=1.0">
                         <link rel="stylesheet" href="../config/bootstrap-3.3.7-dist/css/bootstrap.min.css">
                         <script src="../config/bootstrap-3.3.7-dist/jquery-1.12.0.min.js"></script>
                         <script src="../config/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
                        <style>
                            form{
                                width: 90%;
                                height: 90%;
                                margin: 5% auto;
                            }
                        </style>
                    </head>
                    <body>
                    <div class="reset">
                   <form action="" method="post" role="form" class="form-horizontal">
                       <div class="form-group" form-group-xs>
                        <label for="password" class="col-xs-2 control=label">新密码</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="new password">
                        </div>
                       </div>
                       <div class="form-group" form-group-xs>
                        <label for="conf-pwd" class="col-xs-2 control=label">确认密码</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control" id="conf-pwd" name="conf-pwd" placeholder="confirm password">
                        </div>
                       </div>
                       <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <input type="submit" class="btn btn-primary" value="重置" name="submit">
                        </div>
                       </div>
                   </form>
                   </div>
                   </body>
                   </html>
                    <?php
                    
                } 
            }else{ 
                ExitMessage("无效的链接！");
            } 
        }else{ 
            ExitMessage("错误的链接");    
        } ?>
    <?php
    }



 
?>