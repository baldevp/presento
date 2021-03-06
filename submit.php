<?php
	$title="Submit Task";
	$user=3; 
	include_once('includes/head.php');
	$connect=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	if(isset($_POST['submit'])){
		$task_id=$_POST['task_id'];
		$loc='uploads/';
		$name = $_FILES["file"]["name"];
        $ext = end((explode(".", $name)));
        $name= $task_id.'_'.rand().'.'.$ext;
        $path=$loc.$name;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
        	$query="select file_name from presento_submission where task_id='$task_id'";
        	$data=mysqli_query($connect,$query);
        	while($row=mysqli_fetch_array($data)){
        		unlink('uploads/'.$row['file_name']);
        	}
        	$query="delete from presento_submission where task_id='$task_id'";
        	mysqli_query($connect,$query);
        	$query="insert into presento_submission(task_id, file_name,submit_time) values('$task_id','$name',now())";
        	mysqli_query($connect,$query);
        	$error="Submitted file";
        }
        else{
        	ini_set('display_errors',1);
            error_reporting(E_ALL);
        	$error="Error uploading file";
        }
	}
?>
	<div id="login_outer">
		<div class="container content">
			<h1>Submit Tasks</h1>
			<?php if(isset($error)) echo '<div class="error visible">'.$error.'</div>';?>
			<p>Please upload a single file. In case of multiple files zip the file.</p>
			<?php
			$query="select group_no from presento_user left join presento_group on presento_group.group_id=presento_user.group_no where user_id='".$_COOKIE['user_id']."' and project_mentor is not null limit 1";
			$data=mysqli_query($connect,$query);
			$data=mysqli_fetch_assoc($data);
			$query="select * from presento_task where task_status=0 and DATE(now())<=DATE(task_dead) and group_id='".$data['group_no']."' and submission_req=1";
			$data=mysqli_query($connect,$query);
			if(mysqli_num_rows($data)>0){
				while($row=mysqli_fetch_array($data)){
					echo '<div class="row"><div class="col-md-8">'.$row['task_desc'].' : '.$row['task_dead'].'</div>';
					?>
					<div class="col-md-4">
						<form method="POST" enctype="multipart/form-data">
							<div class="form-group">
							<input type="file" name="file" id="fileToUpload" class="form-control" required>
							</div>
							<input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
							<button type="submit" name="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
					<?php
					echo '</div>';
				}
			}
			else 
				echo 'N/A';
			?>
		</div>
	</div>
<?php
	include_once('includes/script.php');
	include_once('includes/footer.php'); 
?>