<?php ob_start();
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$camp_id = $_GET['camp_id'];
$reg_date = $_POST['camp_reg_date'];

//addt the error handler in case anything breakes
try{

//Create a flag to track the completion status of the form
$ok = true;

if (empty($reg_date)) {
	echo '<span class="error">*</span> Date is required<br />';
	$ok = false;
}

//connection
require_once('db.php');

if($ok){

	$sql ="UPDATE tbl_camp SET camp_reg_date =:camp_reg_date WHERE camp_id =:camp_id";	
	
	//fill the params execute
	$cmd = $conn->prepare($sql);
	$cmd->bindParam(':camp_reg_date', $reg_date, PDO::PARAM_STR);
    $cmd->bindParam(':camp_id', $camp_id, PDO::PARAM_INT);
	$cmd->execute();
	
	//disconnect the connection from DB
	$conn = null;

    header('location:create-camp.php');
    }//end of $ok if

    }// close the error handler bracket
//catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
ob_flush();
?>