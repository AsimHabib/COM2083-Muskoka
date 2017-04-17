<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}
$page_title = 'Muskoka Discovery Center';
$selected = "camp-registration";
$current_id = ' id="current"';
require('header-staff.php'); 


//read and select the camp_id from url's query string using GET
// need to use the GET instead of pOST becuase we want to collect the QueryString
$camp_id = $_GET['camp_id'];

if(is_numeric($camp_id)){ // is checking that data should be numeric

//Connect DB
require_once('db.php'); 

// write and run the delete query
$sql = "DELETE FROM tbl_camp WHERE camp_id = :camp_id"; // this is the way to prevent SQL injectoin by using placeholder

$cmd = $conn->prepare($sql);
$cmd->bindParam(':camp_id', $camp_id, PDO::PARAM_INT);
$cmd->execute();

// disconnect
$conn = null;

//redirect back to camp-registration.php
header('location:create-camp.php');
//header("Refresh: 1; url=view_users_list.php");
//echo '<div class="alert alert-success">User deleted successfully.<br />You\'ll be redirected in about 2 secs. If not, click <a href="view_users_list.php">here</a>.</div>'; 

}
require_once('footer.php');
//ob_flush();
?>