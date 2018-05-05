<?php
// definition of something will be commented in upper line
// database driver with all kind of error handling hoping for the best
class database_connect{
	// hold the connection of database
	private $mysql ;

	//error hold true if error occure during any function call 
	public $error ;

	//errmsg hold error msg if any problem occure during function call
	public $errmsg ;

	// reset error information before every function tasks
	public function reset_error_info(){
		$error= false;
		$errmsg="";
	}
	public function store_database_error(){
		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
			return true;
		}
	}
	public function store_error_msg($msg){
		$this -> error = true;
		$this -> errmsg = $msg;
	}


	public function __construct(){
		$this -> reset_error_info();

		$this -> mysql = new mysqli( "localhost", "root", "", "learn");
	}
	public function __destruct(){

	}

	// return true if user give correct information
	public function user_exist( $email , $password ){
		$password_hash = sha1($password);
		$this -> reset_error_info();
		$sql = $this -> mysql -> prepare( "SELECT user_id FROM user_table WHERE email = ? and password_hash=?;");
		$sql -> bind_param("ss",$email,$password_hash);
		
		if ( $sql -> execute() ) {
			$sql -> bind_result($user_id);
			if($sql->fetch()){
				if($sql -> fetch()) return false;	
				return true;
			}
			else {
				return false;
			}
		}
		else {
			$this -> store_error_msg("দুঃক্ষিত  তথ্য উপযুক্ত ছিল না । তোমার বর্তমান সুরক্ষাকোড দিয়েছিলে তো?");
			return false;
		}
		
		if($this -> mysql -> errno )
		{
			$this -> error = true;
			$this -> errmsg = $this -> mysql -> error;
			return false;
		}
		else 
		{
			if( $res->num_rows == 0 )
			{
				$this -> error = true;
				$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
				return false;
			}
			else
			{
				$row = $res -> fetch_assoc();
				$password_hash = $row['password_hash'];
				if($password_hash == sha1($password))
				{
					return true;
				}
				else 
				{
					$this -> error = true;
					$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।\n";
					return false;
				}
			}
		}
	}
	public function admin_exist( $email , $password ){
		$password_hash = sha1($password);
		$this -> reset_error_info();
		$sql = $this -> mysql -> prepare( "SELECT admin_id FROM admin_table WHERE email = ? and password_hash=?;");
		$sql -> bind_param("ss",$email,$password_hash);
		
		if ( $sql -> execute() ) {
			$sql -> bind_result($admin_id);
			if($sql->fetch()){
				if($sql -> fetch()) return false;	
				return true;
			}
			else {
				return false;
			}
		}
		else {
			$this -> store_error_msg("দুঃক্ষিত  তথ্য উপযুক্ত ছিল না । তোমার বর্তমান সুরক্ষাকোড দিয়েছিলে তো?");
			return false;
		}
		
		if($this -> mysql -> errno )
		{
			$this -> error = true;
			$this -> errmsg = $this -> mysql -> error;
			return false;
		}
		else 
		{
			if( $res->num_rows == 0 )
			{
				$this -> error = true;
				$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
				return false;
			}
			else
			{
				$row = $res -> fetch_assoc();
				$password_hash = $row['password_hash'];
				if($password_hash == sha1($password))
				{
					return true;
				}
				else 
				{
					$this -> error = true;
					$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।\n";
					return false;
				}
			}
		}
	}
	public function signup_user( $email , $password1, $password2 ){
		$this -> reset_error_info();

		if( $password1 != $password2 )
		{
			$this -> error = true;
			$this -> errmsg = "সুরক্ষা কোড দুইটি একই নয়! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
		}
		else 
		{
			$email = $this->mysql->real_escape_string($email);
			$sql = "SELECT email FROM user_table WHERE email='$email';";

			$res = $this -> mysql -> query($sql);

			if($this -> mysql -> errno){
				$error = true;
				$errmsg = $this -> mysql -> error; 

			}
			else if( $res -> num_rows != 0 ) 
			{
				$this -> error = true;
				$this -> errmsg = "ইমেইলটি ইতোমধ্যে ব্যবহার করা হচ্ছে! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
			}
			else 
			{
				$pass_hash = sha1($password1);

				$sql = "INSERT INTO user_table (email,password_hash) VALUES('$email','$pass_hash');";
				$this -> mysql -> query($sql);

				if($this -> mysql -> errno)
				{
					$this -> error = true;
					$this -> errmsg = $this -> mysql -> error; 
				}
			}
		}

	}
	public function get_user_id( $email ){
		$this -> reset_error_info();

		//	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		if($email)
		{
			$sql ="SELECT user_id FROM user_table WHERE email='$email';";

			$res = ($this -> mysql)->query($sql);

			if($this -> mysql -> errno){
				$error = true;
				$errmsg = $this -> mysql -> error; 
			}
			else if($res->num_rows==0)
			{
				$this -> error = true;
				$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
			}
			else 
			{
				$row = $res->fetch_assoc();
				return $row['user_id'];
			}
		}
		else 
		{
			$this -> error = true;
			$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
		}
	}
	public function get_admin_id( $email ){
		$this -> reset_error_info();

		//	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		if($email)
		{
			$sql ="SELECT admin_id FROM admin_table WHERE email='$email';";

			$res = ($this -> mysql)->query($sql);

			if($this -> mysql -> errno){
				$error = true;
				$errmsg = $this -> mysql -> error; 
			}
			else if($res->num_rows==0)
			{
				$this -> error = true;
				$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
			}
			else 
			{
				$row = $res->fetch_assoc();
				return $row['user_id'];
			}
		}
		else 
		{
			$this -> error = true;
			$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
		}
	}
	public function get_user_email( $user_id ){
		$this -> reset_error_info();

		//	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		if($user_id)
		{
			$sql ="SELECT email FROM user_table WHERE user_id='$user_id';";

			$res = ($this -> mysql)->query($sql);

			if($this -> mysql -> errno){
				$error = true;
				$errmsg = $this -> mysql -> error; 
			}
			else if($res->num_rows==0)
			{
				$this -> error = true;
				$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
			}
			else 
			{
				$row = $res->fetch_assoc();
				return $row['email'];
			}
		}
		else 
		{
			$this -> error = true;
			$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
		}
	}
	public function get_admin_email( $admin_id ){
		$this -> reset_error_info();

		//	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		if($admin_id)
		{
			$sql ="SELECT email FROM admin_table WHERE admin_id='$admin_id';";

			$res = ($this -> mysql)->query($sql);

			if($this -> mysql -> errno){
				$error = true;
				$errmsg = $this -> mysql -> error; 
			}
			else if($res->num_rows==0)
			{
				$this -> error = true;
				$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
			}
			else 
			{
				$row = $res->fetch_assoc();
				return $row['email'];
			}
		}
		else 
		{
			$this -> error = true;
			$this -> errmsg = "উপযুক্ত তথ্য পাওয়া যায় নি! সঠিক তথ্য দিয়ে আবার চেষ্টা কর।";
		}
	}
	public function change_first_name( $email, $name )
	{
		$this -> reset_error_info();
		$sql = "UPDATE user_table SET first_name = '$name' WHERE email = '$email';";
		$res = ( $this -> mysql ) -> query( $sql );

		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
	}
	public function get_first_name( $email )
	{
		$this -> reset_error_info();

		$sql = "SELECT first_name FROM user_table WHERE email = '$email'";
		$res = ( $this -> mysql ) -> query( $sql );

		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else {
			$row = $res -> fetch_assoc();
			return $row['first_name'];	
		}
	}
	public function change_last_name( $email, $name){
		$this -> reset_error_info();
		$sql = "UPDATE user_table
			SET last_name = '$name'
			WHERE email = '$email';";
		$res = ( $this -> mysql ) -> query( $sql );

		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
	}
	public function change_password( $email, $pass){
		$pass = sha1($pass);
		$this -> reset_error_info();
		$sql = "UPDATE user_table
			SET password_hash = '$pass'
			WHERE email = '$email';";
		$res = ( $this -> mysql ) -> query( $sql );

		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
	}
	public function change_gender( $email, $gender){
		$this -> reset_error_info();
		$sql = "UPDATE user_table
			SET gender = '$gender'
			WHERE email = '$email';";
		$res = ( $this -> mysql ) -> query( $sql );

		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
	}
	public function get_last_name( $email )
	{
		$this -> reset_error_info();

		$sql = "SELECT last_name FROM user_table WHERE email = '$email'";
		$res = ( $this -> mysql ) -> query( $sql );

		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else {
			$row = $res -> fetch_assoc();
			return $row['last_name'];
		}
	}

	public function add_subject( $subject_code, $subject_name){
		$this -> reset_error_info();

		$sql = "SELECT subject_code FROM subject_table WHERE subject_code='$subject_code';";
		$res = $this -> mysql -> query( $sql );

		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else if( $res -> num_rows !=0 )
		{
			$this -> error = true;
			$this -> errmsg = "Give Code is not available!";
		}
		else 
		{
			$sql = "INSERT INTO subject_table(subject_code,subject_name) VALUES('$subject_code','$subject_name');";
			$this -> mysql -> query( $sql);
			if($this -> mysql -> errno)
			{
				$error = true;
				$errmsg = $this -> mysql -> error; 
			}
		}
	}

	public function show_subjects()
	{
		$this -> reset_error_info();

		$sql = "SELECT * FROM subject_table;";
		$res = $this -> mysql -> query($sql);
		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}


		while($row = $res -> fetch_assoc()){
			print_r($row);
		}
	}

	public function add_chapter( $chapter_name, $subject_code){
		$this -> reset_error_info();

		$sql = "INSERT INTO chapter_table(chapter_name,subject_code) VALUES('$chapter_name','$subject_code');";
		$this -> mysql -> query( $sql);

		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}	
	}
	public function add_question( $question , $option_a, $option_b, $option_c, $option_d, $answer){
		$this -> reset_error_info();
		$sql = "INSERT INTO mcq_table (question,option_a,option_b,option_c,option_d,answer) VALUES('$question', '$option_a', '$option_b', '$option_c', '$option_d', '$answer');";
		$this -> mysql -> query($sql);
		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		$res =  $this -> mysql -> query("SELECT LAST_INSERT_ID() as mcq_id;");
		$row = $res -> fetch_assoc();
		return $row['mcq_id'];
	}
	public function add_chapter_mcq($chapter_id, $mcq_id){
		$this -> reset_error_info();
		$sql = "INSERT INTO chapter_mcq_table (chapter_id,mcq_id) VALUES('$chapter_id', '$mcq_id');";
		$this -> mysql -> query($sql);
		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
	}
	public function add_subject_mcq($subject_code, $mcq_id){
		$this -> reset_error_info();
		$sql = "INSERT INTO subject_mcq_table (subject_code, mcq_id) VALUES('$subject_code', '$mcq_id');";
		$this -> mysql -> query($sql);
		if($this -> mysql -> errno){
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
	}
	public function get_subject_id( $subject_code )
	{
		$this -> reset_error_info();

		$sql = "SELECT subject_id FROM subject_table WHERE subject_code = '$subject_code' ; ";
		$res = $this -> mysql -> query( $sql );

		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else 
		{
			$row = $res -> fetch_assoc();
			return $row['subject_id'];
		}

	}
	public function get_subject_code ( $subject_id)
	{
		$this -> reset_error_info();

		$sql = "SELECT subject_code FROM subject_table WHERE subject_id = '$subject_id' ; ";
		$res = $this -> mysql -> query( $sql );
		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else 
		{
			$row = $res -> fetch_assoc();
			return $row['subject_code'];
		}
	}
	public function get_subject_name ( $subject_code)
	{
		$this -> reset_error_info();

		$sql = "SELECT subject_name FROM subject_table WHERE subject_code = '$subject_code' ; ";
		$res = $this -> mysql -> query( $sql );
		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else 
		{
			$row = $res -> fetch_assoc();
			return $row['subject_name'];
		}
	}
	public function get_chapter_name ( $chapter_id)
	{
		$this -> reset_error_info();

		$sql = "SELECT chapter_name FROM chapter_table WHERE chapter_id = '$chapter_id' ; ";
		$res = $this -> mysql -> query( $sql );
		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else 
		{
			$row = $res -> fetch_assoc();
			return $row['chapter_name'];
		}
	}
	public function get_subjects(){
		$this -> reset_error_info();

		$subjects;
		$sql = "SELECT subject_code,subject_name FROM subject_table;";
		$res = $this -> mysql -> query( $sql );

		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else
		{
			while($row = $res -> fetch_assoc())
			{
				$subjects[$row['subject_code']]=$row['subject_name'];
			}
			return $subjects;
		}
	}
	public function get_chapters()
	{
		$this -> reset_error_info();

		$chapters = array();
		$sql = "SELECT chapter_id,chapter_name,subject_code FROM chapter_table;";


		$res = $this -> mysql -> query( $sql );
		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else 
		{
			while($row = $res -> fetch_assoc())
			{
				$chapters[ $row [ 'chapter_id' ] ] =  $row[ 'chapter_name' ];
			}
			return $chapters;
		}
	}
	public function get_chapter( $subject_code ){
		$this -> reset_error_info();

		$chapters=array();
		$sql = "SELECT chapter_id,chapter_name FROM chapter_table WHERE subject_code='$subject_code';";


		$res = $this -> mysql -> query( $sql );
		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else 
		{
			while($row = $res -> fetch_assoc())
			{
				$chapters[$row['chapter_id']]=$row['chapter_name'];
			}
			return $chapters;
		}
	}
	public function show_chapters( $subject_code){

		$chapters = $this->get_chapters($subject_code);
		foreach($chapters as $chapter_id =>  $chapter_name)
		{
			echo $chapter_id . '  ' . $chapter_name; 
		}
	}
	
	public function get_mcq_by_chapter($chapter_id){
		$this -> reset_error_info();
		$sql = "SELECT mcq_id FROM chapter_mcq_table WHERE chapter_id = $chapter_id;";
		$res = $this -> mysql -> query( $sql);

		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else {

			$ques = array();
			while($row = $res -> fetch_assoc()){
				$ques[] = $row['mcq_id'];
			}

			return $ques;
		}
	}
	public function get_mcq_by_subject($subject_code){
		$this -> reset_error_info();

		$sql = "SELECT mcq_id FROM subject_mcq_table WHERE subject_code = '$subject_code';";
		$res = $this -> mysql -> query( $sql);
		if($this -> mysql -> errno){

			$error = true;
			$errmsg = $this -> mysql -> error; 

		}
		else {
			$ques = array();

			while($row = $res -> fetch_assoc()){
				$ques[] = $row['mcq_id'];
			}
			if(sizeof($ques)==0){
				$this->error=true;
				$this->errmsg="এই বিষয়ের কোন বহুনির্বাচনি পাওয়া যায় নি।";
				return ;
			}
			return $ques;
		}
	}
	public function get_mcq($mcq_id){
		$this -> reset_error_info();
		$sql = "SELECT * FROM mcq_table WHERE mcq_id = $mcq_id;";
		$res = $this -> mysql -> query( $sql);


		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		else {
			$row = $res -> fetch_assoc();
			return $row;
		}
	}
	public function store_exam($user_id, $mcqs, $ans){

		$this -> reset_error_info();

		foreach($mcqs as $index -> $mcq){
			$sql ="insert into mcq_submission_table(user_id,mcq_id,result) VALUES($user_id,$mcq_id,$result)";	
		}
	}
	public	function add_submission($user_id,$mcq_id,$result){
		$this -> reset_error_info();
		$sql ="insert into mcq_submission_table (user_id, mcq_id, verdict) VALUES($user_id,$mcq_id,$result);";
		//	echo $sql;
		$this ->mysql-> query($sql);

		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}
		if($result) $sql = "UPDATE mcq_table  SET right_answer = right_answer + 1 WHERE mcq_id = $mcq_id;";
		else $sql = "UPDATE mcq_table  SET wrong_answer = wrong_answer + 1 WHERE mcq_id = $mcq_id;";
		$this -> mysql -> query($sql);
		if($this -> mysql -> errno)
		{
			$error = true;
			$errmsg = $this -> mysql -> error; 
		}

	}

	public function get_mcq_by_id($mcq_id){
		$sql = "SELECT * from mcq_table where mcq_id=$mcq_id;";
		$res = $this -> mysql -> query($sql);
		if($res -> num_rows ==0 ){
			$this -> error = true;
			$this -> errmsg = "MCQ with this id does not exist\n";
			return ;
		}
		$row = $res->fetch_assoc();
		return $row;
	}
	public function get_accepted_submission_count($user_id){
		$this -> reset_error_info();

		$sql = $this -> mysql -> prepare ( "SELECT COUNT(DISTINCT(mcq_id)) as count  from mcq_submission_table where user_id= ? and verdict=1;");
		echo $this -> mysql -> error ;

		$sql -> bind_param( "i" , $user_id );

		if( $sql -> execute() ){

			$sql ->  bind_result ($ac_count);

			if( $sql -> fetch() )
			{
				return $ac_count;
			}
			else {
				$this -> store_error_msg("পাওয়া যায় নি কাউকে");
				return ;
			}

		}
		else {
			$this -> store_database_error();
		}
	}
	public function get_accepted_mcq_submission_id($user_id){
		$this -> reset_error_info();

		$sql = $this -> mysql -> prepare ( "SELECT DISTINCT(mcq_id) as mcq_id from mcq_submission_table where user_id= ? and verdict=1;");
		echo $this -> mysql -> error ;

		$sql -> bind_param( "i" , $user_id );

		if( $sql -> execute() ){

			$sql ->  bind_result ($mcq_id);
			$mcq_ids = array();
			while( $sql -> fetch() )
			{
				$mcq_ids[]= $mcq_id;
			}
			$sql -> close();
			return $mcq_ids;

		}
		else {
			$this -> store_database_error();
		}
	}
	public function get_rejected_mcq_submission_id($user_id){
		$this -> reset_error_info();

		$sql = $this -> mysql -> prepare ( "SELECT mcq_id from mcq_submission_table  where user_id=? group by mcq_id having sum(verdict)=0;");
		echo $this -> mysql -> error ;

		$sql -> bind_param( "i" , $user_id );

		if( $sql -> execute() ){

			$sql ->  bind_result ($mcq_id);
			$mcq_ids = array();
			while( $sql -> fetch() )
			{
				$mcq_ids[]= $mcq_id;
			}
			$sql -> close();
			return $mcq_ids;

		}
		else {
			$this -> store_database_error();
		}
	}
	public function get_total_submission_count($user_id){
		$this -> reset_error_info();

		$sql = $this -> mysql -> prepare ( "SELECT COUNT(DISTINCT(mcq_id)) as mcq_id  from mcq_submission_table where mcq_submission_table.user_id= ?  ORDER BY mcq_id ASC;" );
		$sql -> bind_param( "i" , $user_id );

		if( $sql -> execute() ){

			$sql ->  bind_result ($ac_count);

			if( $sql -> fetch() )
			{
				return $ac_count;
			}
			else {
				$this -> store_error_msg("পাওয়া যায় নি কাউকে");
				return ;
			}

		}
		else {
			$this -> store_database_error();
		}
	}
	public function get_user_score( $user_id ){

	}
	public function get_user_info( $email ){
		$this -> reset_error_info();


		/* selecting mail to show profile, either mail is given to get method or user is logged in. */

		if( $email == NULL ){
			if( isset( $_COOKIE [ 'user_email' ] ) ){
				$email = $_COOKIE[ 'user_email' ] ;
			}
			else {
				$this -> store_error_msg( " প্রবেশ করো , না হয় কোন একটা ইমেইল দাও!" );
				return ;
			}
		}

		// get user basic info
		$sql = $this -> mysql -> prepare("SELECT user_id,first_name,last_name,gender from user_table where email = ? ;");
		$sql -> bind_param( "s" , $email );

		if( $sql -> execute() ){

			$sql -> bind_result( $user_id, $first_name, $last_name, $gender);

			if( $sql ->  fetch() )  {
				$sql -> close();

				$map ['user_id'] = $user_id;
				$map ['email'] = $email;
				$map ['first_name'] = $first_name;
				$map ['last_name'] = $last_name;
				$map ['gender'] = $gender;

				return $map;
			}
			else {
				$this -> store_error_msg("কোন ব্যবহারকারী পাওয়া যায় নি!");
				return ;
			}
		}
		else {
			$this -> store_database_error();
			return ;
		}
		// get user statistics info 

	}	
	public function get_user_profile_info( $email ){
		$this -> reset_error_info();


		/* selecting mail to show profile, either mail is given to get method or user is logged in. */

		if( $email == NULL ){
			if( isset( $_COOKIE [ 'user_email' ] ) ){
				$email = $_COOKIE[ 'user_email' ] ;
			}
			else {
				$this -> store_error_msg( " প্রবেশ করো , না হয় কোন একটা ইমেইল দাও!" );
				return ;
			}
		}

		// get user basic info
		$sql = $this -> mysql -> prepare("SELECT user_id,first_name,last_name,gender from user_table where email = ? ;");
		$sql -> bind_param( "s" , $email );

		if( $sql -> execute() ){

			$sql -> bind_result( $user_id, $first_name, $last_name, $gender);

			if( $sql ->  fetch() )  {
				$sql -> close();

				$map ['user_id'] = $user_id;
				$map ['email'] = $email;
				$map ['first_name'] = $first_name;
				$map ['last_name'] = $last_name;
				$map ['gender'] = $gender;
				$map ['accepted'] = $this -> get_accepted_submission_count($user_id);
				$map ['total'] = $this -> get_total_submission_count($user_id);
				return $map;
			}
			else {
				$this -> store_error_msg("কোন ব্যবহারকারী পাওয়া যায় নি!");
				return ;
			}
		}
		else {
			$this -> store_database_error();
			return ;
		}
		// get user statistics info 

	}
	public function get_subjects_by_mcq_id($mcq_id){
		$this -> reset_error_info();


		/* selecting mail to show profile, either mail is given to get method or user is logged in. */


		// get user basic info
		$sql = $this -> mysql -> prepare("select DISTINCT (subject_name) from subject_table natural join subject_mcq_table where mcq_id =? ;");
		$sql -> bind_param( "i" , $mcq_id);

		if( $sql -> execute() )
		{

			$sql -> bind_result( $subject_name);
			$subjects=array();
			while( $sql ->  fetch() )  {
				$subjects[] = $subject_name;
			}
			$sql -> close();
			return $subjects;
		}
		else {
			$this -> store_database_error();
			return ;
		}
		// get user statistics info 
	}
	public function get_chapters_by_mcq_id($mcq_id){
		$this -> reset_error_info();


		/* selecting mail to show profile, either mail is given to get method or user is logged in. */


		// get user basic info
		$sql = $this -> mysql -> prepare("select  DISTINCT (chapter_name) from chapter_table natural join chapter_mcq_table where mcq_id =? ;");
		$sql -> bind_param( "i" , $mcq_id);

		if( $sql -> execute() ){

			$sql -> bind_result( $chapter_name);
			$chapters=array();
			while( $sql ->  fetch() )  {
				$chapters[] = $chapter_name;
			}
			$sql -> close();
			return $chapters;
		}
		else {
			$this -> store_database_error();
			return ;
		}
		// get user statistics info 
	}
	public function get_right_answer($mcq_id){
		$this -> reset_error_info();



		$sql = $this -> mysql -> prepare("select  right_answer from mcq_table where  mcq_id =?;");
		$sql -> bind_param( "i" , $mcq_id);

		if( $sql -> execute() ){

			$sql -> bind_result( $right_answer);
			
			$sql ->  fetch(); 
			
			$sql -> close();
			return $right_answer;
		}
		else {
			$this -> store_database_error();
			return ;
		}
	}
	public function get_wrong_answer($mcq_id){
		$this -> reset_error_info();



		$sql = $this -> mysql -> prepare("select  wrong_answer from mcq_table where  mcq_id =?;");
		$sql -> bind_param( "i" , $mcq_id);

		if( $sql -> execute() ){

			$sql -> bind_result( $right_answer);
			
			$sql ->  fetch() ;
			
			$sql -> close();
			return $right_answer;
		}
		else {
			$this -> store_database_error();
			return ;
		}
	}
	public function get_mcq_by_chapter_with_dif( $chapter_id, $right_ratio_lower,$right_ratio_higher){
		$sql = $this -> mysql -> prepare("select mcq.mcq_id from chapter_mcq_table as chap NATURAL JOIN  mcq_table as mcq where chap.chapter_id = ? and (mcq.right_answer/(mcq.right_answer + mcq.wrong_answer)  ) > $right_ratio_lower and (mcq.right_answer/(mcq.right_answer + mcq.wrong_answer)  ) <= $right_ratio_higher;");
		$sql -> bind_param("s",$chapter_id);
		$mcqs = array();
		if($sql -> execute()){
			$sql -> bind_result( $mcq_id );
			while($sql->fetch()) $mcqs[]=$mcq_id;
			$sql -> close();
		}
		return $mcqs;
	}
	public function get_mcq_by_chapter_without_dif( $chapter_id){
		$sql = $this -> mysql -> prepare("select mcq.mcq_id from chapter_mcq_table as chap NATURAL JOIN  mcq_table as mcq where chap.chapter_id = ? and (mcq.right_answer + mcq.wrong_answer)=0;");
		$sql -> bind_param("s",$chapter_id);
		$mcqs = array();
		if($sql -> execute()){
			$sql -> bind_result( $mcq_id );
			while($sql->fetch()) $mcqs[]=$mcq_id;
			$sql -> close();
		}
		return $mcqs;
	}
	public function get_mcq_for_exam_by_chapter($chapter_id, $duration, $difficulty){
		$this -> reset_error_info();
		
		$hard = $this -> get_mcq_by_chapter_with_dif($chapter_id,0.0,0.2);
		$medium = $this -> get_mcq_by_chapter_with_dif($chapter_id,0.2,0.5);
		$easy = $this -> get_mcq_by_chapter_with_dif($chapter_id,0.5,1);
		$new = $this -> get_mcq_by_chapter_without_dif($chapter_id);
		shuffle($hard);
		shuffle($medium);
		shuffle($easy);
		shuffle($new);
		
		$hn;
		$mn;
		$en;
		$total=(int)$duration;

		if($difficulty=="easy"){
			$hn = (int)($total * 0.1);
			$mn = (int)($total * 0.3);
			$en = (int)($total - $hn - $mn);
		}
		elseif($difficulty=="medium"){
			$hn = (int) ( $total * 0.2 ) ;
			$mn = (int) ( $total * 0.4 ) ;
			$en = (int) ( $total - $hn - $mn ) ;
		}
		elseif($difficulty=="hard"){
			$hn = (int) ( $total * 0.5 ) ;
			$mn = (int) ( $total * 0.4 ) ;
			$en = (int) ( $total - $hn - $mn ) ;
		}
		$hn = min(sizeof($hard),$hn);
		$mn = min(sizeof($medium),$mn);
		$en = min(sizeof($easy),$en);
		$mcqs = array();
		for( $i = 0 ; $i < $hn ; $i++){
			$mcqs[] = $hard[ $i ];
		}
		for( $i = 0 ; $i < $mn ; $i++){
			$mcqs[] = $medium[ $i ];
		}
		for( $i = 0 ; $i < $en ; $i++){
			$mcqs[] = $easy[ $i ];
		}
		$need = $total - ($hn+$mn+$en);
		if(sizeof($new)<$need) $new= array_merge($new,$easy);
		if(sizeof($new)<$need) $new= array_merge($new,$medium);
		if(sizeof($new)<$need) $new= array_merge($new,$hard);
		$need = min($need,sizeof($new));
		//echo $hn . ' '. $mn . ' '. $en . ' '. $need;
		for($i=0;$i<$need;$i++){
			$mcqs[]=$new[$i];
		}
		//sort($mcqs);
		$mcqs= array_unique($mcqs);
		return $mcqs;
	}
	public function get_mcq_by_subject_with_dif( $subject_code, $right_ratio_lower,$right_ratio_higher){
		$sql = $this -> mysql -> prepare("select mcq.mcq_id from subject_mcq_table as sub NATURAL JOIN  mcq_table as mcq where sub.subject_code = ? and (mcq.right_answer/(mcq.right_answer + mcq.wrong_answer)  ) > $right_ratio_lower and (mcq.right_answer/(mcq.right_answer + mcq.wrong_answer)  ) <= $right_ratio_higher;");
		$sql -> bind_param("s",$subject_code);
		$mcqs = array();
		if($sql -> execute()){
			$sql -> bind_result( $mcq_id );
			while($sql->fetch()) $mcqs[]=$mcq_id;
			$sql -> close();
		}
		return $mcqs;
	}
	public function get_rank_list(){
		$sql = $this -> mysql -> prepare("select user_table.user_id , user_table.email , user_table.first_name, user_table.last_name, 100*sum(verdict)/count(user_id)  from user_table natural join mcq_submission_table group by mcq_submission_table.user_id HAVING COUNT(user_id)>0 ORDER BY 100*sum(verdict)/count(user_id) DESC limit 100;");
		
		$users = array();
		if($sql -> execute()){
			$sql -> bind_result( $user_id, $email, $first_name,$last_name,$ratio);
			while($sql->fetch()) $users[]=array($user_id,$email,$first_name,$last_name,$ratio);
			$sql -> close();
		}
		return $users;
	}
	public function get_mcq_by_subject_without_dif( $subject_code){
		$sql = $this -> mysql -> prepare("select mcq.mcq_id from subject_mcq_table as sub NATURAL JOIN  mcq_table as mcq where sub.subject_code = ? and (mcq.right_answer + mcq.wrong_answer)=0;");
		$sql -> bind_param("s",$subject_code);
		$mcqs = array();
		if($sql -> execute()){
			$sql -> bind_result( $mcq_id );
			while($sql->fetch()) $mcqs[]=$mcq_id;
			$sql -> close();
		}
		return $mcqs;
	}
	public function get_mcq_for_exam_by_subject($subject_code, $duration, $difficulty){
		$this -> reset_error_info();
		
		
		$hard = $this -> get_mcq_by_subject_with_dif($subject_code,0.0,0.2);
		$medium = $this -> get_mcq_by_subject_with_dif($subject_code,0.2,0.5);
		$easy = $this -> get_mcq_by_subject_with_dif($subject_code,0.5,1);
		$new = $this -> get_mcq_by_subject_without_dif($subject_code);
		shuffle($hard);
		shuffle($medium);
		shuffle($easy);
		shuffle($new);
		
		//print_r($hard);
		//print_r($medium);
		//print_r($easy);
		
		$hn;
		$mn;
		$en;
		$total=$duration;

		if($difficulty=="easy"){
			$hn = (int)($total * 0.1);
			$mn = (int)($total * 0.3);
			$en = (int)($total - $hn - $mn);
		}
		elseif($difficulty=="medium"){
			$hn = (int) ( $total * 0.2 ) ;
			$mn = (int) ( $total * 0.4 ) ;
			$en = (int) ( $total - $hn - $mn ) ;
		}
		elseif($difficulty=="hard"){
			$hn = (int) ( $total * 0.5 ) ;
			$mn = (int) ( $total * 0.4 ) ;
			$en = (int) ( $total - $hn - $mn ) ;
		}
		$hn = min(sizeof($hard),$hn);
		$mn = min(sizeof($medium),$mn);
		$en = min(sizeof($easy),$en);
		$mcqs = array();
		for( $i = 0 ; $i < $hn ; $i++){
			$mcqs[] = $hard[ $i ];
		}
		for( $i = 0 ; $i < $mn ; $i++){
			$mcqs[] = $medium[ $i ];
		}
		for( $i = 0 ; $i < $en ; $i++){
			$mcqs[] = $easy[ $i ];
		}
		$need = $total - ($hn+$mn+$en);
		if(sizeof($new)<$need) $new= array_merge($new,$easy);
		if(sizeof($new)<$need) $new= array_merge($new,$medium);
		if(sizeof($new)<$need) $new= array_merge($new,$hard);
		$need = min($need,sizeof($new));
		//echo $hn . ' '. $mn . ' '. $en . ' '. $need;
		for($i=0;$i<$need;$i++){
			$mcqs[]=$new[$i];
		}
		$mcqs = array_unique($mcqs);
		return $mcqs;
	}
}
?>