<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	$ser_title = isset($_POST['ser_title']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_title']) : "";
	$ser_charges = isset($_POST['ser_charges']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_charges']) : "";
	

	$insert_data = "INSERT INTO ssh_cases_indoor (Title, Charges, close) VALUES ('".$ser_title."','".$ser_charges."','1')";
		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			header('location: cases_list');
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
	

	$update_data = "UPDATE ssh_cases_indoor SET Title='".$ser_title_u."', Charges='".$ser_charges_u."' WHERE S_ID='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: cases_list');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>