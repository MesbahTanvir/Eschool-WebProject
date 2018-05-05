<?php
	session_start();

	include_once "database_object.php";

	$post_email = isset($_POST['email'])?$_POST['email']:"";
	$post_password = isset($_POST['password'])?$_POST['password']:"";
	
	$database = new database_connect();
	
	$user = $database -> user_exist($post_email,$post_password);
	
	if($database -> error){
		
		$msg = $database -> errmsg;
		$_SESSION['msg'] = $msg;
		header("Location: signin_form.php");
		
		die();		
	}
	elseif($user){
		$user_id = $database -> get_user_id ($post_email);
		echo $user_id;
		setcookie( 'user_email', $post_email, time() + 604800);
		setcookie( 'user_id', $user_id, time() + 604800);
		$_SESSION['msg']="অভিনন্দন  সফল ভাবে প্রবেশ করেছ!";
 		header("Location: index.php");
		die();
	}
	else {
		$_SESSION['msg']="কোন ব্যবহারকারীর সাথে মিল পাওয়া যায় নি।";
 		header("Location: signin_form.php");
		die();
	}
?>