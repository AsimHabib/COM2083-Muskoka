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
//read and select the user_id from url's query string using GET
// need to use the GET instead of pOST becuase we want to collect the QueryString
$user_id = $_GET['user_id'];

if(is_numeric($user_id)){ // is checking that data should be numeric

//Connect DB
require_once('db.php'); 

if($user_id == 1){
    echo "Master login can not be deleted";
}else{
// write and run the delete query
$sql = "DELETE FROM tbl_staff WHERE staff_id = :user_id"; // this is the way to prevent SQL injectoin by using placeholder


$cmd = $conn->prepare($sql);
$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$cmd->execute();
}

/************************/
// disconnect
$conn = null;

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
					<h2>Delete Staff</h2>
				</div>				
			</div>
		<div class="row">
				<div class="col-md-12 border">';

if($user_id == 1){
    echo "Master login can not be deleted";
}else{
//redirect back to view-staff-list.php
header("Refresh: 2; url=view-staff-list.php");
echo '<div class="alert alert-success">Staff deleted successfully.<br />You\'ll be redirected in about 2 secs. If not, click <a href="view-staff-list.php">here</a>.</div>'; 
echo '</div></div></div></div>'; 
}

}
require_once('footer.php');
ob_flush();
?>