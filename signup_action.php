<?php
	session_start();
	include_once "database_object.php";

	extract($_POST,EXTR_PREFIX_ALL,'post');
	$post_email = isset($_POST['email']) ? $_POST['email'] : ""; 
	$post_password = isset($_POST['password']) ? $_POST['password'] : ""; 
	$post_repeat_password = isset($_POST['repeat_password']) ? $_POST['repeat_password'] : ""; 

	
	$database = new database_connect();
	
	$database -> signup_user($post_email,$post_password,$post_repeat_password);
	
	if($database -> error){
		
		$msg = $database -> errmsg;
		$_SESSION['msg'] = $msg;
		header("Location: signup_form.php");
		die();
	
	}
	else {
		$msg = "$post_email ইমেইলটি দিয়ে সফলভাবে একাউন্ট তৈরি হয়েছে!";
		$_SESSION['msg'] = $msg;
		header("Location: signin_form.php");
		die();
	}

?>