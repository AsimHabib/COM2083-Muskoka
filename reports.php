<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}
$page_title = 'Muskoka Discovery Center';
$selected = "reports";
$current_id = ' id="current"';
require('header-staff.php');  
?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<h1>Reports</h1>
				</div>
				<div class="col-md-8 col-sm-8"></div>
			</div>
		</div>
	</div>
	<div class="row white-bg content">
		<div class="col-md-2 col-sm-3"> </div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4 col-sm-4 report"><a href="camper-sheet.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Daily Camper Sheets</a></div>
					<div class="col-md-4 col-sm-4 report"><a href="parent-report.php"><i class="fa fa-users" aria-hidden="true"></i> Parent Sign IN/OUT Reports </a></div>
					<div class="col-md-4 col-sm-4 report"><a href="stats-report.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> Stats Report</a> </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
