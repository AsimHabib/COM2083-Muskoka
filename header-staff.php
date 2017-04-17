<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Muskoka Discovery Center</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="./css/main.css" rel="stylesheet" type="text/css">
<link href="./css/staff.css" rel="stylesheet" type="text/css">
<link href="./css/media.css" rel="stylesheet" type="text/css">
<script src="./js/date.js" type="text/javascript"></script>


</head>
<body>

<div class="menu hidden-md hidden-sm hidden-lg"><i class="fa fa-bars" aria-hidden="true"></i></div>
<div class="container-fluid navigation">
	<div class="row">
		<div class="col-md-12">
		<a href="staff.php"> <img src="images/logo.png"" alt="Muskoka Discovery Center"></a>
		</div>
		<div class="col-md-12">
			<ul>
			<li<?php if ($selected == "camper-list") print $current_id; ?>><a href="registered-camper-list.php"><i class="fa fa-users" aria-hidden="true"></i> Parents</a></li>
				<li<?php if ($selected == "staff") print $current_id; ?>><a href="staff.php"><i class="fa fa-usd" aria-hidden="true"></i> Payment</a></li>				
				<li <?php if ($selected == "camp-date") print $current_id; ?>><a href="create-camp.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Manage Camp</a></li>
				<li <?php if ($selected == "camper-profile") print $current_id; ?>><a href="camper-profile.php"><i class="fa fa-user" aria-hidden="true"></i> Camper Profiles</a></li>
								
				<li <?php if ($selected == "reports") print $current_id; ?>><a href="reports.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Reports</a></li>
				<li<?php if ($selected == "manage-staff") print $current_id; ?>><a href="view-staff-list.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Manage Staff</a></li>
				<li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
			</ul>
		</div>
	</div>
</div>
