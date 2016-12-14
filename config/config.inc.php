<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);  //设定错误提示等级
/*连接数据库的定义*/
define('DB_USER','root');
define('DB_PASSWORD','123456');
define('DB_HOST','localhost');
define('DB_NAME','goblin');    

/*管理员用户*/
define('ADMIN_USER','admin');

//分页设置，每页最多显示的记录数
define('EACH_PAGE',10);

//无效的字符，用于ClearSpecialChars()函数
$invalidchars=array(
	"'",
	";",
	"=",
	"\\",
	"/"
	);
//“bad字”数组，用于FilterBadWords()
$badwords=array(
	"/fuck/","/shit/","/wanker/","/cunt/","/gay/","/nigger/","/bastard/","/tosser/","/dipshit/"
	);

/*公共函数设置*/

//检查邮箱格式是否正确
function CheckEmail($email){
	$check="/^[0-9a-zA-Z_-]+@[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+){0,3}$/";

	if (preg_match($check, $email)) {
		return true;
	}else{
		return false;
	}
}

//显示错误信息和返回的链接地址，并终止程序的执行
function ExitMessage($message,$url=''){
	echo '<p class="message">';
	echo $message;
	echo '<br>';
	if ($url) {
		echo '<a href="'.$url.'">返回</a>';
	}else{
		echo '<a href="#" onclick="window.history.go(-1);">返回</a>';
	}
	echo '</p>';
	exit;
}


//清楚字符串中的特殊字符
function ClearSpecialChars($str){
	global $invalidchars;

	$str=trim($str);
	$str=str_replace($invalidchars, "", $str);
	return $str;
}

//"bad字"处理函数
function FilterBadWords($str){
	global $badwords;

	//替代数组
	$replacements=array("[censored]","***");

	for($i=0;$i<sizeof($badwords);$i++){
		//随机函数发生器
		srand((double)microtime()*1000000);

		//生成随机代码
		$rand_key=(rand()%sizeof($replacements));
		$str=str_replace($badwords[$i], $replacements[$rand_key], $str);
	}
	return $str;
}

   //发送邮件 
function sendEmail($time,$email,$url){ 
    include_once("email.class.php"); 
    $smtpserver = "smtp.163.com"; //SMTP服务器，如smtp.163.com 
    $smtpserverport = 25; //SMTP服务器端口 
    $smtpusermail = "15927264478@163.com"; //SMTP服务器的用户邮箱 
    $smtpuser = "15927264478@163.com"; //SMTP服务器的用户帐号 
    $smtppass = ""; //SMTP服务器的用户密码 
    $smtp = new Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);  
    //这里面的一个true是表示使用身份验证,否则不使用身份验证. 
    $emailtype = "HTML"; //信件类型，文本:text；网页：HTML 
    $smtpemailto = $email; 
    $smtpemailfrom = $smtpusermail; 
    $emailsubject = "Goblin - 找回密码"; 
    $emailbody = "亲爱的".$email."：<br/>您在".$time."提交了找回密码请求。请点击下面的链接重置密码 
（按钮24小时内有效）。<br/><a href='".$url."'target='_blank'>".$url."</a>"; 
    $rs = $smtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype); 
 
    return $rs; 
}

/*初始化程序*/

//连接数据库
$db=@mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
if (!$db) {
	die('<b>数据库连接失败！</b>');
	exit;
}
//选择数据库
mysql_select_db(DB_NAME);
mysql_query("SET NAMES UTF8");



?>