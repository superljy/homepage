<?php
	header("content-type:application/json;charset=utf8");
	date_default_timezone_set('prc');
	require_once("connect.php");

	if ($link) {
		$sql = mysqli_query($link,"SELECT * FROM comments order by id desc");

		mysqli_query($link,"SET NAMES UTF8");

		while ($row=mysqli_fetch_array($sql)) {
			$comments[] = array("id" => $row['id'], "user" => $row['user'], "comment" => $row['comment'], "addtime" => $row['addtime'] );
		}

		echo json_encode($comments);
	}


?>

