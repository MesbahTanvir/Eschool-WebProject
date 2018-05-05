<?php
	session_start();
	include_once "database_object.php";
	$database = new database_connect();
	$res = $_POST['ans'];

	$n = sizeof($_SESSION['mcqs']);

	$score=0;
	$right=0;
	$wrong=0;

	for ( $i = 0 ; $i < $n ; $i++){
		
		if(isset($_POST['ans'][$i])){
			if($_POST['ans'][$i] == $_SESSION['ans'][$i]){
				$_SESSION['verdict'][$i] = "সঠিক হয়েছে";
				$database -> add_submission($_COOKIE['user_id'],$_SESSION['mcqs'][$i],1);
				$score ++;
				$right ++;
			}
			else {
				$_SESSION['verdict'][$i] = "ভুল হয়েছে";
				$database -> add_submission ( $_COOKIE ['user_id'] , $_SESSION['mcqs'][$i],0);
				$score -= .25;
				$wrong++;
			}
		}
		else {
			$_SESSION['verdict'][$i] = "";
		}
	}
	
	$_SESSION['score'] = max(0,$score);
	$_SESSION['right'] = $right;
	$_SESSION['wrong'] = $wrong;
	header("Location: mcq_exam_summary.php");
	die();
?>