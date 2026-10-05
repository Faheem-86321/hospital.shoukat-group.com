<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	$ser_title = isset($_POST['ser_title']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_title']) : "";
	$ser_price = isset($_POST['ser_price']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_price']) : "";
	$ser_sheets = isset($_POST['ser_sheets']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_sheets']) : "";
	$ser_type = isset($_POST['ser_type']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_type']) : "";
	

	$insert_data = "INSERT INTO ssh_ser_cat (Name,sets,charges,ser_id) VALUES ('".$ser_title."','".$ser_sheets."','".$ser_price."','".$ser_type."')";
		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			header('location: other_services_types');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
///////////////////////////// Update Service ///////////////////////
if (isset($_POST['pupdate'])) {
	$ser_title_u = isset($_POST['ser_title_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_title_u']) : "";
	$ser_price_u = isset($_POST['ser_price_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_price_u']) : "";
	$ser_sheets_u = isset($_POST['ser_sheets_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_sheets_u']) : "";
	$ser_id_update = isset($_POST['ser_id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update']) : "";
	

	$update_data = " UPDATE ssh_ser_cat SET Name='".$ser_title_u."', sets='".$ser_sheets_u."', charges='".$ser_price_u."' where C_ID='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: other_services_types');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>