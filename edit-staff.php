<?php 
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "manage-staff";
$current_id = ' id="current"';
require('header-staff.php'); 
        
//intialize the variables to prevent the "Undefined variable" error
$user_name = null;
   
//check if we have an user ID in the querystring
    if((!empty($_GET['user_id'])) && (is_numeric($_GET['user_id']))) {

    //if we do, store in a variable
    $user_id = $_GET['user_id'];

    //connect dB    
     require_once('db.php'); 
 
    //select the user name for the selected user
    $sql = "SELECT * FROM tbl_staff WHERE staff_id = :user_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id',$user_id, PDO::PARAM_INT);
	$cmd->execute();
	$users = $cmd->fetchAll();
 
    //store each value from the database into a variable
    foreach($users as $user){
    	$user_name = $user['staff_user_name'];
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
				<div class="col-md-12 border">				
				<form method="post" action="update-staff.php" class="form-horizontal">
					<div class="form-group">
						<label for="inputEmail" class="control-label col-xs-2">Email</label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="inputEmail" name="user_email" value="<?php echo $user_name; ?>" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="control-label col-xs-2">New Password</label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="inputPassword" name="user_password" placeholder="Password">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-xs-offset-2 col-sm-4">
							<input name="user_id" type="hidden" value="<?php echo $user_id; ?>" /><!-- forward the user ID as hidden value -->
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</div>
				</form>
			</div>               
		</div> 
	</div> <!-- /.row white-bg content-->
	<div><!-- /.container-fluid--> 	
		<!-- Registeration Form Ends -->       
<?php
  require_once('footer.php'); 
?>