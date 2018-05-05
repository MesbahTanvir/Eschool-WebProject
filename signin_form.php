<html> 
	<head>
		<title>
		</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">

	</head>
	<body>


		<?php session_start();  ?>
		<?php include_once "html_component_printer.php"  ?>
		<?php top_bar("signin") ?>
		
		<div class= "signin_form">
			<form  method = "post" action =signin_action.php>
				ইমেইল<br>
				<input type = "text" name = "email"> <br>
				সুরক্ষাকোড<br>
				<input type="password" name ="password">  <br>
				<br>
				<input class="button" type = "submit" value = "জমাদাও" name="submit">
			</form>
		</div>

	</body>
</html>