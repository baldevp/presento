<?php
if(isset($_POST['submit'])){
	$used=1;
	$email=$_POST['email'];
	$pass=$_POST['pass'];
	$pass1=md5($pass);
	$connect=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or fail('error connecting to db');
	$query="select * from presento_user where user_email='$email' and password='$pass1'";
	$data=mysqli_query($connect,$query);
	if(mysqli_num_rows($data)>0){
		$row=mysqli_fetch_assoc($data);
		setcookie('user_id',$row['user_id']);
		setcookie('user_email',$row['user_email']);
		setcookie('user_name',$row['user_name']);
		setcookie('user_type',$row['user_type']);
		setcookie('user_verify',$row['verify']);
		header('Location:index.php');
	}
}
?>