<?php
session_start();


echo "Hey Man";
if( isset($_COOKIE['user_email'] )){
	
	
	include_once "database_object.php";
	$database = new database_connect();
	$chapter_id = isset( $_POST['chapter_id'] ) ? $_POST['chapter_id']: "";
	$subject_code = isset( $_POST['subject_code'] ) ? $_POST['subject_code'] : "";
	$duration = isset( $_POST['duration'] ) ? $_POST['duration'] : "";
	$difficulty = isset( $_POST['difficulty'] ) ? $_POST['difficulty'] : "";
	
	
	session_destroy();
	session_start();
	if($chapter_id and $subject_code){
		$_SESSION['msg']="দয়া করে বিয়ষ অথবা  অধ্যায় নির্বাচন করো। দুইটি একসাথে নয় ! ";
		header("Locaion: mcq_exam_filter.php");
		die();
	}
	if( $chapter_id ){
		$mcqs = $database -> get_mcq_for_exam_by_chapter($chapter_id,$duration,$difficulty);
		if($database -> error){
			
			$_SESSION['msg'] = $database ->errmsg;
		
		}
		else {
			$_SESSION ['mcqs'] = $mcqs;
			$_SESSION ['chapter_id'] = $chapter_id;
			$_SESSION ['subject_code'] = "";
		}
		header("Location: mcq_exam_page.php");
		die();
	}
	elseif( $subject_code ){
		
		$mcqs = $database -> get_mcq_for_exam_by_subject($subject_code,$duration,$difficulty);
		if($database -> error){
			$_SESSION['msg'] = $database ->errmsg;

		}
		else {
			$_SESSION['mcqs'] = $mcqs;
			$_SESSION['subject_code'] = $subject_code;
			$_SESSION['chapter_id'] = "";
		}
		header("Location: mcq_exam_page.php");
		die();
	}
	else {
		$_SESSION['msg']="দয়া করে বিয়ষ  অথবা  অধ্যায় নির্বাচন করো।";
		header("Location: mcq_exam_filter.php");
		die();
	}
}
else {
	echo "fucked Up";
	$_SESSION['msg']="পরীক্ষা দিতে চাইলে অবশ্যই লগইন করতে হবে।";
	header("Location: mcq_exam_filter.php");
	die();
}
?>