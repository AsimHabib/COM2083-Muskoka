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


require_once('db.php');

//This query is for get the Date frmo tbl_camp 
$sql = "SELECT * FROM tbl_camp";

//run the query and store the result into memory
$cmd = $conn->prepare($sql);
$cmd->execute();
$result = $cmd->fetchAll();
$count = $cmd->rowCount();

// define the variable and assign the null value to prevent Undefined error
$camper_id = null;
$camper_first_name = null;
$camper_last_name = null;
$camper_rate = null;
$camper_phone = null;
$parent_name = null;
$parent_email = null;

//check if we have an user ID in the querystring
if((!empty($_GET['camper_id'])) && (is_numeric($_GET['camper_id']))) {

//if we do, store in a variable
$camper_id = $_GET['camper_id'];


// make the query at tbl_campers to populate the form for edit purpose
$camper_sql = "SELECT * FROM tbl_campers WHERE camper_id = :camper_id";
$cmd = $conn->prepare($camper_sql);
$cmd->bindParam(':camper_id',$camper_id, PDO::PARAM_INT);
$cmd->execute();
$campers = $cmd->fetchAll();

//store each value from the database into a variable

foreach($campers as $camper){
	$camper_first_name = $camper['camper_first_name'];
	$camper_last_name = $camper['camper_last_name'];
	$camper_rate = $camper['camper_rate'];
	$camper_phone = $camper['phone_number'];
	$parent_name = $camper['parent_name'];
	$parent_email = $camper['parent_email'];
}

//disconnect
$conn = null;
} // end of if 
?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-6">
					<h1>Create New Profile</h1>
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
					<h2>Add Information</h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="camper-profile.php"> Back to Camp Families</a> </div>
			</div>
			<div class="row">
				<div class="col-md-12 profile border">
					<form enctype="multipart/form-data" method="post" action="save-camper.php">
						<div class="form-group">
							<label for="camper_first_name">First Name*:</label>
							<input type="text" name="camper_first_name" id="camper_first_name" value="<?php echo $camper_first_name; ?>" required="required">
						</div>
						<div class="form-group">
							<label for="camper_last_name">Last Name*:</label>
							<input type="text" name="camper_last_name" id="camper_last_name" value="<?php echo $camper_last_name; ?>" required="required" >
						</div>
						<div class="form-group">
							<label for="camper_rate">Rate*:</label>
							<input type="text" name="camper_rate" id="camper_rate" value="<?php echo $camper_rate; ?>" required="required" >
						</div>
						<div class="form-group">
							<label for="camper_image">Image:</label>
							<input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" >
						</div>
						<div class="form-group">
							<label for="phone_number">Phone Number*:</label>
							<input type="tel" name="phone_number" id="phone_number" maxlength="11" value="<?php echo $camper_phone; ?>" required="required" >
						</div>
						<div class="form-group">
							<label for="parent_email">Email Address*:</label>
							<input type="text" name="parent_email" id="parent_email" value="<?php echo $parent_email; ?>" required="required" >
						</div>
						<div class="form-group">
							<label for="parent_name">Parent Name*:</label>
							<input type="text" name="parent_name" id="parent_name" value="<?php echo $parent_name; ?>" required="required" >
						</div>
						<div class="form-group notes">
							<label for="campers_notes">important Notes:</label>
							<textarea rows="2" type="text" name="campers_notes" id="campers_notes"></textarea>
						</div>
						<br>
						<input type="hidden" name="camper_id" id="camper_id" value="<?php echo $camper_id; ?>" />
						<button class="red-btn" type="submit" value="Submit">save </button>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
