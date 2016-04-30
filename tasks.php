<?php
$user=4;
$title="Tasks";
include_once('includes/head.php');
$connect=mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if(isset($_POST['submit1'])){
	$attach=$_POST['attachment'];
	$desc=$_POST['desc'];
	$from=$_POST['from'];
	$deadline=$_POST['deadline'];
	$weightage=$_POST['weightage'];
	if($from==1){
		$query="select * from presento_group where project_mentor='".$_COOKIE['user_id']."'";
		$data=mysqli_query($connect,$query);
		$data=mysqli_fetch_assoc($data);
		$query="insert into presento_task(task_desc,task_dead,group_id,submission_req,percent_weightage,submit_to) values('$desc','$deadline','".$data['group_id']."','$attach','$weightage','$from')";mysqli_query($connect,$query);
	}
	else if($from==0){
		$query="select * from presento_group";
		$data=mysqli_query($connect,$query);
		while($row=mysqli_fetch_array($data)){
			$query="insert into presento_task(task_desc,task_dead,group_id,submission_req,percent_weightage,submit_to) values('$desc','$deadline','".$row['group_id']."','$attach','$weightage','$from')";
			mysqli_query($connect,$query);
		}
	}
}
if(isset($_POST['submit2'])){
	$task="select * from presento_task where task_id='".$_POST['task_id']."'";
	$task=mysqli_query($connect,$task);
	$task=mysqli_fetch_assoc($task);
	$query="update presento_task set task_status=1 where task_id='".$_POST['task_id']."'";
	echo $query;
	mysqli_query($connect,$query);
	$project="select * from presento_group where group_id='".$task['group_id']."'";
	$project=mysqli_query($connect,$project);
	$project=mysqli_fetch_assoc($project);
	$query="update presento_group set completion='".($project['completion']+$task['percent_weightage'])."' where group_id='".$task['group_id']."'";
	mysqli_query($connect,$query);
}
if(isset($_POST['submit3'])){
	$task_id=$_POST['task_id'];
	$filename=$_POST['file'];
	unlink('uploads/'.$filename);
	$query="delete from presento_submission where task_id='$task_id'";
	mysqli_query($connect,$query);
	$from='overseer@cotanz.com';
			$subject="Rejection Notice";
		
	$headers = "From: $from" . "\r\n" .
                       "Reply-To: $from" . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
    $group_id="select group_id from presento_task where task_id='$task_id'";
    $group_id=mysqli_query($connect,$group_id);
    $group_id=mysqli_fetch_assoc($group_id);
    $group_id=$group_id['group_id'];
    $mentor="select * from presento_group join presento_user on presento_group.project_mentor=presento_user.user_id where group_id='$group_id' union select * from presento_group right join presento_user on presento_group.group_id=presento_user.group_no where group_no='$group_id'";
    while($row=mysqli_fetch_array($mentor)){
    	$name=$row['user_name'];
    	$to=$row['user_email'];
    	$message="Dear $name,<br >The submission made by your group for '".$row['task_desc']."' has been declined. Kindly resubmit it before the given deadline to avoid losing marks.";
    	mail($to,$subject,$message,$headers);
    }

}
?>
<div id="login_outer">
	<div class="container content">
		<h2>New Task</h2>
		<?php 
		$query="select group_id from presento_group where project_mentor='".$_COOKIE['user_id']."'";
		$group_id=mysqli_query($connect,$query);
		$group_id=mysqli_fetch_assoc($group_id);
		if(!is_null($group_id)||$_COOKIE['user_type']==2){
			if(!is_null($group_id))
			$group_id=$group_id['group_id'];
		$query="select percent_weightage from presento_task where submit_to=1 and group_id='$group_id'";
			$percent=0;
			$data=mysqli_query($connect,$query);
			while($row=mysqli_fetch_array($data)){
				$percent=$percent+$row['percent_weightage'];
			}
			if(!is_null($group_id))
			echo 'Maximum weightage allocable for group:'.(75-$percent)."<br>";
			if($_COOKIE['user_type']==2){
				$query="select percent_weightage from presento_task where submit_to=0 group by task_desc,added_at";
				$percent1=0;
				$data=mysqli_query($connect,$query);
				while ($row=mysqli_fetch_array($data)) {
					$percent1=$percent1+$row['percent_weightage'];
				}
				echo 'Maximum weightage allocable for group:'.(25-$percent1);
			}
			 ?>
			 <form method="POST">
			 	
			 	<?php if($_COOKIE['user_type']==2&&!is_null($group_id)){?>
			 	<div class="form-group">

			 		<label for="attachment">Post as:</label>
			 		<label class="radio-inline">
                         <input type="radio" name="from" value="1" required /> Mentor
							</label>
					<label class="radio-inline">
							  <input type="radio" name="from" value="0" required checked /> PC
							</label>
			 	</div>
			 	<?php } else if($_COOKIE['user_type']==1){ ?>
			 	<input type="hidden" name="from" value="1">
			 	<?php } else if($_COOKIE['user_type']==2&&is_null($group_id)){?>
			 	<input type="hidden" name="from" value=0>
			 	<?php 
			 }
			 ?>
			 	<div class="form-group">
			 		<label for="attachment">Need Attachment:</label>
			 		<label class="radio-inline">
                         <input type="radio" name="attachment" value="1" required /> Yes
							</label>
					<label class="radio-inline">
							  <input type="radio" name="attachment" value="0" required checked /> No
							</label>
			 	</div>
			 	<div class="form-group">
			 		<textarea name="desc" class="form-control" placeholder="Enter the task description here." rows="2"></textarea>
			 	</div>
			 	<div class="form-group">
			 		<input type="number" min="0" max="<?php if($_COOKIE['user_type']==2)echo 25-$percent1; else echo 75-$percent; ?>" placeholder="Enter the weightage of this task" name="weightage"class="form-control student">
			 	</div>
			 	<div class="form-group">
			 		<input type="date" min="<?php echo date('Y-m-d'); ?>" name="deadline" value="<?php echo date('Y-m-d'); ?>" Placeholder="Deadline" class="form-control">
			 	</div>
			 	<button type="submit" id="btn" name="submit1" class="btn btn-primary">Submit</button>
			 </form>
			 <?php 
			}
			else
				echo '<p>Hey you are not mentor</p>'
			?>
			<hr>
			<h2>Tasks-Mentor</h2>
			<table class="table">
				<?php 
				$query="select group_id from presento_group where project_mentor='".$_COOKIE['user_id']."'";
				$group_id=mysqli_query($connect,$query);
				$group_id=mysqli_fetch_assoc($group_id);
				$group_id=$group_id['group_id'];
				$query="select * from presento_task task2 left join presento_submission on task2.task_id=presento_submission.task_id where group_id='$group_id' and task_status=0 and submit_to=1 and submission_req=0 union select * from presento_task task1 right join presento_submission on task1.task_id=presento_submission.task_id where group_id='$group_id' and task_status=0 and submit_to=1 order by task_dead asc limit 10";
				if(!is_null($group_id)){
				$data=mysqli_query($connect,$query);
				if(mysqli_num_rows($data)>0){
				while ($row=mysqli_fetch_array($data)) {
					?>
					<tr>
						<td><?php echo $row['task_desc'] ?></td>
						<td><?php $now=new DateTime(date('Y-m-d')); $dead=new DateTime($row['task_dead']); if($now>$dead) echo 'Overdue :'.$row['task_dead']; else echo $row['task_dead']; ?></td>
						<td>
							<?php if(!is_null($row['file_name'])){ ?>
						    <a href="<?php echo 'uploads/'.$row['file_name'];?>" download><button class="btn btn-primary">Download</button></a></td>
							<?php } ?>
						</td>
						<td><form method="POST"><input type="hidden" value="<?php echo $row['0']; ?>" name="task_id" >
						<button type="submit" name="submit2" class="btn btn-success">Accept</button></form></td>
						<td>
						<?php if($row['submission_req']==1){ ?>
						<form method="POST"><input type="hidden" value="<?php echo $row['task_id'];?>" name="task_id">
						<input type="hidden" name="file" value="<?php echo 
						$row['file_name'] ?>">
						<button type="submit" name="submit3" class="btn btn-danger">Reject</button></form>
						<?php } ?>
						</td>
					</tr>
					<?php
				}
			}
			else
				$error1="No tasks to be mentored";
			}
			else
				$error1="No group to mentor";
				?>
			</table>
			<?php if(isset($error1)) echo '<div class="visible">'.$error1.'</div>';?>
			<hr>
			<?php if($_COOKIE['user_type']==2){ unset($error1);	?>

			<h2>Tasks-PC</h2>
			<table class="table">
				<?php 
				$query="select * from presento_task task2 left join presento_submission on task2.task_id=presento_submission.task_id where task_status=0 and submit_to=0 and submission_req=0 union select * from presento_task task1 right join presento_submission on task1.task_id=presento_submission.task_id where task_status=0 and submit_to=0 order by task_dead asc limit 10";
				$data=mysqli_query($connect,$query);
				if(mysqli_num_rows($data)>0){
				while ($row=mysqli_fetch_array($data)) {
					?>
					<tr>
						<td><?php echo $row['task_desc'] ?></td>
						<td><?php $now=new DateTime(date('Y-m-d')); $dead=new DateTime($row['task_dead']); if($now>$dead) echo 'Overdue :'.$row['task_dead']; else echo $row['task_dead']; ?></td>
						<td>Group <?php echo $row['group_id'];?></td>
						<td>
							<?php if(!is_null($row['file_name'])){ ?>
						    <a href="<?php echo 'uploads/'.$row['file_name'];?>" download><button class="btn btn-primary">Download</button></a></td>
							<?php } ?>
						</td>
						<td><form method="POST"><input type="hidden" value="<?php echo $row['0']; ?>" name="task_id" >
						<button type="submit" name="submit2" class="btn btn-success">Accept</button></form></td>
						<td>
						<?php if($row['submission_req']==1){ ?>
						<form method="POST"><input type="hidden" value="<?php echo $row['task_id'];?>" name="task_id">
						<button type="submit" name="submit3" class="btn btn-danger">Reject</button></form>
						<?php } ?>
						</td>
					</tr>
					<?php
				}
			}
			else
				$error1="No tasks to be mentored";
				?>
			</table>
			<?php if(isset($error1)) echo '<div class="visible">'.$error1.'</div>';?>
			<hr>
			<?php } ?>
	</div>
</div>
<?php
include_once('includes/script.php');
?>
<script>
	function download(file_name){
		window.location.href = 'uploads/'+file_name;
	}

	$('input[type=radio][name=from]').change(
    function(){
    	var percent=75-<?php echo $percent; ?>;
    	var percent1=25-<?php echo $percent1; ?>;
        if ($(this).is(':checked') && $(this).val() == '0') {
            $('.student').attr("max",percent1);
        }
        else{ $('.student').attr("max",percent);    	 }	
    });
</script>
<?php
include_once('includes/footer.php'); 
?>