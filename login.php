<?php $title="Presento-Login";
	  $user=0;
		include_once('includes/head.php');
		?>
    <div id="login_outer">
	    <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3" id="login_inner">
	    	<div class="align-left"><h1>Log In</h1></div>
	    	<form action="">
	    		<div class="form-group">
				    <input type="email" class="form-control" placeholder="Email" name="email">
               </div>
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Password" name="pass">	
               </div>
               <button type="submit" class="btn btn-primary">Submit</button>
               <a href="" class="col-xs-offset-2">Forgot Password</a>
               <a href="" class="col-xs-offset-2">Create an Account</a>
	    	</form>
	    </div>
     </div>
<?php 
include_once('includes/footer.php');
?>
