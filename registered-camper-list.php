<?php
session_start();
if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
}

$page_title = 'Muskoka Discovery Center';
$selected = "camper-list";
$current_id = ' id="current"';
require('header-staff.php');  

$camper_id = null;
$parent_signin_name = null;
$parent_signin_time = null;
$parent_signout_time = null;
$signin_status = null;
$signout_status = null;
$camper_first_name =null;
$camper_last_name =null;
$current_date = null;

// get the today date
 $current_date = date("d-m-Y");

// connect to the db
require('db.php');
// $sql = "SELECT * , COUNT(camper_reg_date) FROM tbl_campers_registration GROUP BY camper_id HAVING camper_reg_date >= CURDATE()";
$sql ="SELECT camper_id,camper_first_name, camper_last_name,camper_reg_date , COUNT(*) FROM tbl_campers_registration
WHERE camper_reg_date >= CURDATE()
GROUP BY camper_id ORDER BY camper_first_name ASC";

// run the query and store the results into memory
$cmd = $conn->prepare($sql);
$cmd->execute();
$campers = $cmd->fetchAll();
$count = $cmd->rowCount();

?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<h1>List Of Registered Campers</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="row white-bg content">
		<div class="col-md-2 col-sm-3"> </div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-12">
					<h2>Camper Attendance </h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 border">
					<ul>
						<?php
						//output data to the user, Using HTML markup and  a loop
						foreach ($campers as $camper){
							$camper_id = $camper ['camper_id'];
							$reg_date = $camper['camper_reg_date'];
							$num = $camper['COUNT(*)'];
							echo '<li>
							<a href="parent-signin.php?camper_id='. $camper ['camper_id'] .'">'. $camper['camper_first_name'] .' '. $camper['camper_last_name'] .' '.			
							'<span class="badge">'.$num .'</span></a></li>';	
						}
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
<?php
require('footer.php'); 
?>
