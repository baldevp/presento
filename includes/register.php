<?php
	if(isset($_POST['submit'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];
		$pass=md5($pass);
		$type=$_POST['userType'];
		$contact=$_POST['contact'];
		if($type==0){
		$roll=$_POST['roll'];
		$cpi=$_POST['cpi'];
		$section=$_POST['section'];
	    }
	    $connect=mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error connecting");
	    $query="select user_id from presento_user where user_email='$email'";
	    if(mysqli_num_rows(mysqli_query($connect,$query))>0){
	    	$error="Email already exists, contact DB Admin";
	    }
	    else{
	    	if($type==0){
	    		$extra=",user_roll,cpi,section";
	    		$extra1=",'$roll','$cpi','$section'";
	    	}
	    	else{
	    		$extra='';
	    		$extra1='';
	    	}
	    	$query="insert into presento_user(user_name,user_email,user_type,password,contact_num".$extra.") values( '$name', '$email','$type','$pass','$contact'".$extra1.")";
	    	mysqli_query($connect,$query);
	    	header('Location:login.php');
	    }	
	}
?>