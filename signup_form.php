<html> 
	<head>
		<title>
		</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
	</head>
	<body>
		<?php session_start()?>
		
		<?php include_once "database_object.php"; ?>
		
		<?php include_once "html_component_printer.php"; ?>
		
		<?php top_bar("signup"); ?>
		
		<div class="signup_form">
			
			<form class ='signup_form' method = "post" action =signup_action.php>
				
				ইমেইল<br>
				<input type = "text" name = "email"> <br>
				সুরক্ষাকোড<br>
				<input type="password" name ="password">  <br>
				পুনরায় সুরক্ষাকোড<br>
				<input type="password" name ="repeat_password">  <br><br>
				<input class="button" type = "submit" value = "জমাদাও">
			
			</form>
		
		</div>

	</body>
</html>