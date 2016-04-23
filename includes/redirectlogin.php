<?php
	if(isset($user)&&$user==0&&isset($_COOKIE['user_id']))
	header('Location:index.php');
?>