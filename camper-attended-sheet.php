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

//if we do, store in a variable
    $camp_reg_date = $_GET['camp_reg_date'];


// connect to the db
        require('db.php');
	$sql = "SELECT * FROM  tbl_campers_registration WHERE camper_reg_date = :camp_reg_date";
    $cmd = $conn -> prepare($sql);
    $cmd -> bindParam(':camp_reg_date', $camp_reg_date, PDO::PARAM_INT);
    $cmd->execute();
    $campers = $cmd -> fetchAll();
?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<h1>Reports</h1>
				</div>
				<div class="col-md-8 col-sm-8"> <span>
					<form class="search" action="camper-list.php" method="GET">
						<input  type="text" name="keywords" id="keywords" placeholder="Search by first name..">
					</form>
					</span> </div>
			</div>
		</div>
	</div>
	<div class="row white-bg content">
		<div class="col-md-2 col-sm-3"> </div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>Campers on <?php echo date("l F d, Y", strtotime(($camp_reg_date))); ?> </h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="camper-sheet.php">Back to Camper Sheet </a> </div>
			</div>
			<div class="row">
				<div class="col-md-12 border">
					<ul>
						<?php
	//output data to the user, Using HTML markup and  a loop
	foreach ($campers as $camper)
	
		echo '<li> <a href="#">' . $camper['camper_first_name'] . ' ' . $camper['camper_last_name'] . ' </a></li>';
	
	
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
