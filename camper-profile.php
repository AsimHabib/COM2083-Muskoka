<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "camper-profile";
$current_id = ' id="current"';
require('header-staff.php'); 	

include_once 'db.php';

    // write the query to fetch the campers data
	// SELECT * FROM campers WHERE name LIKE %condition% OR LIKE %condition%;
     $sql = "SELECT * FROM tbl_campers";
		
	// check for the search keywords
	$word_list = null;
	$final_keywords = null;
    	
        if(!empty($_GET['keywords'])){
		$keywords = $_GET['keywords'];
		
		//Breaking the string to array of words
		//convert the signle value/string to an array. Use the php explode function
		$word_list = explode(" ",$keywords);
		
		//start the where clause and initialize variables
		$sql.=" WHERE";
		$where = "";
		$counter = 0;

		$search_type = 'OR';//$_GET['search_type'];// from the dropdown 	
		
		//loop through the array of words		
		foreach($word_list as $words){			
			if($counter > 0 ){
			$where .= " $search_type "; // OR or AND form dropdown
		}			
			$where .= " camper_first_name LIKE ?";
			$word_list[$counter] = '%' . $words . '%';
			$counter++;			
		}
		$sql .= $where;
	}
    //order by the at the end
	$sql.=" ORDER BY camper_first_name";

    // run the query and store the results into memory
        $cmd = $conn->prepare($sql);
        $cmd->execute($word_list); //passing in the entire array
        $campers = $cmd->fetchAll();
		$count = $cmd->rowCount();
?>

<div class="container-fluid">
	<div class="row light-blue">
		<div class="col-md-2 col-sm-3"></div>
		<div class="col-md-10 col-sm-9">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<h1>Camper Profile</h1>
				</div>
				<div class="col-md-8 col-sm-8"> <span>
					<form class="search" action="camper-profile.php" method="GET">
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
				<div class="col-md-6 col-sm-6 col-xs-5">
					<h2>Camp Families</h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-7 button"> <a href="create-camper.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Create new profile</a> </div>
			</div>
			<div class="row">
				<div class="col-md-12 border">
					<ul><?php	
						//output data to the user, Using HTML markup and  a loop
						if ($count != 0){
						foreach ($campers as $camper)	{
							echo '<li><a href="camper-info.php?camper_id='. $camper ['camper_id'] .'">' . $camper['camper_first_name'] ."  ". $camper['camper_last_name'] . '</a></li>';	
							}
						} else{
							echo 'No Result Found';
						}
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
