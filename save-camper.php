<?php
session_start();
if (!isset($_SESSION['user_session']))
{
    header("Location: index.php");
}
$_SESSION["message"] = '* This camper already exits with this profile.';
$page_title = 'Muskoka Discovery Center';
//require('header-staff.php');
try
{
    //form inputs in variables
    $camper_id = $_POST['camper_id'];
    $camper_first_name = $_POST['camper_first_name'];
    $camper_last_name = $_POST['camper_last_name'];
    //$camper_image = $_POST['camper_image'];
    $campers_notes = $_POST['campers_notes'];
    $camper_rate = $_POST['camper_rate'];
    //$camper_reg_date = $_POST['camp_reg_date'];
    $phone_number = $_POST['phone_number'];
    $parent_name = $_POST['parent_name'];
    $parent_email = $_POST['parent_email'];

    //Create a flag to track the completion status of the form
    $ok = true;

    /****************************************
    Image Upload Functionality
    ****************************************/
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    //if(isset($_POST["submit"])) {
 
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false)
    {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    }
    else
    {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    //}
    // Check if file already exists
    if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000)
    {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        echo "Sorry, your file was not uploaded.";
        
        
    }
    // if everything is ok, try to upload file
    else
    {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    /******************Image upload functionlity ends  ***********************/

    if ($ok)
    {
        // connect to the db
        require ('db.php');
        $sql = "SELECT * FROM tbl_campers WHERE parent_email =:parent_email";
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':parent_email', $parent_email, PDO::PARAM_STR);
        $cmd->execute();
        $emails = $cmd->fetchAll();
        foreach ($emails as $email)
        {
            $e_mail = $email['parent_email'];
        }

        if (empty($camper_id))
        {
            // check if camper already exits
            if ($parent_email == $e_mail)
            {
                echo "This camper is already has the profile.";
                header('location:error.php');
                $ok = false;
            }
            else
            {

                $sql = "INSERT INTO tbl_campers (camper_first_name, camper_last_name, camper_image, campers_notes, camper_rate,camper_reg_date, phone_number,parent_name,parent_email) VALUES (:camper_first_name, :camper_last_name, :camper_image, :campers_notes, :camper_rate,now(), :phone_number, :parent_name, :parent_email)";
            }
        }
        else
        {
            $sql = "UPDATE tbl_campers SET camper_first_name = :camper_first_name, camper_last_name = :camper_last_name, camper_image = :camper_image, campers_notes = :campers_notes, camper_rate = :camper_rate,  phone_number=:phone_number, parent_name=:parent_name , parent_email=:parent_email WHERE camper_id = :camper_id";

        }

        // create a command object
        $cmd = $conn->prepare($sql);

        // put each input value into the proper field
        $cmd->bindParam(':camper_first_name', $camper_first_name, PDO::PARAM_STR);
        $cmd->bindParam(':camper_last_name', $camper_last_name, PDO::PARAM_STR);
        $cmd->bindParam(':camper_image', $target_file, PDO::PARAM_STR);
        $cmd->bindParam(':campers_notes', $campers_notes, PDO::PARAM_STR);
        $cmd->bindParam(':camper_rate', $camper_rate, PDO::PARAM_INT);
        //$cmd->bindParam(':camper_reg_date', $camper_reg_date, PDO::PARAM_INT);
        $cmd->bindParam(':phone_number', $phone_number, PDO::PARAM_INT);
        $cmd->bindParam(':parent_name', $parent_name, PDO::PARAM_STR);
        $cmd->bindParam(':parent_email', $parent_email, PDO::PARAM_STR);

        // add the camper id if we have one for an update
        if (!empty($camper_id))
        {
            $cmd->bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
        }

        // execute the save
        $cmd->execute();

        // disconnect
        $conn = null;

        header('location:camper-profile.php');
    } // ok
    
} // close the error handler bracket
//catch exception
catch(Exception $e)
{
    echo 'Message: ' . $e->getMessage();
}
?>
