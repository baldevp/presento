<?php
if(!isset($_COOKIE['user_id'])&& !isset($user))
	header('Location: login.php');
if(isset($_COOKIE['user_id']) && $_COOKIE['user_verify']==0 && !isset($user))
	header('Location: getverify.php');
if(isset($user)&&($user==1)&&$_COOKIE['user_verify']==1)
	header('Location: index.php');
if(isset($user)&&($user==2)&&$_COOKIE['user_type']==2){
	header('Location: index.php');
}
if(isset($user)&&($user==3)&&$_COOKIE['user_type']!=0){
	header('Location: index.php');
}
if(isset($user)&&($user==4)&&$_COOKIE['user_type']!=1){
	header('Location: index.php');
}
?>
