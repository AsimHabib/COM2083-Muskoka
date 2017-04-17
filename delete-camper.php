<?php ob_start();

	//identify the record the user wants to delete
	$camper_id = null;
	$camper_id = $_GET['camper_id'];
	
	
	if(is_numeric($camper_id)){
	
	// connect to the db
        require('db.php');
	
	//prepare query
	$sql = "DELETE FROM tbl_campers WHERE camper_id = :camper_id";
	$cmd = $conn -> prepare($sql);
	$cmd -> bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
	$cmd->execute();
	
	//disconect
	$conn = null;
	
	//redirect back to the updated page
	header('location:camper-profile.php');
	}
ob_flush();
?>
