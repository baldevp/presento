<html>
	<head>
		<?php include_once('includes/checklogin.php') ?>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/animate.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<title><?php echo $title ?></title>
	</head>
	<body>
	<nav class="navbar navbar-default navbar-fixed-top">
	 <div class="container">
       <div class="container-fluid">
       		<div class="navbar-header">
       			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
       			<a href="." class="navbar-brand">Presento</a>
       		</div>

       		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
       				<ul class="nav navbar-nav navbar-right">
       					<?php if(isset($_COOKIE['user_type'])&&$_COOKIE['user_type']==0){ ?>
       					<li><a href="team.php">Team</a></li>
       					<li><a href="submit.php">Submit Task</a></li>
       					<li><a href="complain.php">Complaint</a></li>
       					<li><a href="logout.php">Log Out</a></li>
       					<?php } else if(!isset($_COOKIE['user_type'])){
       						echo '';
       					    }
       						else if(isset($_COOKIE['user_type'])&&($_COOKIE['user_type']==1 || $_COOKIE['user_type']==2)){
       						?>
				        <li><a href="attendence.php">Attendence</a></li>
				        <?php if($_COOKIE['user_type']!=2){ ?>
				        <li><a href="complain.php">Complaint</a></li>
				        <?php } ?>
				        <li><a href="tasks.php">Task</a></li>
				        <li><a href="logout.php">Log Out</a></li>
				        <?php
				        }
				        else{ 
				        ?>
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href="#">Action</a></li>
				            <li><a href="#">Another action</a></li>
				            <li><a href="#">Something else here</a></li>
				            <li role="separator" class="divider"></li>
				            <li><a href="#">Separated link</a></li>
				          </ul>
				        </li>
				        <?php } ?>
			      </ul>
       		</div>
       </div>
       </div>
    </nav>
	<?php include_once('includes/db.php') ?>