<?php ob_start(); // start the output buffer. It requires when the is header(location) function
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "manage-staff";
$current_id = ' id="current"';
require('header-staff.php'); 
        
//addt the error handler in case anything breakes
try{
	
$user_id = null;

//Store the form inputs in variables
$user_name = $_POST['user_email'];
$user_password = $_POST['user_password'];
$user_id = $_POST['user_id']; //get the user ID from the hidden form field

//Create a flag to track the completion status of the form
$ok = true;

//Do the form validation before saving
//validate the form values, if not correct display the error message
echo '<div class="container-fluid">
		<div class="row light-blue">
			<div class="col-md-2 col-sm-3"></div>
			<div class="col-md-10 col-sm-9">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-6">
						<h1>Staff Registration</h1>
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
					<h2>Update Staff</h2>
				</div>				
			</div>
		<div class="row">
				<div class="col-md-12 border">';
if (empty($user_name)) {
	echo '<span class="error">*</span> Email is required.<br />';
	$ok = false;
}
if(!filter_var($user_name, FILTER_VALIDATE_EMAIL)){
	echo '<span class="error">*</span> Valid email is required.<br />';
	$ok = false;
}
if (empty($user_password)){
	echo '<span class="error">*</span>Password is required<br />';
	$ok = false;
}

if($ok == false){
    echo '<br /><a href="#" onclick="history.go(-1)" class="btn btn-warning btn-xs">Go Back</a>'; //go back button
}    
//echo '</div>'; // close the warning div	

// save only if the form is complete
if ($ok) {

	// Connecting the DB
    require_once('db.php'); 

	// if we have the existing game id
	if(!empty($user_id)){
		$sql ="UPDATE tbl_staff SET staff_user_name =:user_name, staff_password =:user_password WHERE staff_id =:user_id";
	}
	
	//hash the password, it'll requre two parameteres
	$hashed_password = hash('sha512', $user_password); //sha512 algorithm convert the password into the 128 character
	// set the command object
	$cmd = $conn->prepare($sql);

	//fill the placeholder with the 4 input variable
	$cmd->bindParam(':user_name', $user_name, PDO::PARAM_STR, 50);
	$cmd->bindParam(':user_password', $hashed_password, PDO::PARAM_STR, 128);
	// bindParam has the builtin sql injection prevention


// add the user_id param if updating
	if(!empty($user_id)){
		$cmd->bindParam(':user_id',$user_id,PDO::PARAM_INT);
	}
	//execute the interst
	$cmd->execute();
	
	header("Refresh: 2; url=view-staff-list.php"); // redirect after updation
	echo '<div class="alert alert-success">Satff is updated.<br />
		You\'ll be redirected.. If not, click <a href="view-staff-list.php">here</a>.	
	  </div>'; // close the success div
      echo '</div></div></div></div>'; 

	//diconnecting DB
	$conn = null;
	
} // end of $ok if
}// close the error handler bracket
//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
  // redirect the page to error page
   //header('location:error.php');   
}
require_once('footer.php');
ob_flush();
?>