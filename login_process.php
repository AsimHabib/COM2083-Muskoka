<?php
	session_start();
	require_once 'db.php';

	if(isset($_POST['btn-login']))
	{
		$user_email = trim($_POST['user_email']);
		$user_password = trim($_POST['password']);		
		//$password = md5($user_password);
		$password = hash('sha512', $user_password);
		
		try
		{	
		
			$sql = "SELECT * FROM tbl_staff WHERE staff_user_name=:email";

			$cmd = $conn->prepare($sql);
			$cmd->bindParam(':email', $user_email, PDO::PARAM_STR, 50);
			$cmd->execute();
			$row = $cmd->fetch(PDO::FETCH_ASSOC);			
			$count = $cmd->rowCount();
			
			if($row['staff_password']==$password){
				
				echo "ok"; // log in
				$_SESSION['user_session'] = $row['staff_id'];
			}
			else{
				
				echo "email or password does not exist."; // wrong details 
			}
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>