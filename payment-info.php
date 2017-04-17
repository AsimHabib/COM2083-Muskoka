<?php
session_start();
if(!isset($_SESSION['user_session']))
{
header("Location: index.php");
}
$page_title = 'Muskoka Discovery Center';
$selected = "staff";
$current_id = ' id="current"';
require('header-staff.php'); 
$camper_id = null;
$t_amount = null;
$t_days = null;
$rate = null;
$payment = null;
$amount_paid = null;
$amount_aowing = null;
$camper_first_name = null;
$camper_last_name = null;

if((!empty($_GET['camper_id'])) && (is_numeric($_GET['camper_id']))) {
	$camper_id = $_GET['camper_id'];
}
// connect to the db
require('db.php');
$sql_count = "SELECT COUNT(*),camper_first_name, camper_last_name,camper_rate FROM tbl_campers_registration GROUP BY camper_id HAVING camper_id = :camper_id";
$cmd = $conn -> prepare($sql_count);
$cmd -> bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
$cmd->execute();
$campers = $cmd -> fetchAll();
foreach ($campers as $camper){
	$camper_first_name = $camper['camper_first_name'];
	$camper_last_name = $camper['camper_last_name'];
	$t_days = $camper['COUNT(*)'];	
	$rate = $camper['camper_rate'];	
}
?>
<div class="container-fluid">
  <div class="row light-blue">
    <div class="col-md-2 col-sm-3">
    </div>
    <div class="col-md-10 col-sm-9">
      <div class="row">
        <div class="col-md-4 col-sm-4">
          <h1>Payment </h1>
        </div>
        <div class="col-md-8 col-sm-8">
        </div>
      </div>
    </div>
  </div>
  <div class="row white-bg content">
    <div class="col-md-2 col-sm-3"> 
    </div>
    <div class="col-md-10 col-sm-9">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-5">
          <?php echo '<h2>' . $camper_first_name  . '  ' .$camper_last_name . '</h2>'; ?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-7 button"> 
          <a href="#pay_now" data-toggle="modal">
            <i class="fa fa-usd" aria-hidden="true"></i> Make a Payment
          </a> 
        </div>
        <div id="pay_now" class="modal fade" role="dialog">
          <div class="modal-dialog"> 
            <!-- Modal content-->
            <div class="modal-content staff">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Make a Payment</h4>
              </div>
              <div class="modal-body">
                <form class="form-signin" id="add-camp-date-form" method="post" action="save-payment.php">
                  <input type="hidden" name="camper_id" id="camper_id" value="<?php echo $camper_id ?>">
                  <div class="form-group">
                    <label for="payment_date" class="col-md-3 col-form-label">Date </label>						
                    <input type="date" placeholder="date" id="payment_date" name="payment_date" >
					<span id="check-e"></span>
                  </div>
                  <div class="form-group">
                    <label for="amount_paid" class="col-md-3 col-form-label">Amount  </label>						
                    <input type="number" placeholder="$" id="amount_paid" name="amount_paid" >
                    <span id="check-e"></span>
                  </div>
                  <div class="form-group ">
                    <label for="payment_type" class="col-md-3 col-form-label">Payment Type</label>
                    <select  class="form-control" name="payment_type" id="payment_type">
                      <option value="Credit Card">Credit Card </option>
                      <option value="Debit Card">Debit Card </option>
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque </option>
                    </select>
                  </div>
                  <div class="modal-footer form-group">	
				  <div class="col-xs-6">		                    
                    <button type="submit" class="btn btn-primary">Save</button>
					</div>
					<div class="col-xs-6">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 profile border">
          <div class="row">
            <div class="col-md-12 rates">
              <table class="table table-bordered table-striped table-responsive pm-table">
                <thead>
                  <tr>
                    <th>Campers</th>
                    <th>Rate </th>
                    <th>Current Total Of Days Attended </th>
                  </tr>
                </thead>
                <tbody>
                  <?php	
//store each value from the database into a variable
foreach ($campers as $camper){
	echo '<tr>';
	echo '<td>' . $camper['camper_last_name'] . ' , ' . $camper['camper_first_name'] . '</td>';
	echo '<td>'. '$'. $camper['camper_rate'] . '</td>';
	echo '<td>' . $camper['COUNT(*)'] . '</td>';
	echo '</tr>';
}
//disconnect
$conn = null;
?>
                </tbody>
              </table>
            </div>						
          </div>
        </div>
      </div>
      <!-- PAYMENT RECORD STARTS -->
      <div class="row">
        <div class="col-md-12">
          <h3>Payment Record </h3>
          <table class="table table-bordered table-striped table-responsive pm-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Amount Paid </th>
                <th>Payment Type</th>
              </tr>
            </thead>
            <tbody>
              <?php
require('db.php');
$sql = "SELECT * FROM tbl_payment WHERE camper_id = :camper_id";
$cmd = $conn -> prepare($sql);
$cmd -> bindParam(':camper_id', $camper_id, PDO::PARAM_INT);
$cmd->execute();
$payments = $cmd -> fetchAll();						
foreach ($payments as $payment){
	$amount_paid += $payment['payment_amount_paid'];
	echo '<tr><td>' .date("F dS, Y",  strtotime($payment['payment_date'])) . '</td>';
	echo '<td>$' . $payment['payment_amount_paid'] . '</td>';
	echo '<td>' . $payment['payment_type'] . '</td></tr>';
}		
$conn = null;						
?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- PAYMENT RECORD ENDS -->
      <!-- Amout Owing -->
      <div class="row">
        <div class="col-md-12">
          <?php 
// total rate for registered numer of days	
// $amount_paid = $payment['payment_amount_paid'];
$t_amount = $t_days * $rate;
$amount_aowing = $t_amount - $amount_paid;
if($amount_paid != 0 || !empty($amount_paid)){	
	echo '<div class="rates">		
	<h4>AMOUNT OWING TO DATE: <span>$'. $t_amount.'</span></h4>
	<h4>AMOUNT PAID: <span>$'. $amount_paid.'</span></h4>
	<h4>BALANCE: <span>$'. $amount_aowing.'</span></h4>
	</div>';
} else {
	echo '<div class="rates">		
	<h4>AMOUNT OWING TO DATE: <span>$00</span></h4>
	<h4>AMOUNT PAID: <span>$00</span></h4>
	<h4>BALANCE: <span>$00</span></h4>
	</div>';
}
?>
        </div>
      </div>
    </div>
    <?php
require('footer.php'); 
?>
