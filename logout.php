<?php
 include_once('includes/checklogin.php');
 	setcookie('user_id', '', time()-7000000);
	setcookie('user_email', '', time()-7000000);
	setcookie('user_name', '', time()-7000000);
	setcookie('user_type', '', time()-7000000);
	setcookie('user_verify', '', time()-7000000);
	header('Location:login.php');
  
?>