<html>
<head>
	<title>
	</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
</head>
<body>

	<?php
			session_start();
			
	 		include_once "database_object.php";
			include_once "html_component_printer.php";
			top_bar("admin");
			echo "<br><br><br>";
			if(isset($_COOKIE['admin_email'])) 
				admin_nav("");
			else {
				echo "<div class='errmsg' > প্রশাসনিক কাজে অংশ নিতে সম্পাদক অথবা প্রশাসক এর প্রোফাইল দিয়ে প্রবেশ করতে হবে। </div>";
			}
	?>
	
	
	
	
	
</body>	
	
</html>