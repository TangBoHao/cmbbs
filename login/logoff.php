<?php
require('../config/config.inc.php');
header("Content-type:text/html;charset=utf-8");
//清空SESSION
$_SESSION=array();
session_unset();
session_destroy();

header("Location:../index.php");


?>