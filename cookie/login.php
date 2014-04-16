<?php
include"common.inc.php";
$username = $_POST["name"];
$password = $_POST["password"];
$count = $_COOKIE["count"] ? $_COOKIE["count"] : 0;

// do authentication here
header("Content-type:text/html");
session_start();
include_once( './api/config.php' );
include_once( './api/saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );

if(!empty($_POST['submit'])){
	$mysqli = new mysqli('localhost','root','','test');
	$username = $_POST['username'];
	$password = MD5($_POST['password']);
	$sql = "select * from `user` where `username` = '$username' and `password` = '$password'";
	$query = $mysqli->query($sql);
	$row = $query->fetch_array();
	if ($row[0]){
	$_SESSION['id'] = $row['id'];
	header("Location:user.php");
	}
	else{
	echo "用户名或密码错误";
	}
	}

setcookie("mycookie_name", $username);
setcookie("count", ++$count);


<html>
<head>
<title>用户登录</title>
</head>
<body>
<center>
请正确输入用户名及密码
Welcome <? echo $_POST["name"] ?>!<br/>
You have visited the site <? echo $count ?> times.
<a href="logout.php">logout</a>
</body>
</html>
