<?php 
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}
$_SESSION["message"]='* Camp date already created for that date.';   
$page_title = 'Muskoka Discovery Center';
$selected = "camp-registration";
$current_id = ' id="current"';
require('header-staff.php'); 


//addt the error handler in case anything breakes
try{

// get the date vlaue from the add-camp-date.php form
$reg_date = $_POST['camp_reg_date'];

$reg_date = strtotime($reg_date);
$reg_date = date("Y-m-d",$reg_date);
// var_dump($reg_date);
// exit;
//Create a flag to track the completion status of the form
$ok = true;

if (empty($reg_date)) {
	echo '<div style="width:100%; text-align:center;"><h4><span class="error">*</span> Date is required</h4></div><br />';
	header("location:error.php");
	$ok = false;
}
//connection
require_once('db.php');

$sql = "SELECT * FROM tbl_camp WHERE camp_reg_date =:camp_date";

//run the query and store the result into memory
$cmd = $conn->prepare($sql);
$cmd->bindParam(':camp_date', $reg_date, PDO::PARAM_STR);
$cmd->execute();
$camps = $cmd->fetchAll();
$count = $cmd->rowCount();

foreach($camps as $camp){
	//$camp_id2 = $camp['camp_id'];
	$camp_reg_date = strtotime($camp['camp_reg_date']);
	$camp_reg_date = date("Y-m-d",$camp_reg_date);
	//echo $camp_reg_date.'<br/>';
}
// var_dump($reg_date).'<br>';
// var_dump($camp_reg_date);
// exit;

if($reg_date == $camp_reg_date){
	echo '<div style="width:100%; text-align:center;"><h4><span class="error">*</span> Date is required</h4></div><br />';
	header("location:error.php");
	$ok = false;
} else {

if($ok){

	$sql = "INSERT INTO tbl_camp (camp_reg_date) VALUES (:reg_date)";	
	
	//fill the params execute
	$cmd = $conn->prepare($sql);
	$cmd->bindParam(':reg_date', $reg_date, PDO::PARAM_STR);
	$cmd->execute();
	
	//disconnect the connection from DB
	$conn = null;

    header('location:create-camp.php');
    }//end of $ok if
}// end of else	

    }// close the error handler bracket
//catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}

?>