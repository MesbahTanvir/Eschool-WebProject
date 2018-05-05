<!DOCTYPE HTML>
<html lang="en-US">
	<head>

		<meta charset="UTF-8">
		<title>
		</title>
		<link href="https://fonts.maateen.me/bangla/font.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">

	</head>

	<body>
		<?php session_start(); ?>
		<?php include_once "html_component_printer.php"  ?>
		<?php top_bar("home") ?>
		<?php include_once "database_object.php";
		$database = new database_connect();
		$user_list = $database -> get_rank_list();
		//print_r($user_list);
		?>
		<div class='errmsg'> <h1>প্রথম একশত জন </h1></div>
		<table align=center cellspacing="20" > 
			<tr>
				<th> মেধাক্রম</th>
				<th> আইডি </th>
				<th> ইমেইল </th>
				<th> প্রথমনাম </th>
				<th> শেষনাম  </th>
				<th> সফলতারহার</th>
			</tr>
			<?php 
			$rank=0;
			$prev_ratio=0;
			foreach($user_list as $i => $user){
				$user_id = $user[0];
				$email = $user[1];
				$first_name = $user[2];
				$last_name = $user[3];
				$ratio = $user[4];
				//$prev_ratio = $ratio;
				if(abs($ratio - $prev_ratio) > .01 ){
					$rank++;
				}
				echo "<tr>";
					echo "<td>$rank</td>";
					echo "<td>$user_id</td>";
					echo "<td>$email</td>";
					echo "<td>$first_name</td>";
					echo "<td>$last_name</td>";
					echo "<td>$ratio</td>";
				echo "</tr>";
				
				$prev_ratio = $ratio;
			}	
			
			
			?>


		</table>



	</body>
</html>