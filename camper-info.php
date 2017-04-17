<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "camper-profile";
$current_id = ' id="current"';
require('header-staff.php');  

	$camper_id = null;

	//check if we have an camper ID in the querystring
	if(is_numeric($_GET['camper_id'])){

		//if we do, store in a variable
		$camper_id = $_GET['camper_id'];
		
		// connect to the db
			require('db.php');
	
		//select all the data for the selected beer
		$sql = "SELECT * FROM tbl_campers WHERE camper_id = :camper_id";
		$cmd = $conn -> prepare($sql);
		$cmd -> bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
		$cmd->execute();
		$campers = $cmd -> fetchAll();

		foreach ($campers as $camper){
			$camper_first_name = $camper['camper_first_name'];
			$camper_last_name = $camper['camper_last_name'];
			$camper_image = $camper['camper_image'];		
		}
	}


?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-6">
					<h1>Camper Profile</h1>
				</div>
				<div class="col-md-8 col-sm-6 col-xs-6"> </div>
			</div>
		</div>
	</div>
	<div class="row white-bg content">
		<div class="col-md-2 col-sm-3"> </div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-5">
					<?php
						echo '<h2>' . $camper_first_name . '  ' . $camper_last_name. '</h2>';
					?>
</div>
	<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="camper-profile.php"> Back to Camp Families</a> </div>
			</div>
			
			<div class="row">
				<div class="col-md-12 profile border">
					<div class="row">
						<div class="col-md-3">
							<?php
								echo  '<img src="'. $camper_image . '" ><br />';
							?>
						</div>


<div class="col-md-9 camper-info">
<?php
		
		echo  '<span>First Name: </span>' . $camper['camper_first_name'].'<br>';
		echo  '<span>Last Name: </span>' . $camper['camper_last_name'].'<br>';
		echo  '<span>Rate: </span>$' . $camper['camper_rate'].'<br>';
		//echo  '<span>Registered Date: </span>' . $camper['camper_reg_date'].'<br>';
		echo  '<span>Phone Number: </span>' . $camper['phone_number'].'<br>';
		echo  '<span>Parent Name: </span>' . $camper['parent_name'].'<br>';
		echo  '<span>Email Address: </span>' . $camper['parent_email'].'<br>';
		echo  '<span>Important Notes: </span>' . $camper['campers_notes'].'<br><br>
		<a class="red-btn" href="create-camper.php?camper_id='. $camper['camper_id'] .'" title="edit">Edit</a>
		<a class="grey-btn" href="delete-camper.php?camper_id='. $camper['camper_id'] .'" data-toggle="confirmation" data-title="Are You Sure?" data-btn-ok-class="btn-success" 
	data-btn-cancel-class="btn-danger" class="confirmation">Delete</a>';
	
	//disconnect
	$conn = null;	
?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
