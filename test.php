<?php 
	include_once "database_object.php";
	$database = new database_connect();
	$res = $database -> get_mcq_for_exam_by_chapter(39,1,"easy");
	print_r($res);

?>