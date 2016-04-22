<?php
if(!isset($_COOKIE['user_name'])&& !isset($user))
	header('Location: login.php');
?>