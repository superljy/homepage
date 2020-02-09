<?php
	header("content-type:application/json;charset=utf-8");
	date_default_timezone_set('prc');
	require_once("connect.php");

	if ($link) {
		$user = addslashes(htmlspecialchars($_POST["user"]));
		$txt = addslashes(htmlspecialchars($_POST["txt"]));
		$time = date("Y-m-d H:i:s");
		$query = mysqli_query($link,"INSERT INTO `comments` (`user`,`comment`,`addtime`) VALUES ('{$user}','{$txt}','{$time}')");
		mysqli_query($link,"SET NAMES UTF8");
		if ($query) {
			$data = array("code"=>1,"message"=>"success","user"=>$user,"txt"=>$txt);
			echo json_encode($data);
		}
	}



?>