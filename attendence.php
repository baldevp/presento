<?php
$user=4;
$title="Attendence";
include_once('includes/head.php');
?>
<div id="login_outer">
	<div class="container content">
		<h1>Attendence</h1>
		<?php if(isset($error)) echo '<div class="error visible">'.$error.'</div>';?>
		<?php
		$connect=mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
		$querygrp="select * from presento_group where project_mentor='".$_COOKIE['user_id']."'";
		$group=mysqli_query($connect,$querygrp);
		$group=mysqli_fetch_assoc($group);
		if(!is_null($group)){
		$query="select * from presento_user where group_no='".$group['group_id']."' order by grade asc limit 4";
		$stu=mysqli_query($connect,$query);
		if(isset($_POST['submit'])){
			$max=$_POST['maxMarks'];
			$completion=$_POST['completion'];
			$i=0;
			while($row=mysqli_fetch_array($stu)){
				$query="insert into presento_attendence(user_id,attendence,date) values('".$row['user_id']."','".$_POST['stuatten'.$i]."',DATE(now()))";
				mysqli_query($connect,$query);
				$query="insert into presento_marks(user_id,marks_aw,max_marks) values('".$row['user_id']."','".$_POST['stumark'.$i]."','$max')";
				mysqli_query($connect,$query);
				$i++;
			}
			$query="update presento_group set completion='$completion' where group_id='".$group['group_id']."'";
			mysqli_query($connect,$query);
			$error="Updated the details";
		}
		?>
		<form method="POST">
		<?php
		$i=0;
		while($row=mysqli_fetch_array($stu)){
			?>
			<div class="row">
			<div class="col-md-3"><?php echo $row['user_name']; ?></div>
			<div class="form-group col-md-9">
				<label class="radio-inline">
                         <input type="radio" name="<?php echo 'stuatten'.$i;?>" value="0" required /> Leave
							</label>
					<label class="radio-inline">
							  <input type="radio" name="<?php echo 'stuatten'.$i;?>" value="1" required checked /> Absent
							</label>
				  	<label class="radio-inline">
							  <input type="radio" name="<?php echo 'stuatten'.$i;?>" value="2" required /> Present
							</label>
					<input type="number" class="col-md-offset-2 marks" placeholder="Marks" name="<?php echo 'stumark'.$i;?>" required>
			</div>
			</div>
			<?php
			$i++;
		}
			?>
		<div class="form-group">
				<input type="number" class="form-control" name="maxMarks" placeholder="Maximum Marks">

			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="completion" max="75" placeholder="Preject Completed in % out of 75" value="<?php echo $group['completion'] ?>">
			</div>
			<button type="submit" id="btn" name="submit" class="btn btn-primary">Submit</button>
		</form>
			<?php
	     }
	     else{
		?>
		<p>No group is being mentored by you.</p>
		<?php
	}
		?>
	</div>
</div>
<?php
include_once('includes/script.php');
include_once('includes/footer.php') 
?>