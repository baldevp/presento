<?php
$title="Complain";
$user=2;
include_once('includes/head.php'); 
if(isset($_POST['submit'])){
$querypc="select * from presento_user where user_type=2";
$connect=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
$pc=mysqli_query($connect,$querypc);
$subject='Complaint from'.$_COOKIE['user_name'].'('.$_COOKIE['user_email'].') :'.$_POST['subject'];
	$message= $_POST['message'];
	$from='complaint@cotanz.com';
	$headers = "From: $from" . "\r\n" .
                       "Reply-To: $from" . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
if(mysqli_num_rows($pc)>0&&$_POST['to']==0){
	while($row=mysqli_fetch_array($pc)){
		$email=$row['user_email'];
		mail($email, $subject, $message, $headers);
		$error="Email sent";
	}
}
else if($_POST['to']==1){
	$query="select * from presento_user where user_id='".$_COOKIE['user_id']."'";
	$data=mysqli_query($connect,$query);
	$user=mysqli_fetch_assoc($data);
	$query="select project_mentor from presento_group where group_id='".$user['group_no']."'";
	$mentor=mysqli_query($connect,$query);
	$mentor=mysqli_fetch_assoc($mentor);
	$email=$mentor['user_email'];
	mail($email, $subject, $message, $headers);

}
else
{
	$error="Error sending complaint.";
}
}
?>
	<div id="login_outer">
		<div class="container content">
		<h1>Complaint</h1>
		<?php if(isset($error)) echo '<div class="error visible">'.$error.'</div>';?>
			<form method="POST">
			<?php if($_COOKIE['user_type']==0){
				?>
				<div class="form-group">

					<label class="radio-inline">
                         <input type="radio" name="to" value="0" required /> PC
							</label>
					<label class="radio-inline">
							  <input type="radio" name="to" value="1" required /> Mentor
							</label>
				</div>
				<?php
				 }
				 else{ 
				?>
				<input type="hidden" name="to" value="0">
				<?php
			     }
				?>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Subject" name="subject" required>
				</div>
				<div class="form-group">
					<textarea rows="10" class="form-control" placeholder="Type your message here" name="message" required></textarea>
				</div>
				<button type="submit" name="submit" class="btn btn-danger">Send</button>
			</form>
		</div>
	</div>
<?php 
include_once('includes/script.php');
include_once('includes/footer.php');
?>