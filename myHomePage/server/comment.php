<?php
	header("content-type:application/json;charset=utf-8");
	date_default_timezone_set('prc');
	// require_once("connect.php");
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

	if ($link) {
		$user = addslashes(htmlspecialchars($_POST["user"]));
		$txt = addslashes(htmlspecialchars($_POST["phone"]));
		$com = addslashes(htmlspecialchars($_POST["com"]));
		$remark = addslashes(htmlspecialchars($_POST["mark"]));
		$time = date("Y-m-d H:i:s");
		$query = mysqli_query("INSERT INTO `newyear` (`name`,`phone`,`company`,`remark`,`addTime`) VALUES ('{$user}','{$txt}','{$com}','{$remark}','{$time}')");
		mysqli_query($link,"SET NAMES UTF8");
		if ($query) {
			$data = array("code"=>1,"message"=>"success","user"=>$user,"txt"=>$txt);
			// $data = "{code:1,message:"success",user:"$user",phone:"$phone"}"
			echo json_encode($data);
		}
	}

	mysqli_close($link);
?>