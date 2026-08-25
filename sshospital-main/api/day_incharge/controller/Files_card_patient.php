<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
	$sent_id = $_POST['sent_id'];
	for ($i=0; $i < count($sent_id); $i++) { 
		$sent_id_u = $_POST['sent_id'][$i];
		$checkop = $_POST['checkedvalue'.$i];
		if($checkop == 1){
			$update_data = " UPDATE ssh_p_indoor SET file_status = '1',file_date = '".date('Y-m-d')."' where pi_id='".$sent_id_u."'";
			$update_data_ex = mysqli_query($con,$update_data);
		}
	}
	header('location: files_card_patient');
}	
?>
<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit_d'])) {
	date_default_timezone_set("Asia/Karachi");
	$sent_id = $_POST['sent_id'];
	for ($i=0; $i < count($sent_id); $i++) { 
		$sent_id_u = $_POST['sent_id'][$i];
		$checkop = $_POST['checkedvalue'.$i];
		if($checkop == 1){
			$update_data = " UPDATE ssh_p_dialysis SET file_status = '1',file_date = '".date('Y-m-d')."' where pd_id='".$sent_id_u."'";
			$update_data_ex = mysqli_query($con,$update_data);
		}
	}
	header('location: files_card_patient');
}	
?>