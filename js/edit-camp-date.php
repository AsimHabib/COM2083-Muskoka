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
    if((!empty($_GET['camp_id'])) && (is_numeric($_GET['camp_id']))) {

    //if we do, store in a variable
    $camp_id = $_GET['camp_id'];

    //connect dB    
     require_once('db.php'); 
 
    //select the user name for the selected user
    $sql = "SELECT * FROM tbl_staff WHERE camp_id = :camp_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':camp_id',$camp_id, PDO::PARAM_INT);
	$cmd->execute();
	$camps = $cmd->fetchAll();
 
    //store each value from the database into a variable
    foreach($camps as $camp){
    	$camp_date = $camp['camp_reg_date'];
    }
 
    //disconnect
    $conn = null;
} // end of if 
    ?>


    <!-- add camp  -Modal  -->

<div id="add-date" class="modal fade" role="dialog">
	<div class="modal-dialog"> 
		<!-- Modal content-->
		<div class="modal-content staff">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add New Date For Camp</h4>
			</div>
			<div class="modal-body">
				<form class="form-signin" id="add-camp-date-form" method="post" action="save-camp.php">
					<div class="form-group">
						<input type="date" placeholder="date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $camp_date; ?>" id="camp_reg_date" name="camp_reg_date" >
						<span id="check-e"></span>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" id="btn-submit" name="btn-submit">Add Camp </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

    
<?php
  require_once('footer.php'); 
?>