<?php

$host = "182.61.22.59";
$db_user = "root";
$db_pwd = "Xm8589!cn";
$db_name = "gzwanda";

// $host = "localhost";
// $db_user = "root";
// $db_pwd = "root";
// $db_name = "demo";

$link = mysqli_connect($host,$db_user,$db_pwd);
mysqli_select_db($link,$db_name);
// 设置文本字符
mysqli_query($link,"SET NAMES UTF8");
// 设置市区
date_default_timezone_set('prc');
// 设置每次获取的数据都是json形式
header("content-type:application/json;charset=utf-8");


?>