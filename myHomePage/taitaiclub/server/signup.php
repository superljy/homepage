<?php
	header("content-type:application/json;charset=utf-8");
	date_default_timezone_set('prc');
	require_once("connect.php");

	if ($link) {
		$user = addslashes(htmlspecialchars($_POST["user"]));
		$txt = addslashes(htmlspecialchars($_POST["txt"]));
		$com = addslashes(htmlspecialchars($_POST["com"]));
		$job = addslashes(htmlspecialchars($_POST["job"]));
		$time = date("Y-m-d H:i:s");
		$query = mysqli_query($link,"INSERT INTO `baoming` (`name`,`phone`,`company`,`job`,`addTime`) VALUES ('{$user}','{$txt}','{$com}','{$job}','{$time}')");
		mysqli_query($link,"SET NAMES UTF8");
		if ($query) {
			$data = array("code"=>1,"message"=>"success","user"=>$user,"txt"=>$txt);
			echo json_encode($data);
		}
	}

	mysqli_close();
?>