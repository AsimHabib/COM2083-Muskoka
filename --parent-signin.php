<?php
$page_title = 'Muskoka Discovery Center';
require('header.php'); 
?>
<div class="container-fluid parent-top">
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-sm-5 col-xs-5"> <a href="index.php"><img src="images/logo.png" alt="Muskoka Discovery Center"/></a> </div>
			<div class="col-md-7 col-sm-7 col-xs-7 time"> <span> <i class="fa fa-calendar" aria-hidden="true"></i>
				<p id="date_time"></p>
				<script type="text/javascript">window.onload = date_time('date_time');</script> 
				</span> </span> </div>
		</div>
	</div>
</div>
<div class="container content">
	<div class="row">
		<div class="col-md-12">
		
		<?php
		
	$camper_id = null;

	//check if we have an beer ID in the querystring
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
	
	//store each value from the database into a variable
	foreach ($campers as $camper){
		$camper_first_name = $camper['camper_first_name'];
		$camper_last_name = $camper['camper_last_name'];
		
		echo '<h2>' . $camper['camper_first_name'] . '  ' . $camper['camper_last_name'] . '</h2>';
	}
	
	//disconnect
	$conn = null;
	}
	
	
?>
		</div>
		<div class="col-md-12 input-form border">
			<form method="post" action="parent-time.php">
				<label for="parent_signin_name">Sign In:</label>
				<input type="text" name="parent_signin_name" id="parent_signin_name" placeholder="Please Enter Your Name">
				<label for="parent_signout_name">Sign out:</label>
				<input type="text" name="parent_signout_name" id="parent_signout_name" placeholder="Please Enter Your Name" disabled>
				<br>
				<br>
				<input type="hidden"  name="camper_id" id="camper_id" value="<?php echo $camper_id; ?>" />
				<button class="red-btn" type="submit" value="Submit">save & go to List </button>
				<button class="blue-btn" type="submit" value="Submit">save & go to Home </button>
			</form>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
