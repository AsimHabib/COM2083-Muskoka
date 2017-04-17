<?php
session_start();
if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
}
$page_title = 'Muskoka Discovery Center';
$selected = "camper-list";
$current_id = ' id="current"';
require('header-staff.php');

$camper_id = null;
$parent_signin_name = null;
$parent_signin_time = null;
$parent_signout_time = null;
$signin_status = null;
$signout_status = null;
$camper_first_name =null;
$camper_last_name =null;
$current_date = null;
$date_only= null;
$date_only2= null;

//i	f we do, store in a variable
$camper_id = $_GET['camper_id'];

// 	connect to the db
require('db.php');

// camper info
$sql = "SELECT * FROM tbl_campers_registration WHERE camper_id = :camper_id";
$cmd = $conn -> prepare($sql);
$cmd -> bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
$cmd->execute();
$campers = $cmd -> fetchAll();
foreach ($campers as $camper){	
	$camper_first_name = $camper['camper_first_name'];	
	$camper_last_name = $camper['camper_last_name'];	
	$camper_reg_date = strtotime($camper['camper_reg_date']);
	$camper_reg_date = date("d-m-Y",$camper_reg_date);
	
	
}

// get the today date
 //$current_date = date("d-m-Y");
 var_dump($camper['camper_reg_date']);
 exit;


// camp date info
//$sql2 = "SELECT DATE_FORMAT(camp_reg_date, %Y-%m-%d) FROM tbl_camp  ";
$sql2 = "SELECT * FROM tbl_camp WHERE camp_reg_date = CURDATE() ";
$cmd = $conn -> prepare($sql2);
$cmd->execute();
$dates= $cmd -> fetchAll();
$count_camp = $cmd->rowCount();
foreach ($dates as $date){
$camp_date = strtotime($date['camp_reg_date']);
$date_only = date("d-m-Y",$camp_date);
}


//select all the data for the selected beer
$sql3 = "SELECT * FROM tbl_parents WHERE camper_id =:camper_id AND parent_signin_time >= CURDATE()";
$cmd = $conn -> prepare($sql3);
$cmd -> bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
$cmd->execute();
$parents = $cmd -> fetchAll();
foreach ($parents as $parent){
	$camper_id2 = $parent['camper_id'];
	$parent_signin_name = $parent['parent_signin_name'];
	$parent_signout_name = $parent['parent_signout_name'];
	$parent_signin_time = $parent['parent_signin_time'];	
	$parent_signout_time = $parent['parent_signout_time'];
	$signin_status = $parent['signin_status'];	
	$signout_status = $parent['signout_status'];
//	$only_date = date("Y-m-d",strtotime( $parent_signin_time));	
	$camp_date2 = strtotime($parent['parent_signin_time']);
	$date_only2 = date("d-m-Y",$camp_date2);
} 

//format the signin time
$signin_time = strtotime($parent_signin_time); 
$signin_time = date("H:i A", $signin_time);

$signout_time = strtotime($parent_signout_time); 
$signout_time = date("H:i A", $signout_time);


// var_dump($date_only).'<br />';
// var_dump($current_date).'<br />';
// var_dump($date_only2).'<br />';
// var_dump($camper_reg_date);
// var_dump($parent_signin_name );
// exit;

?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<h1>Parents</h1>
				</div>
				<div class="col-md-8 col-sm-8">
				 </div>
			</div>
		</div>
	</div>
	<div class="row white-bg content">
		<div class="col-md-2 col-sm-3"> </div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<?php 
					echo '<h2>' . $camper_first_name . '  ' . $camper_last_name . '</h2>';
					//disconnect
					$conn = null;
					?>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="registered-camper-list.php">Back to Camper Attendance </a> </div>
			</div>
			<div class="row">
				<div class="col-md-12 input-form border">
					<form method="post" action="parent-time.php">						
						<?php 
						if($date_only != $current_date ){
							echo '<h4>No camp date is not avaibale</h4>';
							exit;
						}
						else if($date_only == $current_date && $camper_reg_date == $current_date){
						if(empty($parent_signin_name) && $signin_status==0){
							echo '
							<label for="parent_signin_name">Sign In:</label>
							<input type="text" name="parent_signin_name" id="parent_signin_name" placeholder="Please Enter Your Name" required/>
							<label for="parent_signout_name">Sign out:</label>
						   <input type="text" class="bg-faded" name="parent_signout_name" id="parent_signout_name" placeholder="Camper must be signed in before signed out" readonly>
						   <button class="blue-btn" type="submit" value="Submit">save & go to List </button>';
						} 
						else if(!empty($parent_signin_name) && $date_only == $date_only2 && $camper_id == $camper_id2 && $signout_status==0){
							
								
							echo '
							 <div class="form-group">
							<label for="parent_signin_name">Sign In:</label>
							<input type="text" class="bg-faded" name="parent_signin_name" id="parent_signin_name" value="'.$parent_signin_name.'"  readonly>( Time: '.$signin_time.' )</div>
							
							<label for="parent_signout_name">Sign out:</label>
						<input type="text" name="parent_signout_name" id="parent_signout_name" placeholder="Please Enter Your Name"  />
						<button class="blue-btn" type="submit" value="Submit">save & go to List </button>';
						}	else {

							echo '
							<h4>*'.$camper_first_name . '  ' . $camper_last_name .' Already Signed Out for Today</h4>
							<label for="parent_signin_name">Signed In By:</label>
							<div>
							<input type="text" class="bg-faded" name="parent_signin_name" id="parent_signin_name" value="'.$parent_signin_name.'" readonly>( Time: '.$signin_time.' )</div>
							<label for="parent_signout_name">Signed Out By:</label>
						<div><input type="text" name="parent_signout_name" id="parent_signout_name"  value="'.$parent_signout_name.'" readonly />( Time: '.$signout_time.' )</div>
						';
						}		

						} else {
							echo '<h4>'.$camper_first_name . '  ' . $camper_last_name .' is not registered for '. date("l F d, Y",strtotime($date['camp_reg_date'])).'</h4>';
						}
						?>
						<br>
						<input type="hidden"  name="camper_id" id="camper_id" value="<?php echo $camper_id;?>" />
						<input type="hidden"  name="signin_time" id="signin_time" value="<?php echo $parent_signin_time;?>" />
						<input type="hidden"  name="signout_time" id="signout_time" value="<?php echo $parent_signout_time;?>" />
						<input type="hidden"  name="camper_first_name" id="camper_first_name" value="<?php echo $camper_first_name ;?>" />
						<input type="hidden"  name="camper_last_name" id="camper_last_name" value="<?php echo $camper_last_name ;?>" />													
						
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php');

?>
