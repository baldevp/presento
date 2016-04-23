<?php
	if(isset($_POST['submit'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];
		$pass=md5($pass);
		$type=$_POST['userType'];
		if($type==0){
		$roll=$_POST['roll'];
		$cpi=$_POST['cpi'];
	    }
	    $connect=mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error connecting");
	    $query="select user_id from presento_user where user_email='$email'";
	    if(mysqli_num_rows(mysqli_query($connect,$query))>0){
	    	$error="Email already exists, contact DB Admin";
	    }
	    else{
	    	if($type==0){
	    		$extra=",user_roll,cpi";
	    		$extra1=",'$roll','$cpi'";
	    	}
	    	else{
	    		$extra='';
	    		$extra1='';
	    	}
	    	$query="insert into presento_user(user_name,user_email,user_type,password".$extra.") values( '$name', '$email','$type','$pass'".$extra1.")";
	    	mysqli_query($connect,$query);
	    	header('Location:login.php');
	    }	
	}
?>