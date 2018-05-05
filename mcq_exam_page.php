<html>
	<head>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
	</head>
	<body>
		<?php
		session_start();

		include_once "database_object.php";
		include_once "converter.php";
		include_once "html_component_printer.php";

		$database = new database_connect();

		top_bar("exam");
		?>
		
		<div id='questionpaper'>
			
		<div align=center> প্রশ্নপত্র </div>
		<?php
			
		$subject_name="";
		$chapter_name="";
		
		if(isset($_SESSION['subject_code'])){
			
			$subject_code = $_SESSION['subject_code'];
			$subject_name = $database ->get_subject_name($subject_code);
		
		}
		else if(isset($_SESSION['chapter_id'])){
		
			$chapter_id = $_SESSION['chapter_id'];
			
			$chapter_name = $database ->get_chapter_name($chapter_id);
		}
		if($subject_name){
			
			echo "<div align=center>বিষয় ভিত্তিক বহুনির্বাচনি পরীক্ষা <br>বিষয়: $subject_name</div>";
		}
		else if($chapter_name){
			
			echo "<div align=center> অধ্যায় ভিত্তিক বহুনির্বাচনি পরীক্ষা <br> অধ্যায়: $chapter_name</div>";
		}
		else {
			
		}
		

		$mcq_ids = $_SESSION['mcqs'];
		$mcqs = array();
		foreach ( $mcq_ids as $index => $mcq_id){
			$mcqs[] = $database -> get_mcq($mcq_id);
		}
		?>
			<form method="post" action="mcq_exam_evaluate_action.php" text-align=center> 

				<?php	
				$res= array();
				$_SESSION['ans'] = array();
				foreach($mcqs as $index => $mcq){
					extract($mcq);
					echo ('('.toBangla($index+1).') '.$question.'<br>');
					echo "<div class = 'mcq_option'>";
					echo "<input type='radio' name = 'ans[$index]' value='a'> $option_a ";
					echo "<input type='radio' name = 'ans[$index]' value='b'> $option_b <br>";
					echo "<input type='radio' name = 'ans[$index]' value='c'> $option_c ";
					echo "<input type='radio' name = 'ans[$index]' value='d'> $option_d <br>";
					echo "<br>";
					echo "</div>";
					$_SESSION['ans'][] = $answer;
				}
				?>
				<div align = center> <input class = "button" type="submit" name = "submit" value="জমাদাও">
				</div>
			</form>
		</div>
	</body>


</html>
