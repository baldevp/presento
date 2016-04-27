<?php
$user=3;
$title="Team";
include_once('includes/head.php');
?>
<div id="login_outer">
	<div class="container content">
		<h1>Team</h1>
		<?php
		$connect=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
		$query="select group_no from presento_user where user_id='".$_COOKIE['user_id']."'";
		$data=mysqli_query($connect,$query);
		$data=mysqli_fetch_assoc($data);
		if(!is_null($data['group_no'])){
			echo '<p>Well, you already have a group and its details are as follows.</p>';
			$query="select * from presento_user where group_no='".$data['group_no']."' order by grade asc";
			$data1=mysqli_query($connect,$query);
			$query="select * from presento_group where group_id='".$data['group_no']."'";
			$data=mysqli_query($connect,$query);
			$data=mysqli_fetch_assoc($data);
			$query="select * from presento_user where user_id='".$data['project_mentor']."'";
			$data2=mysqli_query($connect,$query);
			$data2=mysqli_fetch_assoc($data2);
			?>
			<table class="table"><tr>
				<td><?php echo $data2['user_name']; ?></td>
				<td><?php echo $data2['user_email']; ?></td>
				<td><?php echo $data2['contact_num']; ?></td>
				<td>Mentor</td>
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
			?>
			<form method="POST">
				<div class="form-group">
					
				</div>
			</form>
			<?php
		} 
		?>
	</div>
</div>
<?php
include_once('includes/script.php');
include_once('includes/footer.php'); 
?>