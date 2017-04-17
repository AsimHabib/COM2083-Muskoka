<?php
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}
$_SESSION["message"]='* All fields are required.';  
$page_title = 'Muskoka Discovery Center';
//require('header-staff.php'); 
try {
    //form inputs in variables
    $camper_id = $_POST['camper_id'];    
    $payment_date = $_POST['payment_date'];
	$amount_paid = $_POST['amount_paid'];
	$payment_type = $_POST['payment_type'];
    
    // flag
    $ok = true;

    if (empty($payment_date) || empty($amount_paid) ) {
	//echo '<div style="width:100%; text-align:center;"><h4><span class="error">*</span> All fields are required</h4></div><br />';
	//header('Refresh: 1; payment-info.php?camper_id='.$camper_id);
     header('location:error.php');
	$ok = false;
    exit;
}
    
  

    //connect to the db
    require('db.php');

    //Write the query to fetch the user data
    $sql = "SELECT * FROM tbl_payment WHERE camper_id = $camper_id";    
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $result = $cmd->fetchAll();

    foreach($result as $row){
        $cpr_id = $row['camper_id'];
    }

   if($ok){
    // setup the SQL command to save the data         
    //if($cpr_id == '' || $cpr_id == null){
         $sql = "INSERT INTO tbl_payment (payment_date,payment_amount_paid,payment_type,camper_id) VALUES (:payment_date, :payment_amount_paid,:payment_type,:camper_id)";
		//} 
        
        /*else {       
        $sql ="UPDATE tbl_payment SET payment_date =:payment_date, payment_amount_paid =:payment_amount_paid,
         payment_type =:payment_type, camper_id = :camper_id WHERE camper_id = :camper_id";			
		}*/

        // create a command object
        $cmd = $conn->prepare($sql);

        // put each input value into the proper field        
        $cmd->bindParam(':payment_date', $payment_date, PDO::PARAM_STR);
		$cmd->bindParam(':payment_amount_paid', $amount_paid, PDO::PARAM_INT);
		$cmd->bindParam(':payment_type', $payment_type, PDO::PARAM_STR);
        $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);

        // execute the save
        $cmd->execute();

        // disconnect
        $conn = null;

        header('Location: payment-info.php?camper_id='.$camper_id);
    
   } //ok
     }// close the error handler bracket
    

catch (Exception $e) {
    //header('location:error.php');
    echo 'Message: ' .$e->getMessage();
}   
?>