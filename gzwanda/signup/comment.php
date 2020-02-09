<?php
	header("content-type:application/json;charset=utf-8");
	date_default_timezone_set('prc');
	require_once("connect.php");

	if ($link) {
		$user = addslashes(htmlspecialchars($_POST["user"]));
		$phone = addslashes(htmlspecialchars($_POST["txt"]));
		$com = addslashes(htmlspecialchars($_POST["com"]));
		$time = date("Y-m-d H:i:s");
		$query = mysqli_query($link,"INSERT INTO `goodproduce` (`name`,`phone`,`company`,`addTime`) VALUES ('{$user}','{$phone}','{$com}','{$time}')");
		if ($query) {
			$data = array("code"=>1,"message"=>"success","user"=>$user,"phone"=>$phone,"company"=>$com);
			echo json_encode($data);
		}
	}

	mysqli_close($link);
?>