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

			<div align=center> ফলাফল পত্র </div>
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
			$score = $_SESSION['score'];
			$score = round($score);
			$score = toBangla($score);
			$right = toBangla($_SESSION['right']);
			$wrong = toBangla($_SESSION['wrong']);
			echo "<div align =center> প্রাপ্তমান: $score</div>";
			echo "<div align =center> সঠিকঃ $right টি  ভুলঃ $wrong টি </div>";

			$mcq_ids = $_SESSION['mcqs'];
			$mcqs = array();
			foreach ( $mcq_ids as $index => $mcq_id){
				$mcqs[] = $database -> get_mcq($mcq_id);
			}		
			$res= array();
			$_SESSION['ans'] = array();
			foreach($mcqs as $index => $mcq){
				extract($mcq);
				$mcq_id = $mcq_ids[$index];
				echo "<a target='_blank' href='mcq.php?mcq_id=$mcq_id'>";
					echo ('('.toBangla($index+1).') '.$question.'<br>');
				echo "ফলাফল: ". $_SESSION['verdict'][$index];
				echo "<br><br>";
				echo '</a>';
			}
			?>
		</div>
	</body>


</html>
