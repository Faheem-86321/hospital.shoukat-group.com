<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	$case_id = isset($_POST['case_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['case_id']) : "";
	$doc_id = isset($_POST['doc_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_id']) : "";
	$doc_charges = isset($_POST['doc_charges']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_charges']) : "";
	

	$insert_data = "INSERT INTO `ssh_docsetting_indoor`(`S_ID`, `D_ID`, `doc_charges`, `close`) VALUES ('".$case_id."','".$doc_id."','".$doc_charges."','1')";
		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			header('location: doctor_fee');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
///////////////////////////// Update Service ///////////////////////
if (isset($_POST['pupdate'])) {
	$ser_title_u = isset($_POST['ser_title_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_title_u']) : "";
	$ser_charges_u = isset($_POST['ser_charges_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_charges_u']) : "";
	$ser_id_update = isset($_POST['ser_id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update']) : "";
	

	$update_data = "UPDATE ssh_services_indoor SET Title='".$ser_title_u."', Charges='".$ser_charges_u."' WHERE S_ID='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: indoor_services');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>