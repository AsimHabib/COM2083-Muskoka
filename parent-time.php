<?php ob_start();

session_start();
if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
} 
    $camper_id = $_POST['camper_id'];
    $signin_time = $_POST['signin_time'];
    $signout_time = $_POST['signout_time'];
    $parent_signin_name = $_POST['parent_signin_name'];
    $parent_signout_name = $_POST['parent_signout_name']; 
     $camper_first_name = $_POST['camper_first_name'];
     $camper_last_name = $_POST['camper_last_name'];
    $parent_signin_name2 = null;
     $parent_signout_name2 = null;
     $signin_status = null;
     $signout_status = null;

try{

        // connect to the db
        require('db.php');
         $sql = "SELECT * FROM tbl_parents WHERE parent_signin_time =:signin_time 
         AND camper_id =:camper_id ";

         // create a command object
        $cmd = $conn->prepare($sql);
       
        // put each input value into the proper field
        $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
        $cmd->bindParam(':signin_time', $signin_time, PDO::PARAM_STR);
       
        // execute the save
        $cmd->execute();
        $result= $cmd->fetchAll();
        foreach($result as $row){
            $parent_signin_time2 = $row['parent_signin_time'];
             $parent_signout_time2 = $row['parent_signout_time'];
            $parent_signin_name2 = $row['parent_signin_name'];
            $parent_signout_name2 = $row['parent_signout_name'];
            $camper_id2 = $row['camper_id'];
            $signin_status = $row['signin_status'];
            $signout_status = $row['signout_status'];
        }
        
     
        if ($signin_status == 0){
            $sql_insert = "INSERT INTO tbl_parents (camper_first_name,camper_last_name,parent_signin_name,parent_signin_time,camper_id,signin_status)
                VALUES (:camper_first_name,:camper_last_name,:parent_signin_name,now(),:camper_id,1)";                 
                $cmd = $conn->prepare($sql_insert);  
                $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
                $cmd->bindParam(':parent_signin_name', $parent_signin_name, PDO::PARAM_STR);
                $cmd->bindParam(':camper_first_name', $camper_first_name, PDO::PARAM_STR);
                $cmd->bindParam(':camper_last_name', $camper_last_name, PDO::PARAM_STR);
                 $cmd->execute();                 
            
        } 
        else if($signout_status == 0){
            
            if(empty($parent_signout_name)){
                echo 'please enter the signout name';
            } else {
              $sql_update ="UPDATE tbl_parents SET parent_signout_name=:parent_signout_name, parent_signout_time =now() , signout_status =1
             WHERE parent_signin_time =:parent_signin_time AND camper_id =:camper_id";

            $cmd = $conn->prepare($sql_update);
            $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
             $cmd->bindParam(':parent_signin_time', $signin_time, PDO::PARAM_STR);
             $cmd->bindParam(':parent_signout_name', $parent_signout_name, PDO::PARAM_STR);
             $cmd->execute();
        }
        }
        
          /* else {
           if(($signin_status != 0) && !empty($parent_signin_time2) && $camper_id == $camper_id2){
                echo 'already signed in';
                
            }
            else if(($signout_status != 0) && empty($parent_signout_time2) && $camper_id == $camper_id2){
                echo 'already signed out';
                }

            }*/

            
               /* else{
                    echo 'ok';
                }*/
        // disconnect
        $conn = null;

        header('location:registered-camper-list.php');
}// end of try
//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}
ob_flush(); 
?>