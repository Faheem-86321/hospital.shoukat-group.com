<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['pupdate'])) {
	date_default_timezone_set("Asia/Karachi");
	$u_id = $_POST['id_update'];
	$data = $_POST['claim_no']."!@#$%^&*()".$_POST['cheq_date']."!@#$%^&*()".$_POST['voucher_no']."!@#$%^&*()".$_POST['cheq_no'];
	$update_data = " UPDATE ssh_p_indoor SET payment_details = '".$data."' where pi_id='".$u_id."'";
	$update_data_ex = mysqli_query($con,$update_data);
	header('location: files_card_recieved_payment');
}	
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['pupdate2'])) {
	date_default_timezone_set("Asia/Karachi");
	$u_id = $_POST['id_update'];
	$data = $_POST['claim_no']."!@#$%^&*()".$_POST['cheq_date']."!@#$%^&*()".$_POST['voucher_no']."!@#$%^&*()".$_POST['cheq_no'];
	$update_data = " UPDATE ssh_p_dialysis SET payment_details = '".$data."' where pd_id='".$u_id."'";
	$update_data_ex = mysqli_query($con,$update_data);
	header('location: files_card_recieved_payment');
}	
?>