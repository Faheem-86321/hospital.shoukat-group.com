<?php 
///////////////////////////// Insert Patient Record ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
	$service_id = $_POST['service_id'];
	$mrn = $_POST['mrn'];
	$doc_id = $_POST['doc_id'];
	$doc_ch = $_POST['doc_ch'];
	for ($i=0; $i < count($service_id) ; $i++) { 
		$service_id_u = $_POST['service_id'][$i];
		$sercost_u = $_POST['sercost'][$i];
		$insert_data = "INSERT INTO ssh_p_indoor (MRN,D_ID,S_ID,Paid,Date) VALUES ('".$mrn."','0','".$service_id_u."','".$sercost_u."','".Date('Y-m-d H:i:s')."')";
		$insert_data_ex = mysqli_query($con,$insert_data);
	} 
	$insert_data1 = "INSERT INTO ssh_p_indoor (MRN,D_ID,S_ID,Paid,Date) VALUES ('".$mrn."','".$doc_id."','0','".$doc_ch."','".Date('Y-m-d H:i:s')."')";
	$insert_data1_ex = mysqli_query($con,$insert_data1);
	if ($insert_data1_ex) { ?>
		<script type="text/javascript">
			window.open('print_slip_indoor.html.php?slip=<?php echo $mrn ?>', '_blank');
		</script>
 	<?php }
	header("Location: indoor");
}
///////////////////////////// Update Patient Record ///////////////////////
if (isset($_POST['psubmit_u'])) {
	date_default_timezone_set("Asia/Karachi");
	$doc_id_u = $_POST['doc_id_u'];
	$doc_ch_u = $_POST['doc_ch_u'];
	$mrn_f_up = $_POST['mrn_f_up'];
	$insert_data1 = "INSERT INTO ssh_p_indoor (MRN,D_ID,S_ID,Paid,Date) VALUES ('".$mrn_f_up."','".$doc_id_u."','0','".$doc_ch_u."','".Date('Y-m-d H:i:s')."')";
	$insert_data1_ex = mysqli_query($con,$insert_data1);
	if ($insert_data1_ex) {
		header("Location: indoor");
	}
}
///////////////////////////// Update Patient Record ///////////////////////
if (isset($_POST['psubmit_u_u'])) {
	date_default_timezone_set("Asia/Karachi");
	$service_id_u = $_POST['service_id_u'];
	$mrn_f_up = $_POST['mrn_f_up'];
	for ($i=0; $i < count($service_id_u) ; $i++) { 
		$service_id_u_u = $_POST['service_id_u'][$i];
		$sercost_u_u = $_POST['sercost_u'][$i];
		$insert_data = "INSERT INTO ssh_p_indoor (MRN,D_ID,S_ID,Paid,Date) VALUES ('".$mrn_f_up."','0','".$service_id_u_u."','".$sercost_u_u."','".Date('Y-m-d H:i:s')."')";
		$insert_data_ex = mysqli_query($con,$insert_data);
	} 
	?>
		<script type="text/javascript">
			window.open('print_slip_indoor.html.php?slip=<?php echo $mrn_f_up ?>', '_blank');
		</script>
 	<?php 
	header("Location: indoor");
}	

?>