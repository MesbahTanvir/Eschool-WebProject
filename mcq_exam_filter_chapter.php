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
	<?php 
		$database = new database_connect();
		$subjects = $database -> get_subjects();
		$chapters = $database -> get_chapters(); 
	?>
	<div align = center>

	<form  method ="post" text-align=center >
		<h1> অধ্যায় ভিত্তিক বহুনির্বাচনী পরীক্ষা</h1> 
		<h3> অধ্যায় </h3>  
		<select  class="button" name ="chapter_id"> 
			<?php 
					foreach($chapters as $chap_id => $chap_name){
						echo "<option value = '$chap_id'> $chap_name </option>";
					}
			?>
		</select> <br>
		
		 <h3> সময় </h3>   
		<select  class="button" name = "duration">
			<option value = "10"> ১০ মিনিট </option>
			<option value = "20"> ২০ মিনিট </option>
			<option value = "30"> ৩০ মিনিট </option>
			<option value = "45"> ৪৫ মিনিট </option>
			<option value = "60"> ১ ঘণ্টা </option>
			
		</select><br>
		 <h3> ধরন </h3>
		<select   class="button" name = "difficulty">
			<option value = "easy"> সহজ </option>
			<option value = "medium">মধ্যম </option>
			<option value = "hard"> কঠিন </option>
			
		</select><br> <br>
		<input class= "button" type = 'submit' name='start exam' value = "শুরু করো"  formaction="mcq_exam_filter_action.php">
	</form>	
		</div>
</body>
</html>