<?php 
session_start();
if(!isset($_SESSION['user_session']))
	{
		header("Location: index.php");
	}

$page_title = 'Muskoka Discovery Center';
$selected = "manage-staff";
$current_id = ' id="current"';
require('header-staff.php');

try {
	// initialize variables
	$payment_date = null;
	$amount_paid = null;
	$payment_type = null;

	// store the form inputs in variables
	//if we do, store in a variable
	$camper_id = $_GET['camper_id'];
	$payment_date = $_POST['payment_date'];
	$amount_paid = $_POST['amount_paid'];
	$payment_type = $_POST['payment_type'];

	// validate inputs individually
	$ok = true;

	if (empty($payment_date)) {
		echo "Payment date is required<br />";
		$ok = false;
	}
	if ((empty($amount_paid)) || (!is_numeric($amount_paid)) || ($amount_paid < 0)) {
		echo "Payment Amount is required and must be greater than 0<br />";
		$ok = false;		
	}
	if (empty($payment_type)) {
		echo "Payment type is required<br />";
		$ok = false;
	}

	// check if the form is ok to save or not
	if ($ok == true) {
		// connect
		require('db.php');
		// set up SQL command to save the data
		if (!empty($camper_id)) {
			$sql = "INSERT INTO tbl_payment (payment_date, payment_amount_paid, payment_type)
			VALUES (:payment_date, :amount_paid, :payment_type)";
		} /*else {
			$sql = "UPDATE tbl_payment SET payment_date = :payment_date, 
			payment_amount_paid = :payme(nt_amount_paid, payment_type = :payment_type
			WHERE payment_id = :payment_id";
		}*/

		// create a command object
		$cmd = $conn->prepare($sql);

		$cmd->bindParam(':payment_date', $payment_date, PDO::PARAM_STR);
		$cmd->bindParam(':amount_paid', $amount_paid, PDO::PARAM_INT);
		$cmd->bindParam(':payment_type', $payment_type, PDO::PARAM_STR);

		// add the payment id if we have one for update
		/*if (!empty($payment_id)) {
			$cmd->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
		}*/

		// execute
		$cmd->execute();

		// disconnect
		$conn = null;

		// redirect
		header('payment-info.php');
	}

}

catch (Exception $e) {
    header('location:error.php');
}

?>


<?php
require_once('footer.php'); 
?>