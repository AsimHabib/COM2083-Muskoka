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

// connect to the db
        require('db.php');
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
					<h1>Parents</h1>
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
				<div class="col-md-12">
					<h2>Camper Attendance </h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 border">
					<ul>
						<?php
	//output data to the user, Using HTML markup and  a loop
	foreach ($campers as $camper)
	
		echo '<li><a href="parent-signin.php?camper_id='. $camper ['camper_id'] .'">' . $camper['camper_first_name'] . ' ' . $camper['camper_last_name'] .   '</a></li>';
	
	
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
