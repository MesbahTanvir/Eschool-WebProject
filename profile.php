

<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
	</head>

	<body>
		<?php session_start(); ?>
		<?php include_once "html_component_printer.php"; ?>
		<?php include_once "database_object.php";  ?>
		<?php include_once "converter.php";  ?>
		<?php top_bar("profile"); ?>

		<?php

		$database = new database_connect();

		$email = isset($_GET['email'])?$_GET['email'] : "";
		$user_id = isset($_GET['user_id'])?$_GET['user_id'] : "";
		if($email){
			$user_id = $database -> get_user_id($email);
			if($database -> error){
				$msg = $database -> errmsg;
				$_SESSION['msg'] = $msg;
				header("Location: find_friends.php");
			}
		}
		else if($user_id){
			$email = $database -> get_user_email($user_id);
			if($database -> error){
				$msg = $database -> errmsg;
				$_SESSION['msg'] = $msg;
				header("Location: find_friends.php");
			}
		}
		else {
			$email = $_COOKIE['user_email'];
			$user_id = $_COOKIE['user_id'];
		}


		$result = $database -> get_user_profile_info($email);

		if($database -> error){
			$msg = $database -> errmsg;
			$_SESSION['msg'] = $msg;
			header("Location: find_friends.php");
		}

		extract($result);

		if($gender="Male"){
			$gender = "ছেলে";
		}
		else if($gender="Female"){
			$gender = "মেয়ে";

		}
		else if($gender="Others"){
			$gender = "অন্যান্য";
		}

		?>
		<div align=center>

			<h2>
				ব্যবহারকারীর প্রোফাইল			</h2>

			<div id = "profile_picture" > 
				<?php  
				$path = "images/profile_img_".$user_id;
				if(file_exists($path)){
					echo "<img style = 'width:20%;height:10%;border-radius:50%;' src = '$path'>";
				}
				?>

			</div>
			<h1> <?php echo $first_name.' '.$last_name; ?></h1>


			<table >
				<tr>
					<td>ব্যবহারকারীর  আইডি</td>
					<td> </td>
					<td> <?php echo toBangla($user_id); ?> </td>
				</tr>
				<tr>
					<td>ব্যবহারকারীর ইমেইল</td>
					<td> </td>
					<td> <?php echo $email; ?> </td>
				</tr>
				<tr>
					<td>প্রথম নাম</td>
					<td> </td>
					<td> <?php echo $first_name; ?> </td>
				</tr>
				<tr>
					<td> শেষ নাম </td>
					<td> </td>
					<td> <?php echo $last_name; ?> </td>
				</tr>
				<tr>
					<td>লিঙ্গ</td>
					<td> </td>
					<td> <?php echo $gender; ?> </td>
				</tr>

				<tr>
					<td>সফল</td>
					<td> </td>
					<td> <?php echo toBangla($accepted); ?> </td>
				</tr>

				<tr>
					<td>মোট</td>
					<td> </td>
					<td> <?php echo toBangla($total); ?> </td>
				</tr>
			</table>
			<?php 
			if(isset($_COOKIE['user_email'])){
				$user_email = $_COOKIE['user_email'];
			}
			if($email==$user_email){
				echo "<form method='post'> <input class='button' formaction='edit_profile.php' type='submit' value='সম্পাদন কর' name='সম্পাদন কর'></form>";
			}
			?>
		</div>
		<div id= "details"> 
			<div align=center> সঠিক উত্তরের তালিকা </div><br>
			<?php 
			$mcq_ids = $database -> get_accepted_mcq_submission_id($user_id);
			sort($mcq_ids);
			foreach($mcq_ids as $index => $mcq_id){
				$bn_mcq_id = toBangla($mcq_id);
				echo "<a href='mcq.php?mcq_id=$mcq_id'> $bn_mcq_id </a>";
			}

			?>
		</div>

		<div id= "details">

			<div align = center > ভুল উত্তরের তালিকা </div> <br>
			<?php 
			$mcq_ids = $database -> get_rejected_mcq_submission_id($user_id);
			sort($mcq_ids);
			foreach($mcq_ids as $index => $mcq_id){
				$bn_mcq_id = toBangla($mcq_id);
				echo "<a href='mcq.php?mcq_id=$mcq_id'> $bn_mcq_id </a>";
			}

			?>

		</div>
	</body>
</html>