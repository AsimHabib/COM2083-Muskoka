<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "camp-date";
$current_id = ' id="current"';
require('header-staff.php'); 
?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-6">
					<h1>Register Camper</h1>
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
					<h2>Register The Camper For Camp</h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="create-camp.php"> Back to Manage Camp</a> </div>
			</div>
			<div class="row">
				<div class="col-md-12 profile border">
					<form enctype="multipart/form-data" method="post" action="save-camper-registration.php">						
						<div class="form-group">
							<label for="camper_registration">Select the Camper to Register</label>
							<select class="form-control" name="camper_id" id="camper_id" required="required">                            
								<?php
                                try {
                                require_once('db.php');
                                // make the query at tbl_campers
                                $camper_sql = "SELECT * FROM tbl_campers";
                                $cmd = $conn->prepare($camper_sql);
                                $cmd->execute();
                                $campers = $cmd->fetchAll();
                                $count = $cmd->rowCount();
                                
                                foreach($campers as $camper) {
									$camper_id = $camper['camper_id'];
                                    //echo '<option>'.$camper['camper_first_name'].'</option>';
                                   echo '<option value="'.$camper['camper_id'].'">' . $camper['camper_first_name'].' '.$camper['camper_last_name'].'</option>';							
                                }
                                //echo $camper['camper_id'];
                               // $conn = null;
                                }
                                catch (Exception $e) {
                                echo 'Message: ' .$e->getMessage();
                            }  
                             ?>
							</select>
						</div>

						<div class="form-group">
							<label for="camper_registration">Available Camp Dates</label>
							<select class="form-control" name="camp_reg_date" id="camp_reg_date" required="required">                            
								<?php
                                try {
                                require_once('db.php');
                                // make the query at tbl_campers
                                $sql = "SELECT * FROM tbl_camp";
                                $cmd = $conn->prepare($sql);
                                $cmd->execute();
                                $result = $cmd->fetchAll();
                                $count = $cmd->rowCount();
                                
                                foreach($result as $row) {
									$camp_id = $row['camp_id'];
                                    //echo '<option>'.$camper['camper_first_name'].'</option>';
                                   $getDate = strtotime($row['camp_reg_date']); 
									$getDate = date("l F d, Y", $getDate);
									echo '<option value="' . $row['camp_reg_date']. '">' . $getDate . '</option>';
                                }
                                //echo $camper['camper_id'];
                                $conn = null;
                                }
                                catch (Exception $e) {
                                echo 'Message: ' .$e->getMessage();
                            }  
                             ?>
							</select>
						</div>
						<br>
						
						<button class="red-btn" type="submit" value="Submit">Resister Camper </button>						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
