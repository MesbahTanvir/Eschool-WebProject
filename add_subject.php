<?php
session_start();
include_once "database_object.php";
include_once "html_component_printer.php";

$database = new database_connect();

$subject_code = isset($_POST['subject_code']) ? $_POST['subject_code'] : "";
$subject_name = isset($_POST['subject_name']) ? $_POST['subject_name'] : "";

if($subject_code ==false or $subject_name ==false)
{
	$msg = "দয়া করে বিষয় ও বিষয়  কোড দুইটিই দিন।";
	$_SESSION['admin_msg'] = $msg;

	//header("Location: add_subject.php");	
	//exit();
}
elseif(isset($_COOKIE['admin_email'])) {

	$database -> add_subject($subject_code,$subject_name);
	if( $database -> error )
	{
		$msg = $database -> errmsg;
		$_SESSION['admin_msg'] = $msg;
		//header("Location: add_subject.php");	
	}
	else
	{
		$_SESSION['admin_msg'] = "বিষয় সফল ভাবে সংযুক্ত হয়েছে।";
		//header("Location: add_subject.php?msg=add subject successful");
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
		admin_nav("subject");
		?>
		
		
		
		
		
		<div align=center>
			<h3>নতু্ন বিষয় সংযুক্ত করো </h3>
			<form  method = "post" action="add_subject.php">
				বিষয়ের কোড: <br>
				<input type ="text" name = "subject_code"><br>
				বিষয়ের নাম: <br>
				<input type ="text" name = "subject_name"><br>
				<input class="button" type = "submit" name = "submit" value="জমা দাও">
			</form>
		</div>

	</body>	

</html>


