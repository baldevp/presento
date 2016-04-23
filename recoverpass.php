<?php $title="Presento-Recover Password";
	  $user=0;
	  	include_once('includes/redirectlogin.php');
		include_once('includes/head.php');
		include_once('includes/recoverpass.php');
		?>
    <div id="login_outer">
	    <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3" id="login_inner">
	    	<div class="align-left"><h1>Recover Password</h1></div>
	    	<?php if(isset($error))
	    	echo '<div class="error visible">'.$error.'</div>'; ?>
          <div class="error">Password and confirm password must match and/or password must be 8 digits long</div>
	    	<form method="POST" onsubmit="return validate()">
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Password" name="pass" id="pass" required>	
               </div>
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Retype Password" name="confpass" id="confpass" required>	
               </div>
               <input type="hidden" name="user_id" value="<?php if(isset($id)) echo $id ?>">
               <input type="hidden" name="recovery_key" value="<?php if(isset($key)) echo $key ?>">
               <button type="submit" name="submit" class="btn btn-primary">Submit</button>
               <a href="login.php" class="col-xs-offset-2">Log In</a>
               <a href="register.php" class="col-xs-offset-2">Create an Account</a>
	    	</form>
	    </div>
     </div>
<?php 
include_once('includes/script.php');
?>
<script>
     function validate(){
          var conf=$('#confpass').val();
          var pass=$('#pass').val();

          if(conf!=pass || pass.length<8){
               $(".error").css("display","block");
               return false;
          }
          else{
               $(".error").css("display","none");
          }
     }
</script>

<?php
include_once('includes/footer.php');
?>
