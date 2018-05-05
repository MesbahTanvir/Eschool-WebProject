<?php
	session_start();

	include_once "database_object.php";

	$post_email = isset($_POST['email'])?$_POST['email']:"";
	$post_password = isset($_POST['password'])?$_POST['password']:"";
	
	$database = new database_connect();
	
	$admin = $database -> admin_exist($post_email,$post_password);
	
	if($database -> error){
		
		$msg = $database -> errmsg;
		$_SESSION['msg'] = $msg;
		header("Location: admin_login.php");
		
		die();		
	}
	elseif($admin){
		$admin_id = $database -> get_admin_id ($post_email);
		echo $admin_id;
		setcookie( 'admin_email', $post_email, time() + 604800);
		setcookie( 'admin_id', $admin_id, time() + 604800);
		$_SESSION['admin_msg']="অভিনন্দন  সফল ভাবে প্রবেশ করেছ!";
 		header("Location: admin_index.php");
		die();
	}
	else {
		$_SESSION['admin_msg']="কোন সম্পাদকের সাথে মিল পাওয়া যায় নি।";
 		header("Location: admin_login.php");
		die();
	}
?>