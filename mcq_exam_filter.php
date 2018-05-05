<html>
	<head>
		<meta charset="UTF-8">
		<title>
		</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		

		<link href="style.css" rel="stylesheet">
	</head>
	
	<body>
	<?php session_start(); ?>
	<?php include_once "database_object.php"; ?>
	<?php include_once "html_component_printer.php"; ?>
	<?php top_bar(""); ?>
	<div align = center>
		<br><br><br>
	<h1>বহুনির্বাচনী পরীক্ষা</h1>
	<form  method ="post" text-align=center >
		
		<input class= "button" type = 'submit' name='StartExam' value = " বিষয় ভিত্তিক "  formaction="mcq_exam_filter_subject.php"> <br><br>
		<input class= "button" type = 'submit' name='StartExam' value = " অধ্যায় ভিত্তিক "  formaction="mcq_exam_filter_chapter.php">
	</form>	
		</div>
</body>
</html>