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
?>
		<!-- Registeration Form Starts -->
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
					<h2>Add New Staff</h2>
				</div>				
			</div>
		<div class="row">
				<div class="col-md-12 border">				
				<form method="post" action="save-staff.php" class="form-horizontal">
					<div class="form-group">
						<label for="inputEmail" class="control-label col-xs-2">Email</label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="inputEmail" name="user_email" placeholder="Email" required>
						</div>
					</div>

					<div class="form-group">
						<label for="inputPassword" class="control-label col-xs-2">Password</label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="inputPassword" name="user_password" placeholder="Password" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="control-label col-xs-2">Confirm Password</label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="inputPassword" name="confirm_user_password" placeholder="Password" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-offset-2 col-sm-4">
							
							<button class="red-btn" type="submit" value="Submit">Register </button>
						<button class="grey-btn" type="reset" name="cancel" value="cancel">cancel </button>
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
