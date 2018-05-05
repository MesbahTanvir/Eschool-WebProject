<?php
	session_start();
	include_once "database_object.php";
	$database = new database_connect();

	$mcq_id = $_SESSION['mcq_id'];

	if($_POST['ans'] == $_SESSION['ans']){
		if(isset($_COOKIE['user_id']))
		   $database -> add_submission($_COOKIE['user_id'],$mcq_id,1);
		session_destroy();
		session_start();
		$_SESSION['msg']="উত্তর ঠিক হয়েছে";
		header("Location: mcq.php?mcq_id=$mcq_id");
	}
	else {
		if(isset($_COOKIE['user_id']))
		$database -> add_submission ( $_COOKIE ['user_id'] , $mcq_id,0);
		session_destroy();
		session_start();
		$_SESSION['msg'] ="উত্তর ভুল হয়েছে!";
		//print_r($_SESSION);
		header("Location: mcq.php?mcq_id=$mcq_id");

	}
	

?>