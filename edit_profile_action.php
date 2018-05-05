<?php
session_start();
include_once "database_object.php";
$database = new database_connect();

$password = isset( $_POST['password'] )? $_POST['password'] : "";
$first_name = isset( $_POST['first_name'] )? $_POST['first_name'] : "";
$last_name = isset( $_POST['last_name'] )? $_POST['last_name'] : "";
$email = isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : "";
$pass1 = isset($_POST['n_password']) ? $_POST['n_password'] :"";
$pass2 = isset($_POST['r_n_password']) ? $_POST['r_n_password'] :"";
$gender = isset($_POST['gender']) ? $_POST['gender'] : "";


if( $database -> user_exist( $email , $password ) ) {

	$msg="";
	if( $first_name ){

		$database -> change_first_name( $email, $first_name);
		if($database -> error ) {
			$msg = $msg . $database -> errmsg;
		}

		else {
			$msg = $msg."প্রথম নাম সফলভাবে পরিবর্তিত হয়েছে। <br>";
		}
	}
	if( $last_name ){
		$database -> change_last_name( $email, $last_name);
		if($database -> error ) {
			$msg = $msg . $database -> errmsg;
		}
		else {
			$msg =$msg. "শেষ  নাম সফলভাবে পরিবর্তিত হয়েছে। <br>";
		}
	}
	if($gender){
		$database -> change_gender($email,$gender);
		if($database -> error ) {
			$msg = $msg . $database -> errmsg;
		}
		else {
			$msg =$msg."লিঙ্গ সফলভাবে পরিবর্তিত হয়েছে। <br>";
		}
	}


	if($pass1!="" or $pass2!=""){
		if($pass1!=$pass2){
			$msg = $msg.'নতুন সুরক্ষাকোড দুইটি একই  নয়।<br>';
		}
		else {
			$database -> 	change_password($email,$pass1);
			if($database -> error ) {
				$msg = $msg . $database -> errmsg;
			}
			else {
				$msg =$msg. "সুরক্ষাকোড সফলভাবে পরিবর্তিত হয়েছে।<br>";
			}	
		}

	}

	if(isset($_FILES['image'])){
		$errors= array();
		$file_name = $_FILES['image']['name'];
		$file_size =$_FILES['image']['size'];
		$file_tmp  =$_FILES['image']['tmp_name'];
		$file_type =$_FILES['image']['type'];
		$list = explode('.',$file_name);
		$file_ext = end($list);
		$file_ext=strtolower($file_ext);

		$expensions= array("jpeg","jpg","png");

		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
			$msg = $msg."ফাইল টাইপ সমর্থিত নয়।<br>";
		}

		if($file_size > 2097152){
			$errors[]='File size must be excately 2 MB';
			$msg = $msg.'ফাইলটি অনেক বড় , আরও ছোট  ফাইল চেষ্টা  কর।<br>';
		}
		$file_name = "profile_img_".$_COOKIE['user_id'];
		echo $file_name;
		
		if(empty($errors)==true){
			move_uploaded_file($file_tmp,"images/".$file_name);
			$msg=$msg.'ছবিটি সফলভাবে আপডেট হয়েছে';
		}else{
			print_r($errors);
		}
	}
	$_SESSION['msg'] = $msg;
	header("Location: profile.php");
	die();


}
else {

	$msg = "দুঃক্ষিত তথ্য উপযুক্ত ছিল না। তোমার বর্তমান সুরক্ষাকোড দিয়েছিলে তো?";
	$_SESSION['msg'] = $msg; 
	header("Location: profile.php");
	die();
}
?>