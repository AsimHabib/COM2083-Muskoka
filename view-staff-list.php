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

//add the error handler in case anything breakes
try{

//Connect
require_once('db.php'); 

//Write the query to fetch the user data
$sql = "SELECT * FROM tbl_staff";

//run the query and store the result into memory
$cmd = $conn->prepare($sql);
$cmd->execute();
$users = $cmd->fetchAll();

// Start the table and the headings
echo '
<div class="container-fluid">
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
					<h2>Registered Staff</h2>
				</div>	
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="create-staff.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Register New Staff</a> </div>			
			</div>
		<div class="row">
				<div class="col-md-12 border">

		<table class="table table-striped">
		<thead>
		<th>User Name</th>
		<th>Edit</th>
		<th>Delete</th>
		</thead>
		<tbody>';


/* loop through the data, creating a new table row for 
each userand putting each value in a new column
*/
foreach($users as $user){
	//Display the data
    if($user['staff_id'] == 1){

        echo '<tr><td>' . $user['staff_user_name'] . '</td>
	<td><a href="edit-staff.php?user_id='.$user['staff_id'].'" class="btn btn-info">Edit</td>
	<td> </td></tr>';	
    } else{
	
    echo '<tr><td>' . $user['staff_user_name'] . '</td>
	<td><a href="edit-staff.php?user_id='.$user['staff_id'].'" class="btn btn-info">Edit</td>
	<td> <a href="delete-staff.php?user_id='. $user['staff_id'] .'" data-toggle="confirmation" data-title="Are You Sure?" data-btn-ok-class="btn-success" data-btn-cancel-class="btn-danger" data-singleton="true"class="btn btn-danger">Delete</a></td></tr>';	
}
}

//close the table
echo '</tbody></table>';
echo '</div></div></div></div>'; 

//disconnect DB
$conn = null;

}// close the error handler bracket
catch(Exception $e){
   echo 'Message: ' .$e->getMessage();    
    // redirect the page to error page
    header('location:error.php');    
}

require_once('footer.php'); 
ob_flush();
?>