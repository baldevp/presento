<?php
 if(isset($_POST['submit'])){
 	$pass=$_POST['pass'];
 	if(!is_null($_POST['user_id'])&&!is_null($_POST['recovery_key'])){
 			$key=$_POST['recovery_key'];
 		     $id=$_POST['user_id'];
 		     $connect=mysqli_connect(DBHOST,DBUSER,DBPASS, DBNAME);
 		     $query="select user_id from presento_fpass where user_id='$id' && recovery_key='$key'";
 		     $data=mysqli_query($connect,$query);
 		     if(mysqli_num_rows($data)>0){
 		     	$pass=md5($pass);
 		     	$query="update presento_user set password='$pass' where user_id='$id'";
 		     	mysqli_query($connect,$query);
 		     	$query="delete from presento_fpass where user_id='$id'";
 		     	mysqli_query($connect,$query);
 		     	header('Location:login.php');
 		     }
 		     else{
 		     	$error="Wrong Parameters";
 		     }
 	}
 	else{
 		$error="Missing Parameters";
 	}
 }
 else{
 	$key="";
 	$id="";
 	if(isset($_GET['user_id'])&&isset($_GET['recovery_key'])){
 		$key=$_GET['recovery_key'];
 		$id=$_GET['user_id'];
 	}
 }

?>