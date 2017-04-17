<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "camper-registration";
$current_id = ' id="current"';
require('header-staff.php'); 
?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-6">
					<h1>Error page</h1>
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
					<h4 class="text-danger"><?php 
                if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
                    echo $_SESSION['message'];    
                else:
                    // header( "location: index-staff.php" );
                    echo 'error';
                endif;
                // remove all session variables
                unset($_SESSION['message']);
                ?></h4>
                <p>
                <a href="#" onclick="history.go(-1)" class="btn btn-warning btn-xs">Go Back</a>
                </p>
				</div>				
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>

