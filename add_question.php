<?php 
session_start();
include_once "database_object.php";
include_once "html_component_printer.php";

//extract($_POST);
$question = isset($_POST['question']) ? $_POST['question'] : "";
$option_a = isset($_POST['option_a']) ? $_POST['option_a'] : "";
$option_b = isset($_POST['option_b']) ? $_POST['option_b'] : "";
$option_c = isset($_POST['option_c']) ? $_POST['option_c'] : "";
$option_d = isset($_POST['option_d']) ? $_POST['option_d'] : "";
$answer = isset($_POST['answer']) ? $_POST['answer'] : "";

$database = new database_connect();
if(isset($_COOKIE['admin_email'])){
	if($question and $option_a and $option_b and $option_c and $option_c and $answer){
		$mcq_id = $database -> add_question($question,$option_a,$option_b,$option_c,$option_c,$answer);


		foreach ( $subject_codes as $index => $subject_code){
			$database -> add_subject_mcq($subject_code,$mcq_id);
		}
		foreach ( $chapter_ids as $index => $chapter_id){
			$database -> add_chapter_mcq($chapter_id,$mcq_id);
		}
	}
	else {
		$_SESSION['admin_msg'] = "প্রতিটি খালি ঘর পূরণ কর।";
	}
}
else {
	$_SESSION['admin_msg'] = "লগইন অবস্থায় নেই";
}

?>
<html>
	<head>
		<title>
		</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
	</head>
	<body>

		<?php
		top_bar("admin");
		admin_nav("question");
		?>
		<div align=center>
			<h3> প্রশ্ন সংযুক্ত করো </h3>
			<form method="post">
				বিষয় নির্বাচন করো: <br>
				<select name="subject_codes[]" multiple required>

					<?php
					$subjects = $database -> get_subjects();
					foreach( $subjects as $subject_code => $subject_name)
					{
						echo "<option value='$subject_code'> $subject_name </option>";
					}
					?>

				</select> <br>
				অধ্যায় নির্বাচন করো: <br>
				<select name="chapter_ids[]" multiple required>

					<?php
					$chapters = $database -> get_chapters();
					//sort($data);

					foreach ($chapters as $chapter_id => 	$chapter_name){
						echo "<option value = '$chapter_id'> $chapter_name </option>";
					}
					?>

				</select> <br><br>
				প্রশ্ন: <br>
				<textarea cols="50" rows="5"  name="question"> </textarea> <br>
				ক <input type = "text" name="option_a"><br>
				খ <input type = "text" name="option_b"><br>
				গ <input type = "text" name="option_c"><br>
				ঘ <input type = "text" name="option_d"><br> <br>
				উত্তর <select name="answer" required> 
				<option value="a"> ক </option>

				<option value="b"> খ </option>

				<option value="c"> গ </option>

				<option value="d"> ঘ </option>
				</select>
				<br> <br>
				<input class="button" type="submit" name="AddQuestion" value ="জমা দাও" formaction="add_question.php"> <br> 
			</form>
		</div>


	</body>	

</html>
