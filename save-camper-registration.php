<?php 
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}
$_SESSION["message"]='* This camper is already registered for that date.';    

$page_title = 'Muskoka Discovery Center';
//require('header-staff.php'); 

try{
//form inputs in variables
$camper_id = $_POST['camper_id'];
$camper_reg_date = $_POST['camp_reg_date'];
 $camper_id2 = null;
 $camper_reg_date2 = null;

//Create a flag to track the completion status of the form
$ok = true;

        // connect to the db
        require('db.php');

        // query the tbl_campers_registration
        $sql = "SELECT * FROM tbl_campers_registration WHERE camper_id =:camper_id 
        AND camper_reg_date =:camper_reg_date";
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
        $cmd->bindParam(':camper_reg_date', $camper_reg_date, PDO::PARAM_STR);
        $cmd->execute();
        $result = $cmd->fetchAll();
        $count = $cmd->rowCount();
        foreach($result as $row) {
            $camper_id2 = $row['camper_id'];
            $camper_reg_date2 = $row['camper_reg_date'];           
        }        

        // check to see if user is already registered on same day
         if($camper_id2 == $camper_id && $camper_reg_date2 == $camper_reg_date ){
            echo "This camper is already registered for the date";
            header('location:error.php');
            $ok = false;
           } else {

            // retreive the campers info from db
            $sql_campers = "SELECT * FROM tbl_campers WHERE camper_id = :camper_id";
            $cmd = $conn->prepare($sql_campers);
            $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
            $cmd->execute();
            $campers = $cmd->fetchAll();
            $count = $cmd->rowCount();
            foreach($campers as $camper) {
                $camper_first_name = $camper['camper_first_name'];
                $camper_last_name = $camper['camper_last_name'];
                $camper_rate = $camper['camper_rate'];
            }

            // query the tbl_camp to get the camp_id from table
            $sql_camp = "SELECT * FROM tbl_camp WHERE camp_reg_date = :camper_reg_date";
            $cmd = $conn->prepare($sql_camp);
           $cmd->bindParam(':camper_reg_date', $camper_reg_date, PDO::PARAM_STR);
            $cmd->execute();
            $camps = $cmd->fetchAll();
            $count = $cmd->rowCount();
            foreach($camps as $camp) {
                $camp_id= $camp['camp_id'];
            }

            if($ok){	

            $sql = "INSERT INTO tbl_campers_registration
            (camper_id, camper_first_name, camper_last_name,camper_reg_date,camper_rate,camp_id)  
             VALUES 
            (:camper_id,:camper_first_name, :camper_last_name, :camper_reg_date,:camper_rate, :camp_id)";

        $cmd = $conn->prepare($sql);

        // put each input value into the proper field
        $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
        $cmd->bindParam(':camper_first_name', $camper_first_name, PDO::PARAM_STR);
        $cmd->bindParam(':camper_last_name', $camper_last_name, PDO::PARAM_STR);
		$cmd->bindParam(':camper_reg_date', $camper_reg_date, PDO::PARAM_STR);
        $cmd->bindParam(':camper_rate', $camper_rate, PDO::PARAM_INT);
        $cmd->bindParam(':camp_id', $camp_id, PDO::PARAM_INT);

         // execute the save
        $cmd->execute();
        // disconnect
        $conn = null;
            } // end of else

        header('location:registered-camper-list.php');

        }//end of $ok if
        }// close the error handler bracket
//catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
        
?>