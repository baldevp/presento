<?php $title="Presento-Register";
	  $user=0;
	  	include_once('includes/redirectlogin.php');
		include_once('includes/head.php');
		include_once('includes/register.php');
?>
<div id="login_outer">
	    <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3" id="login_inner">
	    	<div class="align-left"><h1>Register</h1></div>
	    	<div class="error">Password and confirm password must match and/or password must be 8 digits long</div>
	    	<?php if(isset($error))
	    			echo '<div class="error visible">'.$error.'</div>'; ?>
	    	<form method="POST" id="register" onsubmit="return validate()">
				<div class="form-group">
					<label class="radio-inline">
                         <input type="radio" name="userType" value="0" required /> Student
							</label>
					<label class="radio-inline">
							  <input type="radio" name="userType" value="1" required /> Mentor
							</label>
				  	<label class="radio-inline">
							  <input type="radio" name="userType" value="2" required /> PC
							</label>
				</div>
				<div class="form-group">
               		<input type="text" class="form-control" placeholder="Name" name="name">	
               </div>
	    		<div class="form-group">
				    <input type="email" class="form-control" placeholder="Email" name="email" required >
               </div>
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Password" name="pass" id="pass" required >	
               </div>
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Confirm Password" name="confpass" id="confpass" required >	
               </div>
				<fieldset disabled class="student">
					<div class="form-group">
               		<input type="number" class="form-control" placeholder="University Roll Number" min="100000000" max="199999999" name="roll" required>	
                    </div>
					<div class="form-group">
						<input type="number" class="form-control" placeholder="CPI" min="0.00" max="10.00" name="cpi" step="0.01" required >
					</div>
				</fieldset>
               <button type="submit" id="btn" name="submit" class="btn btn-primary">Register</button>
               <a href="forgotpass.php" class="col-xs-offset-2">Forgot Password</a>
               <a href="login.php" class="col-xs-offset-3">Login</a>
	    	</form>
	    </div>
     </div>
<?php include_once('includes/script.php'); ?>
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

 	$('input[type=radio][name=userType]').change(
    function(){

        if ($(this).is(':checked') && $(this).val() == '0') {
            $('.student').removeAttr("disabled");
        }
        else{ $('.student').attr("disabled","disabled");    	 }	
    });
 </script> 
<?php 
include_once('includes/footer.php');
?>
