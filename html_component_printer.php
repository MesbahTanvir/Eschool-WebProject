<?php

function top_bar($active){			
	// to highlight active section of topbar
	$home_active = $active=="home"?"active":"";
	$contact_active = $active=="contact"?"active":"";
	$profile_active = $active=="profile"?"active":"";
	$signin_active = $active=="signin"?"active":"";
	$signup_active = $active=="signup"?"active":"";


	/*** if user logged in ***/
	if($active=="admin"){
		
		if(isset($_COOKIE['admin_email']))
		{

			$email = $_COOKIE['admin_email'];
			//echo $email;

			echo "
				<ul class='topnav'>
  				<li><a  href='/eschool'>হোম</a></li>
  				<li><a  href='about_us.php'>আমাদের সম্পর্কে</a></li>
  				<li class='right '><a  href='profile.php'>প্রোফাইল</a></li>
  				<li class='right '><a href='signout_action.php'> বের হও </a></li>
				</ul>";
		}
		else
		{
			echo "	
			<div class = 'errmsg'>
				<h1> তুমি লগইন অবস্থায় নেই </h1> </div>";


			echo "<ul class='topnav'>
  					<li><a  href='/eschool'>হোম </a></li>
  					<li><a href='about_us.php'>আমাদের সম্পর্কে</a></li>
  					<li class='right'> <a  href='signin_form.php'> প্রবেশ কর</a></li>
  					<li class='right'> <a  href='signup_form.php'> নিবন্ধন কর </a></li>
				</ul>";

			if($active=="home") {
				echo 
					"<h3> এখানে <a href='signin_form.php' > প্রবেশ কর </a> করো, তুমি যদি নিবন্ধন করে না থাকো তবে 
					<a href='signup_form.php' > এখান </a> থেকে করে নাও</h3>";
				echo "</body>";
				echo "</html>";
			}

		}	
		if(isset($_SESSION['admin_msg']))
		{	
			$msg = $_SESSION['admin_msg'];
			echo "<div class='errmsg textcenter'> <h1> $msg <h1> </div>";
			unset($_SESSION['admin_msg']);
		}
	}
	else {

		if(isset($_COOKIE['user_email']))
		{

			$email = $_COOKIE['user_email'];

			echo "
				<ul class='topnav'>
  				<li><a class='$home_active' href='/eschool'>হোম</a></li>
  				<li><a class='$contact_active' href='about_us.php'>আমাদের সম্পর্কে</a></li>
  				<li class='right '><a class='$profile_active' href='profile.php'>প্রোফাইল</a></li>
  				<li class='right '><a href='signout_action.php'> বের হও </a></li>
				</ul>";
		}
		else
		{
			echo "	
			<div class = 'errmsg'>
				<h1> তুমি লগইন অবস্থায় নেই </h1> </div>";


			echo "<ul class='topnav'>
  					<li><a class='$home_active' href='/eschool'>হোম </a></li>
  					<li><a  class='$contact_active' href='about_us.php'>আমাদের সম্পর্কে</a></li>
  					<li class='right $signin_active'> <a class='$signin_active' href='signin_form.php'> প্রবেশ কর</a></li>
  					<li class='right $signup_active'> <a class='$signup_active' href='signup_form.php'> নিবন্ধন কর </a></li>
				</ul>";

			if($active=="home") {
				echo 
					"<h3> এখানে <a href='signin_form.php' > প্রবেশ কর </a> করো, তুমি যদি নিবন্ধন করে না থাকো তবে 
					<a href='signup_form.php' > এখান </a> থেকে করে নাও</h3>";
				echo "</body>";
				echo "</html>";
			}

		}	
		if(isset($_SESSION['msg']))
		{	
			$msg = $_SESSION['msg'];
			echo "<div class='errmsg textcenter'> <h1> $msg <h1> </div>";
			unset($_SESSION['msg']);
		}
	}
}
function admin_nav($highlight)
{
	$subject = ($highlight == "subject" ) ? "highlight":"";
	$chapter = ($highlight == "chapter" ) ? "highlight":"";
	$question = ($highlight == "question") ? "highlight":"";


	echo "<div align=center>
		<form action='add_subject.php' method='post' text-align=center>  <input  class = 'button $subject' type='submit'  name=' বহুনির্বাচনি পরীক্ষা' value=' বিষয় সংযুক্ত করো  '> </form>
	</div>
	<div align=center>
			<form action='add_chapter.php' method='post' text-align=center>  <input  class ='button $chapter' type='submit'
			name='প্রসাশনিক  কার্যক্রম' value='অধ্যায় সংযুক্ত করো'> </form>
	</div>
	<div align=center>
			<form action='add_question.php' method='post' text-align=center>  <input  class ='button $question' type='submit'  name='বন্ধুকে খুঁজো ' value='প্রশ্ন সংযুক্ত করো'> </form>

	</div>";
}

?>