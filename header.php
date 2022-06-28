<?php
//header.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Top Glove Employee Management System</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="center">Top Glove Employee Management System</h2>

			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
					<?php
					if($_SESSION['type'] == 'admin')
					{
					?>
						<a href="staff.php" class="navbar-brand">Staff List</a>
					<?php
					}
					?>
					</div>

					<div class="navbar-header">		
					<?php
					if($_SESSION['type'] == 'staff')
					{
					?>
						<a href="employee_staff.php" class="navbar-brand">Staff List</a>
					<?php
					}
					?>

					</div>
					<?php
					if($_SESSION['type'] == 'admin')
					{
					?>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">

													<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["user_name"]; ?></a>
							<ul class="dropdown-menu">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
					<?php
					}
					?>
						</li>
					</ul>

					<?php
					if($_SESSION['type'] == 'staff')
					{
					?>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["staff_name"]; ?></a>
							<ul class="dropdown-menu">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
					<?php
					}
					?>

						</li>
					</ul>

				</div>
			</nav>
			