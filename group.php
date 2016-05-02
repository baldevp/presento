<?php
$user=5;
$title="Manage Groups";
include_once('includes/head.php'); 
$connect=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(isset($_POST['submit'])){
	$query="update presento_group set project_mentor=".$_POST['mentor']." where group_id=".$_POST['group_id'];
	mysqli_query($connect,$query);

}
?>
<div id="login_outer">
	<div class="container content">
	<h3>Allot Mentor</h3>
			<?php
			$query="select * from presento_group where project_mentor is null limit 10";
			$data=mysqli_query($connect,$query);
			if(mysqli_num_rows($data)>0){
			?>
			<table class="table">
			<?php while($row=mysqli_fetch_array($data)){ ?>
			<tr>
				<td><?php echo $row['project_name'] ?></td>
				<td><?php echo $row['project_description'] ?></td>
				<form method="POST">
					<td><select name="mentor" class="form-control" required>
						<?php
						$query="select project_mentor from presento_group where project_mentor is not null";
						$ment=mysqli_query($connect,$query);
						$i=0;
						while($row1=mysqli_fetch_array($ment)){
							$mentor[$i]=$row1['project_mentor'];
							$i++;
						}
						if(isset($mentor)){
						$ids = join(',',$mentor);
						$query="select user_id, user_name from presento_user where user_type!=0 and verify=1 and user_id not in ($ids)";
					}
						else 
						$query="select user_id, user_name from presento_user where user_type!=0 and verify=1";  
						$data1=mysqli_query($connect,$query);
						while($row1=mysqli_fetch_array($data1)){
						?>
						<option value="<?php echo $row1['user_id']?>"><?php echo $row1['user_name']; ?></option>
						<?php
						} 
						?>
					</select>
					<input type="hidden" name="group_id" value="<?php echo $row['group_id']; ?>"></td>
					<td><button type="submit" name="submit" class="btn btn-primary">Submit</button></td>
				</form>
			</tr>
			<?php }
			echo '</table>';
			} 
			else echo 'No groups left to be allotted.' ;
			?>
			<hr>
			<h3>Group Progress</h3>
			<?php
			$query="select * from presento_group join presento_user on presento_group.project_mentor=presento_user.user_id where project_mentor is not NULL order by completion asc limit 30";
			$data=mysqli_query($connect,$query);
			if(mysqli_num_rows($data)>0){
			?>
			<table class="table">
				<tr><th>Project Name</th><th>Project Description</th><th>Mentor Name</th><th>Project Completion</th></tr>
				<?php while($row=mysqli_fetch_array($data)){ ?>
					<tr>
						<td><?php echo $row['project_name'] ?></td>
						<td><?php echo $row['project_description'] ?></td>
						<td><?php echo $row['user_name'] ?></td>
						<td><?php echo $row['completion'] ?></td>
					</tr>
				<?php } ?>
			</table>
			<?php }
			else echo "No groups to show progress of." ?>
			<hr>
	</div>
</div>
<?php
include_once('includes/script.php');
include_once('includes/footer.php'); 
?>