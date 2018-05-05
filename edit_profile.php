<html> 
	<head>
		<title>
		</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
	</head>
	<body>
		<?php session_start(); ?>
		<?php include_once "html_component_printer.php"; ?>
		<?php include_once "database_object.php"; ?>
		<?php top_bar("profile"); ?>

		<?php 
		$database = new database_connect();

		$data = $database -> get_user_info($_COOKIE['user_email']);
		if( $database -> error )
		{
			$msg = $database ->  errmsg;
			echo "<h1 class='errmsg'>  $msg </h1>";
			echo "</body> </html>";
			die();
		} 
		extract($data);
		$first_name = $data['first_name'];
		$last_name = $data['last_name'];
		$gender = $data['gender'];	

		if(isset($_SESSION['msg'])){
			$msg = $_SESSION['msg'];
			echo "<h3 class='errmsg'> $msg </h3>";
			unset( $_SESSION['msg']);
		}

		?>

		<div class ='edit_profile_form' enctype="multipart/form-data">
			<form  method = "post" action = edit_profile_action.php text-align=center enctype="multipart/form-data">
				ইমেইল:  <?php echo $email; ?>	 <br>

				<br>
				<label for="file"> Pick a file : <br>  </label>
			<input class="button" type="file" name ="image"> 
				<br>
				প্রথম নাম <br>
				<input type = "text" name = "first_name" placeholder= '<?php echo $first_name; ?>' > 
				<br>

				শেষ নাম <br>
				<input type = "text" name = "last_name" placeholder= '<?php echo $last_name; ?>' > <br>

				লিঙ্গ <br>
				<select class ="button" name="gender"> 

					<option value="" <?php if($gender=="") echo "selected='selected'"; ?> ></option>

					<option value="Male" <?php if($gender=="Male") echo "selected='selected'"; ?>> ছেলে </option>

					<option value="Female" <?php if($gender=="Female") echo "selected='selected'"; ?>> মেয়ে   </option>

					<option value="Others" <?php if($gender=="Others") echo "selected='selected'"; ?>> অন্যান্য </option>

				</select> <br>

				নতুন সুরক্ষাকোড <br>
				<input type="password" name = "n_password"> <br>

				পুনরায় নতুন সুরক্ষাকোড <br>
				<input type="password" name = "r_n_password"> <br>

				বর্তমান সুরক্ষাকোড  <h1>*</h1> <br>
				<input type="password" name="password"> <br>
				<input class="button" type = 'submit' value="হালনাগাদ কর" >  

			</form>
		</div>
	</body>
</html>