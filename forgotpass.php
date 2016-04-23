<?php $title="Presento-Forgot Password";
	  $user=0;
	  	include_once('includes/redirectlogin.php');
		include_once('includes/head.php');
		include_once('includes/forgotpass.php');
		?>
<div id="login_outer">
	    <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3" id="login_inner">
	    <div class="align-left"><h1>Forgot Password</h1></div>
	    	<?php if(isset($error))
	    		echo '<div class="error visible">'.$error.'</div>';
	    	?>

	    	<form method="POST">
	    		<div class="form-group">
				    <input type="email" class="form-control" placeholder="Email" name="email" required>
               </div>
               <button type="submit" name="submit" class="btn btn-primary">Log In</button>
               <a href="login.php" class="col-xs-offset-2">Log In</a>
               <a href="register.php" class="col-xs-offset-2">Create an Account</a>
	    	</form>
<?php 
include_once('includes/script.php');
include_once('includes/footer.php');
?>