<?php
	setcookie('user_id','',time()-100);
	setcookie('user_email','',time()-100);
	setcookie('admin_id','',time()-100);
	setcookie('admin_email','',time()-100);
	header("Location: index.php");
?>