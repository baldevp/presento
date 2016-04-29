<?php 
$title='Presento';
include_once('includes/head.php'); 
$connect=mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if(isset($_COOKIE['user_type'])&&$_COOKIE['user_type']==0){
$atten=0;
$queryatten="select * from presento_attendence where user_id='".$_COOKIE['user_id']."' and attendence!=0";
$queryatten1="select * from presento_attendence where user_id='".$_COOKIE['user_id']."'";
$querypresent="select * from presento_attendence where user_id='".$_COOKIE['user_id']."' and attendence=2";
$querymarks="select * from presento_marks where user_id='".$_COOKIE['user_id']."'";
$querygroup="select * from presento_user where user_id='".$_COOKIE['user_id']."'";
$group=mysqli_query($connect,$querygroup);
$group=mysqli_fetch_assoc($group);
$queryproject="select * from presento_group where group_id='".$group['group_no']."' limit 1";
$totalmark=0;
$marks=0;
$project=mysqli_query($connect,$queryproject);
$project=mysqli_fetch_assoc($project);
$queryteam="select user_name, user_email, user_roll from presento_user where group_no='".$group['group_no']."' order by grade asc";
$team=mysqli_query($connect,$queryteam);
$data=mysqli_query($connect,$querymarks);
while($row=mysqli_fetch_array($data)){
	$totalmark=$totalmark+$row['max_marks'];
	$marks=$marks+$row['marks_aw'];
}
$attend=mysqli_query($connect,$queryatten);
$present=mysqli_query($connect,$querypresent);
$total=mysqli_query($connect,$queryatten1);

if(mysqli_num_rows($attend)==0){
	$attend=0;
	$present=0;
	$total=0;
}
else{
	$atten=mysqli_num_rows($present)/mysqli_num_rows($attend);
	$atten=round($atten*100);
	$present=mysqli_num_rows($present);
	$attend=mysqli_num_rows($attend);
	$total=mysqli_num_rows($total);

}
?>
	<div id="login_outer">
		<div class="container content">
			<h1>Dashboard</h1>
			<div class="row">
			<div class="col-md-6 col-xs-12 atten">
				<h3>Attendence</h3>
				<div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar"
                    aria-valuemin="20" aria-valuemax="100" style="width:<?php echo $atten ?>%">
                    <?php echo $atten.'%' ?>
                   </div>
                </div>
                <p>Total no. of classes: <?php echo $total ?></p>
                <p>Classes attended: <?php echo $present ?></p>
                <p>Leave taken: <?php echo ($total-$attend) ?></p>
                <h3>Marks: <?php echo $marks ?>/<?php echo $totalmark ?></h3>

			</div>
			<div class="col-md-6 col-xs-12">
				<h3>Team</h3>
				<?php if(mysqli_num_rows($team)>0){
					   while($row=mysqli_fetch_array($team)){
					   	echo '<p>'.$row['user_name'].'('.$row['user_roll'].') : '.$row['user_email'].'</p>';
					   	}
					   	$querymentor="select user_name, user_email from presento_user where user_id='".$project['project_mentor']."'";
					   	$mentor=mysqli_query($connect,$querymentor);
					   	$mentor=mysqli_fetch_assoc($mentor);
					   	if(!is_null($mentor)){
					   		echo '<p>Mentor: '.$mentor['user_name']." : ".$mentor['user_email'].'</p>';
					   	}
					   	}
					   	else
					   	echo 'No team found' ?>
			</div>
			</div>
			<hr>
			<div class="row">
			<div class="col-md-12">
				<h3>Project</h3>
				<p><?php if(!is_null($group['group_no'])){
				echo '<div class="progress">
                  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                    aria-valuemin="20" aria-valuemax="100" style="width:'.$project['completion'].'%">'.$project['completion'].
                   '%</div>
                </div>';
				echo $project['project_description']; }else
				echo 'You have not entered any project yet.' ?></p>
			</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6 col-xs-12 atten">
					<h3>Ongoing Tasks</h3>
					<?php
					$querytask="select * from presento_task where group_id='".$group['group_no']."' and task_status=0 and DATE(now())<=DATE(task_dead) order by task_dead asc limit 5";
						$task=mysqli_query($connect,$querytask);
					if(mysqli_num_rows($task)>0){
						echo '<table class="table">';
						while($row=mysqli_fetch_array($task)){
							echo '<tr><td>'.$row['task_desc'].'</td><td>'.$row['task_dead'].'</td></tr>';
						}
						echo '</table>';
					}
					else
						echo 'N/A';
					?>
				</div>
				<div class="col-md-6 col-xs-12">
					<h3>Task Delayed</h3>
					<?php 
					$querytask="select * from presento_task where group_id='".$group['group_no']."' and task_status=0 and DATE(now())>DATE(task_dead) order by task_dead desc limit 5";
					$task=mysqli_query($connect,$querytask);
					if(mysqli_num_rows($task)>0){
						echo '<table class="table">';
						while($row=mysqli_fetch_array($task)){
							echo '<tr><td>'.$row['task_desc'].'</td><td>'.$row['task_dead'].'</td></tr>';
						}
						echo '</table>';
					}
					else
						echo 'N/A';
					?>
				</div>
			</div>
		</div> 
	</div>
<?php 
}
else if(isset($_COOKIE['user_type'])&&$_COOKIE['user_type']==1){
	$querygroup="select group_id,project_description,completion from presento_group where project_mentor='".$_COOKIE['user_id']."'";
	$group=mysqli_query($connect,$querygroup);
	$group=mysqli_fetch_assoc($group);
	?>
	<div id="login_outer">
		<div class="container content">
		 <h1>Dashboard</h1>
		 <h3>Attendence</h3>

	<?php
	if(!is_null($group)){
	$querystu="select * from presento_user where group_no='".$group['group_id']."' order by grade asc limit 4";
	$stu=mysqli_query($connect,$querystu);
	$i=0;
	while($row=mysqli_fetch_array($stu)){
		$stud[$i]=$row;
		$i++;
	}
	for($i=0;$i<4;$i++){
		$query="select * from presento_attendence where user_id='".$stud[$i]['user_id']."' and attendence !=0";
		$query1="select * from presento_attendence where user_id='".$stud[$i]['user_id']."' and attendence =2";
		$total[$i]=0;
		$attend[$i]=0;
		$total[$i]=mysqli_num_rows(mysqli_query($connect,$query));
		$attend[$i]=mysqli_num_rows(mysqli_query($connect,$query1));
		$query="select max_marks,marks_aw from presento_marks where user_id='".$stud[$i]['user_id']."'";
		$data=mysqli_query($connect,$query);
		$totalmark[$i]=0;
		$marks[$i]=0;
		while($row=mysqli_fetch_array($data)){
			$totalmark[$i]=$totalmark[$i]+$row['max_marks'];
			$marks[$i]=$marks[$i]+$row['marks_aw'];
		}
		if($total[$i]==0){
			$atten=0;
		}
		else{
		$atten=$attend[$i]/$total[$i];
		$atten=round(100*$atten);
	}
	?>	
				<div class="col-md-10">
	             <div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar"
                    aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $atten ?>%">
                    <?php echo $stud[$i]['user_name'] ?>
                   </div>
                </div>
                </div>
                <div class="col-md-2">
                	Marks: <?php echo $marks[$i].'/'.$totalmark[$i]; ?>
                </div>
	<?php
    }
   }
    else{
    	echo '<p>N/A</p>';
    }
    ?>
    <div class="row">
    </div>
    <hr>
    <h3>Project</h3>

		<p><?php if(!is_null($group)){
				echo '<div class="progress">
                  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                    aria-valuemin="20" aria-valuemax="100" style="width:'.$group['completion'].'%">'.$group['completion'].
                   '</div>
                </div>';
				echo $group['project_description']; }else
				echo 'You have not entered any project yet.' ?></p>
	<div class="row"></div>
	<hr>
	<div class="col-md-6">
    <h3>Ongoing Tasks</h3>
    <?php 
     $query="select * from presento_task where group_id='".$group['group_id']."' and task_status=0 and DATE(now())<=DATE(task_dead) order by task_dead asc limit 5";
     $data=mysqli_query($connect,$query);
     if(mysqli_num_rows($data)>0){
     	echo '<table class="table"';
     	while($row=mysqli_fetch_array($data)){
     		echo '<tr><td>'.$row['task_desc'].'</td><td>'.$row['task_dead'].'</td></tr>';
     	}
     	echo '</table>';
     }
     else
     	echo "Your team doesn't have any task";
    ?>
	</div>
	<div class="col-md-6">
	<h3>Delayed Tasks</h3>
    <?php 
     $query="select * from presento_task where group_id='".$group['group_id']."' and task_status=0 and DATE(now())>DATE(task_dead) order by task_dead desc limit 5";
     $data=mysqli_query($connect,$query);
     if(mysqli_num_rows($data)>0){
     	echo '<table class="table"';
     	while($row=mysqli_fetch_array($data)){
     		echo '<tr><td>'.$row['task_desc'].'</td><td>'.$row['task_dead'].'</td></tr>';
     	}
     	echo '</table>';
     }
     else
     	echo "Congrats!! Your team doesn't have any pending task";
    ?>	
	</div>
	<div class="row"></div>
    <hr>
	</div>
    </div>
    <?php
}
include_once('includes/script.php');
include_once('includes/footer.php');
?>