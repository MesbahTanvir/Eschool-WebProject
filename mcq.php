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
		
		if(isset($_GET['mcq_id'])){
			$mcq_id =  $_GET['mcq_id'];
		}
		else {
			echo "<div class='errmsg'> আইডি দাও নি। </div>";
			echo "</body>";
			echo "</html>";
			die();
		}
		if($mcq_id==false){
			echo "<div class='errmsg'> আইডি দাও নি। </div>";
			echo "</body>";
			echo "</html>";
			die();
		}
		$mcq = $database -> get_mcq_by_id( $mcq_id );
		$answer = isset($mcq['answer'])?$mcq['answer']:"";
		$mcq_id = isset($mcq['mcq_id'])?$mcq['mcq_id']:"";
		$question = isset($mcq['question'])?$mcq['question']:"";
		$option_a=isset($mcq['option_a'])?$mcq['option_a']:"";
		$option_b=isset($mcq['option_b'])?$mcq['option_b']:"";
		$option_c=isset($mcq['option_c'])?$mcq['option_c']:"";
		$option_d=isset($mcq['option_d'])?$mcq['option_d']:"";
		
		$_SESSION['ans'] = $answer;
		$_SESSION['mcq_id'] = $mcq_id;
		if($mcq_id == false){
			echo "<div class = 'errmsg'>এই আইডির  কোন প্রশ্ন পাওয়া যায় নি।</div>";
			echo "</body> </html>";
			die();
		}
		$subject_names = array();
		$chapter_names = array();	
		$subject_names = $database -> get_subjects_by_mcq_id( $mcq_id );
		$chapter_names = $database -> get_chapters_by_mcq_id( $mcq_id );
		$right_answer  = $database -> get_right_answer( $mcq_id );
		$wrong_answer  = $database -> get_wrong_answer( $mcq_id );
		
		?>
		<div id='questionpaper'>
			<div align = center> 
				বিষয়ঃ
				<?php
				foreach( $subject_names as $index => $subject_name){
					echo $subject_name.' ';
				}
				?>
			</div>
			<div align = center> 
				অধ্যায়ঃ
				<?php 
				foreach( $chapter_names as $index => $chapter_name){
					echo $chapter_name.' ';
				}
				?>
			</div>
			<div align = center> 
				মোট ভুল উত্তরঃ <?php echo toBangla($wrong_answer); ?>   মোট ঠিক উত্তরঃ <?php echo toBangla($right_answer); ?>
			</div>

			<form method="post">
				<?php echo $question; ?> <br>
				<input type='radio' name='ans' value='a' > <?php echo $option_a; ?> <br>
				<input type='radio' name='ans' value='b' > <?php echo $option_b; ?> <br>
				<input type='radio' name='ans' value='c' > <?php echo $option_c; ?> <br>
				<input type='radio' name='ans' value='d' > <?php echo $option_d; ?> <br><br>
				<div align = center>  
					<input class ="button" formaction= "submit_mcq.php" type="submit" name = "submit" value="জমাদাও">
				</div>
			</form>
		</div>
	</body>
</html>
