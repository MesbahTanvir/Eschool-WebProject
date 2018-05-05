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
		<?php session_start(); ?>
		<?php include_once "html_component_printer.php"  ?>
		<?php top_bar("home") ?>
		<br>
		<br>
		
		<div align=center>
			<form action="mcq_exam_filter.php" method="post" text-align=center>  <input  class ="button" type="submit"  name=" বহুনির্বাচনী পরীক্ষা " value=" বহুনির্বাচনী পরীক্ষা"> </form>
			
		</div> <br>

		<div align=center>
			<form action="find_friends.php" method="post" text-align=center>  <input  class ="button" type="submit"  name=" বন্ধুকে খুঁজো " value=" বন্ধুকে খুঁজো "> </form>
			
		</div> <br>
		<div align=center>
			<form action="rank_list.php" method="post" text-align=center>  <input  class ="button" type="submit"  name=" বন্ধুকে খুঁজো " value=" মেধা তালিকা  "> </form>
			
		</div>
		
	</body>
</html>