<?php
session_start();

if(isset($_SESSION['user_session'])!="")
{
	header("Location: staff.php");
}

$page_title = 'Muskoka Discovery Center';
require('header.php'); 

?>

<!-- Staff member login -Modal  -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog"> 
		
		<!-- Modal content-->
		<div class="modal-content staff">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Login</h4>
			</div>
			<div class="modal-body">
					<form class="form-signin" method="post" id="login-form">
					  <div id="error">
						<!-- error will be shown here ! -->
					</div>        
					<div class="form-group">
					 <input type="email" placeholder="Username" id="user" name="user_email" >
					 <span id="check-e"></span>
					 </div>
					 <div class="form-group">
					 <input type="password" placeholder="Password" id="password" name="password" > 
					 </div>
					 <div class="form-group">
					<button type="submit" id="btn-login" name="btn-login">
					<span class="glyphicon glyphicon-log-in"></span> &nbsp; Login
					</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid bg">
	<div class="container top">
		<div class="col-md-6 col-sm-3 col-xs-4"> <a href="index.php"><img src="images/logo.png" alt="Muskoka Discovery Center"/></a> </div>
		<div class="col-md-6 col-sm-9 col-xs-8 info">
			<p><a href=""><i class="fa fa-envelope" aria-hidden="true"></i> info@realmuskoka.com</a> </p>
			<p><i class="fa fa-phone" aria-hidden="true"></i> (705) 687-6667</p>
		</div>
	</div>
	<div class="container main">
		<div class="col-md-12">
			<h1>Muskoka Discovery Centre - Day Camp Program</h1>
			<h2>Welcome to the one-of-a-kind Muskoka Discovery Centre where we preserve the traditions of the steamship, boat building and resort era while continually educating the public life in and around the water!</h2>
			<p><!--<a href="camper-list.php">I'm a Parent/Guardian </a>--> <a data-toggle="modal" data-target="#myModal" class="ghost">Staff member - Login </a></p>
		</div>
	</div>
	<div class="container footer">
		<div class="col-md-12">
			<p>Copyright © 2017 webpro. All Rights Reserved.</p>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
