<?php
session_start();
include_once "database_object.php";
include_once "html_component_printer.php";

$database = new database_connect();

$subject_code = isset($_POST['subject_code']) ? $_POST['subject_code'] : "";
$chapter_name = isset($_POST['chapter_name']) ? $_POST['chapter_name'] : "";

if($chapter_name == false or $subject_code == false)
{
	$msg = "দয়া করে অধ্যায় ও বিষয় কোড দিন।";
	$_SESSION['admin_msg'] = $msg;
}
elseif(isset($_COOKIE['admin_email']))  {


	$database -> add_chapter($chapter_name,$subject_code);
	if($database -> error )
	{
		$msg = $database -> errmsg;
		$_SESSION['admin_msg'] = $msg;
	}
	else
	{
		$msg = "অধ্যায় সফল ভাবে সংযুক্ত হয়েছে।";
		$_SESSION['admin_msg'] = $msg;
	}
}
else {
	$msg = "লগইন অবস্থায় নেই";
	$_SESSION['admin_msg'] = $msg;
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
		admin_nav("chapter");
		?>
		<div align=center>

			<h3> নতুন অধ্যায় সংযুক্ত করো </h3>

			<form class = "add_data_form" method = "post">
				বিষয় নির্বাচন করো: <br>
				<select class="button" name="subject_code">

					<?php		
					$subjects = $database -> get_subjects();

					foreach( $subjects as $subjectcode => $subjectname){
						echo "<option value='$subjectcode'> $subjectname </option>";
					}
					?>

				</select> <br>
				নতুন অধ্যায়ের নাম: <br>
				<input type="text" name="chapter_name"><br>
				<input class="button" type="submit" name = "submit" value="জমা দাও" formaction="add_chapter.php">
			</form>
		</div>

	</body>	

</html>