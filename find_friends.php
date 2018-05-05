<?php
session_start();
if(isset($_GET['submit'])){
	if(isset($_GET['email'])){
		$email = $_GET['email'];
		if($email){
			header("Location: profile.php?email=$email");
			die();
		}
	}
	elseif(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		if($user_id){
			header("Location: profile.php?user_id=$user_id");
			die();
		}
	}
	else{
		$_SESSION['msg'] = "দয়া করে আইডি অথবা ইমেইল দাও।";
	}
}

?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>

		<meta charset="UTF-8">
		<title>
		</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">

	</head>

	<body>
		<?php include_once "html_component_printer.php";  ?>
		<?php top_bar(""); ?>



		<br><br><br>
		<h1> </h1>
		<div align = center> 
			<form method="get">
				<div> 
					বন্ধুর ইমেইলঃ <input type="text" name="email" >
					<input class="button"  type="submit" value = "খুজো" name="submit"> <br>
					<br>
				</div>
				<br><br>
				<div>
					বন্ধুর আইডিঃ <input type="text" name="user_id">
					<input class="button" type="submit" value = "খুজো" name="submit"><br>
				</div>
			</form>

		</div>

	</body>
</html>