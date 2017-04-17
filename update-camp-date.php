<?php ob_start(); // start the output buffer. It requires when the is header(location) function
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "manage-staff";
$current_id = ' id="current"';
//require('header-staff.php'); 
        
//addt the error handler in case anything breakes
try{

$camp_id = $_POST['camp_id'];
$camp_reg_date = $_POST['camp_reg_date'];

echo $camp_id;
exit;

//Create a flag to track the completion status of the form
$ok = true;

if (empty($camp_reg_date)) {
	echo '<span class="error">*</span> Date is required.<br />';
	$ok = false;
}


// save only if the form is complete
if ($ok) {

	// Connecting the DB
    require_once('db.php'); 

	// if we have the existing game id
	if(!empty($camp_id)){
		$sql ="UPDATE tbl_camp SET camp_reg_date  =:camp_reg_date  WHERE camp_id =:camp_id";
	}
	
	
    // set the command object
	$cmd = $conn->prepare($sql);

	$cmd->bindParam(':camp_id',$camp_id,PDO::PARAM_INT);
	$cmd->bindParam(':camp_reg_date ', $camp_reg_date , PDO::PARAM_STR);

	//execute the interst
	$cmd->execute();

	//diconnecting DB
	$conn = null;
    header('location:create-camp.php'); 
	
} // end of $ok if
}// close the error handler bracket
//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
  // redirect the page to error page
   //header('location:error.php');   
}

ob_flush();
?>