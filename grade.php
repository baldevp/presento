<?php
$user=5;
$title="Grade Allotment";
include_once('includes/head.php');
$query="select * from presento_user where user_type=0";
$connect=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
$num5=mysqli_num_rows(mysqli_query($connect,$query));
$num6=$num5-$num5/2;
$num7=$num5/2;
$num4=$num6-$num6/2;
$num3=$num6/2;
$num2=$num7-$num7/2;
$num=$num7/2;
$query="select user_id from presento_user where user_type=0 order by cpi desc";
$data=mysqli_query($connect,$query);
$i=0;
while($row=mysqli_fetch_array($data)){
$i++;
echo $i;
if($i<=$num7){
	if($i<=$num){
		$query="update presento_user set grade=1 where user_id='".$row['user_id']."'";
		mysqli_query($connect,$query);
		echo 'User '.$row['user_id'].' allotted group 1';
	}
	else{
		$query="update presento_user set grade=2 where user_id='".$row['user_id']."'";
		mysqli_query($connect,$query);
		echo 'User '.$row['user_id'].' allotted group 2';
	}
}
else if($i<=$num5){
	if(($i-$num6)<=$num3){
		$query="update presento_user set grade=3 where user_id='".$row['user_id']."'";
		mysqli_query($connect,$query);
		echo 'User '.$row['user_id'].' allotted group 3';
	}
	else{
		$query="update presento_user set grade=4 where user_id='".$row['user_id']."'";
		mysqli_query($connect,$query);
		echo 'User '.$row['user_id'].' allotted group 4';
	}
}
}
header('Location: index.php');
include_once('includes/script.php');
include_once('includes/footer.php');
?>