<?php
	$user=5;
	$title="Verify Users";
	include_once('includes/head.php');
	$connect=mysqli_connect(DBHOST,DBUSER,DBPASS, DBNAME); 
	if(isset($_POST['submit'])){
		$id=$_POST['id'];
		$count=count($id);
		for($i=0;$i<$count;$i++){
			$query="update presento_user set verify=1 where user_id=$id[$i]";
			mysqli_query($connect,$query);
		}
	}
	if(isset($_POST['submit1'])){
		$id=$_POST['id'];
		$count=count($id);
		for($i=0;$i<$count;$i++){
			$query="delete from presento_user where user_id=$id[$i]";
			mysqli_query($connect,$query);
		}
	}
?>
<div id="login_outer">
	<div class="container content">
	<h1>Verify Users</h1>
		<?php
			$query="select * from presento_user where user_type!=2 and verify=0 order by user_type desc limit 30";
			$data=mysqli_query($connect,$query);
			if(mysqli_num_rows($data)>0){ ?>
		<form method="POST">
			<table class="table">
			<tr>
				<td></td>
				<th>Name</th>
				<th>User Type</th>
				<th>Email</th>
				<th>Contact Number</th>
			</tr>
			<?php while($row=mysqli_fetch_array($data)){?>
			<tr>
				<td><input type="checkbox" name="id[]" value="<?php echo $row['user_id']; ?>" ></td>
				<td><?php echo $row['user_name']; ?></td>
				<td><?php if($row['user_type']==0) echo 'Student'; else echo 'Mentor'; ?></td>
				<td><?php echo $row['user_email'];?></td>
				<td><?php echo $row['contact_num'];?></td>
			</tr>
			<?php } ?>
			</table>
			<button type="submit" name="submit" class="btn btn-success">Verify</button>
			<button type="submit" name="submit1" class="btn btn-danger">Reject</button>
		</form>
		<?php } else echo 'All users are verified' ?>
	</div>
</div>
<?php
include_once('includes/script.php');
?>
<?php
include_once('includes/footer.php'); 
?>