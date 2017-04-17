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

require_once('db.php');

//fetch the existing user names from the database
$sql = "SELECT * FROM tbl_camp";

//run the query and store the result into memory
$cmd = $conn->prepare($sql);
$cmd->execute();
$rows = $cmd->fetchAll();
$count = $cmd->rowCount();

foreach($rows as $row){
	$getDate = strtotime($row['camp_reg_date']);
	}
?>
<!-- Edit camp  -Modal  -->

<div id="edit-date" class="modal fade" role="dialog">
	<div class="modal-dialog"> 
		<!-- Modal content-->
		<div class="modal-content staff">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Date For Camp</h4>
			</div>
			<div class="modal-body">
				<form class="form-signin" id="add-camp-date-form" method="post" action="<?php echo 'update-camp-date.php?camp_id='. $row['camp_id']; ?>">
					<div class="form-group">
						<input type="date" placeholder="date" min="<?php echo date("Y-m-d"); ?>"  id="camp_reg_date" name="camp_reg_date" >
						<span id="check-e"></span>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" id="edit-btn-submit" name="btn-submit">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

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
						<input type="date" placeholder="date" min="<?php echo date("Y-m-d"); ?>" id="camp_reg_date" name="camp_reg_date" >
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
<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2"></div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-4">
					<h1>Registration</h1>
				</div>
				<div class="col-md-8"></div>
			</div>
		</div>
	</div>
	<div class="row white-bg content">
		<div class="col-md-2 col-sm-3"> </div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<h2>Camps Date</h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6 button"> <a data-toggle="modal" data-target="#add-date" href="#"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Add New Camp</a> </div>
			</div>
			<div class="row ">
				<div class="col-md-12 border">
					<ul>
						<?php
                foreach($rows as $row){
                    $getDate = strtotime($row['camp_reg_date']);
                    if($count == 0){            
                        echo "no row found";       
                    }  else{          
                       // $date = date("l F d, Y", $getDate); 
                        echo '<li><a href="camper-registration.php?camp_id='.$row['camp_id'].'">'. date("l F d, Y", $getDate) .'</a></li>'; 
						echo '<a data-toggle="modal" data-target="#edit-date" href="update-camp-date.php?camp_id='. $row['camp_id'] .'" class="btn btn-sm btn-info "><i class="fa fa-edit" aria-hidden="true"></i></a>';  
						echo '<a href="delete-camp-date.php?camp_id='. $row['camp_id'] .'"data-toggle="confirmation" data-title="Are You Sure?" data-btn-ok-class="btn-success" data-btn-cancel-class="btn-danger"" class="btn btn-sm btn-danger delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';  

						//echo '<input type="hidden" name="camp_id" id="camp_id" value = "'.$row['camp_id'].'" />';
                    }
                }
                //disconnect DB
                $conn = null;
                 ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.php'); 
?>
