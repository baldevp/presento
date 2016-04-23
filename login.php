<?php $title="Presento-Login";
	  $user=0;
	  	include_once('includes/redirectlogin.php');
		include_once('includes/head.php');
		include_once('includes/login.php');
		?>
    <div id="login_outer">
	    <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3" id="login_inner">
	    	<div class="align-left"><h1>Log In</h1></div>
	    	<?php if(isset($used))
	    	echo '<div class="error visible">Please enter correct details</div>'; ?>
	    	<form method="POST">
	    		<div class="form-group">
				    <input type="email" class="form-control" placeholder="Email" name="email" required>
               </div>
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Password" name="pass" required>	
               </div>
               <button type="submit" name="submit" class="btn btn-primary">Log In</button>
               <a href="forgotpass.php" class="col-xs-offset-2">Forgot Password</a>
               <a href="register.php" class="col-xs-offset-2">Create an Account</a>
	    	</form>
	    </div>
     </div>
<?php 
include_once('includes/script.php');
include_once('includes/footer.php');
?>
