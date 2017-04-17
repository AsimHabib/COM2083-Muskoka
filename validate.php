<?php ob_start(); // start the output buffer. It requires when there is header(location) function
session_start();
$page_title = 'User Registeration';
//require_once('header.php');

//collect the form values send from login.php page and store in the variables
$username = $_POST['user_email'];
$password = hash('sha512', $_POST['user_password']);

// DB connection
require_once('db.php');

$sql = "SELECT * FROM tbl_staff WHERE staff_user_name = :username AND staff_password = :password";

$cmd = $conn->prepare($sql);
$cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
$cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
$cmd->execute();

//Returns the number of rows affected by SQL statement 
$count = $cmd->rowCount();

if ($count == 0) {
	echo '<div class="alert alert-warning"><span class="error">*</span>Wrong user name and password.<br />
    <br /><a href="#" onclick="history.go(-1)" class="btn btn-warning btn-xs">Go Back</a></div>';
	//require_once('footer.php');
	exit();	
}
else {
	$users = $cmd->fetchAll();	
	
	if ( password_verify($_POST['password'], $user['password']) ) {
		
		 //$_SESSION['email'] = $user['email'];
        $_SESSION['user_name'] = $user['staff_user_name'];
        //$_SESSION['last_name'] = $user['last_name'];

	} else {
		$_SESSION['message'] = "You have entered wrong password, try again!";
        header("location: error.php");
	}
/* //session_start();//session starts here
	foreach($users as $user) {		
		$_SESSION['user_id'] = $user['staff_id'];
   } */
    $_SESSION['logged_in'] = true;
	header('location:camper-list.php');
}
$conn = null; 

  ob_flush(); ?>
