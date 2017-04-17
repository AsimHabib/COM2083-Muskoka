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

// connect to the db
        require('db.php');
		  $sql = "SELECT * FROM tbl_camp";

    // run the query and store the results into memory
        $cmd = $conn->prepare($sql);
        $cmd->execute(); //passing in the entire array
        $camps = $cmd->fetchAll();
		$count = $cmd->rowCount();
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
				<div class="col-md-6 col-sm-6">
					<h2>Daily Camper Sheet </h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="reports.php">Back to reports </a> </div>
			</div>
			<div class="row">
				<div class="col-md-12 border">
					<ul>
						<?php
						
	//output data to the user, Using HTML markup and  a loop
	foreach ($camps as $camp){
	$getDate = strtotime($camp['camp_reg_date']);
		 echo '<li><a href="camper-attended-sheet.php?camp_reg_date='. $camp['camp_reg_date']. '">' . date("l F d, Y", $getDate) .'</a></li>'; 
	}
	
	//disconect
	$conn = null;
	
?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
