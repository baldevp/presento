<?php
$user=3;
$title="Team";
include_once('includes/head.php');
$connect=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(isset($_POST['submit'])){
	$proj_name=$_POST['project_name'];
	$desc=$_POST['project_desc'];
	$grade1=$_POST['grade1'];
	$grade2=$_POST['grade2'];
	$grade3=$_POST['grade3'];
	$grade4=$_POST['grade4'];
	$query="insert into presento_group(project_name,project_description) values('$proj_name','$desc')";
	mysqli_query($connect,$query);
	$query="select group_id from presento_group where project_name='$proj_name' and project_description='$desc' order by group_id desc";
	$group=mysqli_query($connect,$query);
	$group=mysqli_fetch_assoc($group);
	$group=$group['group_id'];
	$query="update presento_user set group_no='$group' where user_id=$grade1";
	mysqli_query($connect,$query);
	$query="update presento_user set group_no='$group' where user_id=$grade2";
	mysqli_query($connect,$query);
	$query="update presento_user set group_no='$group' where user_id=$grade3";
	mysqli_query($connect,$query);
	$query="update presento_user set group_no='$group' where user_id=$grade4";
	mysqli_query($connect,$query);
}
?>
<div id="login_outer">
	<div class="container content">
		<h1>Team</h1>
		<?php
		$query="select group_no,grade from presento_user where user_id='".$_COOKIE['user_id']."'";
		$data=mysqli_query($connect,$query);
		$data10=mysqli_fetch_assoc($data);
		if(!is_null($data10['group_no'])){
			echo '<p>Well, you already have a group and its details are as follows.</p>';
			$query="select * from presento_user where group_no='".$data10['group_no']."' order by grade asc";
			$data1=mysqli_query($connect,$query);
			$query="select * from presento_group where group_id='".$data10['group_no']."'";
			$data=mysqli_query($connect,$query);
			$data=mysqli_fetch_assoc($data);
			$query="select * from presento_user where user_id='".$data['project_mentor']."'";
			$data2=mysqli_query($connect,$query);
			$data2=mysqli_fetch_assoc($data2);
			?>
			<table class="table"><tr>
				<?php if(!is_null($data2)){ ?>
				<td><?php echo $data2['user_name']; ?></td>
				<td><?php echo $data2['user_email']; ?></td>
				<td><?php echo $data2['contact_num']; ?></td>
				<td>Mentor</td>
				<?php } 
				else { ?>
				<td>Mentor is not set</td>
				<td></td>
				<td></td>
				<td></td>
				<?php } ?>
				<td></td>
			</tr>
			
			<?php
			while($row=mysqli_fetch_array($data1)){
				?>
					<tr>
						<td><?php echo $row['user_name']; ?></td>
						<td><?php echo $row['user_email']; ?></td>
						<td><?php echo $row['contact_num']; ?></td>
						<td><?php echo $row['user_roll']; ?></td>
						<td><?php echo $row['section']; ?></td>
					</tr>
				<?php
			}
			echo '</table><hr>';
		}
		else{
			$grade=$data10['grade'];
			$i=1;
			?>
			<form method="POST">
				<div class="form-group">
					<input type="text" name="project_name" class="form-control" placeholder="Project Name" required>
				</div>
				<div class="form-group">
					<textarea name="project_desc" class="form-control" placeholder="Project Description(max 1024 words)" rows="10" required></textarea>
				</div>
				<div class="form-group">
				<?php if($grade!=$i){ 
					$i++; ?>
				<select name="grade1" class="form-control" placeholder="Grade A">
					<?php $query="select user_id,user_name from presento_user where grade=1 and group_no is null";
					$data=mysqli_query($connect,$query); 
					while($row=mysqli_fetch_array($data)){?>
					<option value="<?php echo $row['user_id'] ?>"><?php echo $row['user_name']; ?></option>
					<?php } ?>

				</select>
			
			<?php
		}
		else{
			$i++;
		?>
		<input type="hidden" name="grade1" class="form-control" value="<?php echo $_COOKIE['user_id']; ?>">
		<?php } ?>
		</div>
		<div class="form-group">
		<?php if($grade!=$i){ 
					$i++; ?>
				<select name="grade2" class="form-control" placeholder="Grade B">
					<?php $query="select user_id,user_name from presento_user where grade=2 and group_no is null";
					$data=mysqli_query($connect,$query); 
					while($row=mysqli_fetch_array($data)){?>
					<option value="<?php echo $row['user_id'] ?>"><?php echo $row['user_name']; ?></option>
					<?php } ?>

				</select>
			
			<?php
		}
		else{
			$i++;
		?>
		<input type="hidden" name="grade2" class="form-control" value="<?php echo $_COOKIE['user_id']; ?>">
		<?php } ?>
		</div>
		<div class="form-group">
		<?php if($grade!=$i){ 
					$i++; ?>
				<select name="grade3" class="form-control" placeholder="Grade C">
					<?php $query="select user_id,user_name from presento_user where grade=3 and group_no is null";
					$data=mysqli_query($connect,$query); 
					while($row=mysqli_fetch_array($data)){?>
					<option value="<?php echo $row['user_id'] ?>"><?php echo $row['user_name']; ?></option>
					<?php } ?>

				</select>
			
			<?php
		}
		else{
			$i++;
		?>
		<input type="hidden" name="grade3" class="form-control" value="<?php echo $_COOKIE['user_id']; ?>">
		<?php } ?>
		</div>
		<div class="form-group">
		<?php if($grade!=$i){ 
					$i++; ?>
				<select name="grade4" class="form-control" placeholder="Grade D">
					<?php $query="select user_id,user_name from presento_user where grade=4 and group_no is null";
					$data=mysqli_query($connect,$query); 
					while($row=mysqli_fetch_array($data)){ ?>
					<option value="<?php echo $row['user_id'] ?>"><?php echo $row['user_name']; ?></option>
					<?php } ?>

				</select>
			
			<?php
		}
		else{
			$i++;
		?>
		<input type="hidden" name="grade4" class="form-control" value="<?php echo $_COOKIE['user_id']; ?>">
		<?php } 
		?>
		</div>
		<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
		<?php
		}?>
	</div>
</div>
<?php
include_once('includes/script.php');
include_once('includes/footer.php'); 
?>