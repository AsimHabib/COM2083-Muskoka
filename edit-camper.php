<?php ob_start();
		//store the form inputs in variables
		$name = $_POST['name'];
		$alchol_content = $_POST['alchol_content'];
		$domestic = $_POST['domestic'];
		$light = $_POST['light'];
		$price = $_POST['price'];
		$beer_id = $_POST['beer_id'];
		
		
		//Display the name
		echo $name . '<br/>';
		echo $alchol_content . '<br/>';
		echo $domestic . '<br/>';
		echo $light . '<br/>';
		echo $price . '<br/>';
		
		
		//connect to the db
		$conn = new PDO('mysql:host=sql.computerstudi.es;dbname=gc200322556','gc200322556', '-eDuY9YB');
	
	
		//setup the SQL command to save the data
		if (empty($beer_id)){
		$sql = "INSERT INTO beers (name, alchol_content, domestic, light, price) 
				VALUES (:name, :alchol_content, :domestic, :light, :price)";
		}
		else {
		$sql = "UPDATE beers SET name = :name, alchol_content = :alchol_content, domestic = :domestic, light = :light, price = :price WHERE beer_id = :beer_id"; 
				
		}
	
		//create command object
		$cmd = $conn->prepare($sql);
		
		
		//put each input value into the proper field
		$cmd -> bindParam(':name', $name, PDO::PARAM_STR);
		$cmd -> bindParam(':alchol_content', $alchol_content, PDO::PARAM_INT);
		$cmd -> bindParam(':domestic', $domestic, PDO::PARAM_BOOL);
		$cmd -> bindParam(':light', $light, PDO::PARAM_BOOL);
		$cmd -> bindParam(':price', $price, PDO::PARAM_INT);
		
		// add the beer id if we have one for an update
		if (!empty ($beer_id)){
			$cmd -> bindParam(':beer_id', $beer_id, PDO::PARAM_INT);
			}
		
		
		//execute the save
		$cmd -> execute();
		
		//disconnect
		$conn = null;
		
		//echo 'beer saved';
		
		//redirect back to the updated page
		header('location:beers-table.php');
		
ob_flush();
?>
