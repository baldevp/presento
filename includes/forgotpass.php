<?php
	if(isset($_POST['submit'])){
		$email=$_POST['email'];
		$connect=mysqli_connect(DBHOST,DBUSER,DBPASS, DBNAME);
		$query="select user_id,user_name from presento_user where user_email='$email'";
		$data=mysqli_query($connect,$query);
		if(mysqli_num_rows($data)==0){
			$error="The email id does not exists";
		}
		else{
			$row=mysqli_fetch_assoc($data);
			$id=$row['user_id'];
			$name=$row['user_name'];
			$key=md5(uniqid(rand(), true));
			$query="insert into presento_fpass(user_id,recovery_key) values('$id','$key')";

			mysqli_query($connect,$query);

			$from='recovery@cotanz.com';
			$subject="Password Recovery";
			$link="http://www.presento.cotanz.com/recoverpass.php?user_id=$id&recovery_key=$key";
			$text="Dear $name,\r\n We have recieved a request to change password from you, kindly click <a href='$link'>this link</a>.";
			$headers = "From: $from" . "\r\n" .
                       "Reply-To: $from" . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
             mail($email, $subject, $text, $headers);
             $error="Send the mail to the concerned email id.";
		}
	}

?>