<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "reports";
$current_id = ' id="current"';
require('header-staff.php');  

//if we do, store in a variable
//$camp_reg_date = $_GET['camp_reg_date'];


// connect to the db
    require('db.php');
	$sql = "SELECT * FROM tbl_campers";
    $cmd = $conn -> prepare($sql);
    $cmd -> bindParam(':camp_reg_date', $camp_reg_date, PDO::PARAM_STR);
    $cmd->execute();
    $campers = $cmd -> fetchAll();
    //$count = mysql_num_rows($campers);
	//$count = $cmd -> rowCount();
    foreach($campers as $camper){
        $t_days = count($camper['camper_reg_date']);
        echo $t_days;
    }
    echo $t_days;
    exit;
?>


<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<h1>Reports</h1>
				</div>
				<div class="col-md-8 col-sm-8"> <span>
					<form class="search" action="camper-list.php" method="GET">
						<input  type="text" name="keywords" id="keywords" placeholder="Search by first name..">
					</form>
					</span> </div>
			</div>
		</div>
	</div>
	<div class="row white-bg content">
		<div class="col-md-2 col-sm-3"> </div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>Campers on <?php echo date("l F d, Y", strtotime(($camp_reg_date))); ?> </h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="parent-report.php">Back to Parent Signin/out  </a> </div>
			</div>
			<div class="row">
				<div class="col-md-12 border">
					<ul>
						<?php
						

	/*loop through the data, displaying each value in a new column and each beer in a new row*/
	if($count != 0 ){
		echo '<table class="table table">
				<thead> 
					<th>Name</th> 
					<th>Parent Name & Signin Time</th> 
					<th>Parent Name & Signout Time</th> 
				</thead>
				<tbody>';
	foreach($campers as $camper){
		echo '<tr>
				<td>' . $camper['camper_first_name'] . $camper['camper_last_name'] . '</td>
				<td>' . $camper['parent_signin_name'] . '&nbsp; ' . $camper['parent_signin_time'] . '</td>
				<td>' . $camper['parent_signout_name'] . ' &nbsp;' . $camper['parent_signout_time'] .'</td>
			</tr>';
			}
			} else {
				echo 'Now Record Found';
			}
	//close html grid
	echo'</tbody></table>';
						
						
	
	
	
	//disconect
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
