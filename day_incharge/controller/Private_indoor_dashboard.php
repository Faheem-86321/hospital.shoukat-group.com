<?php

	///////////////////////////// Update Service ///////////////////////
if (isset($_POST['d_pupdate'])) {
	date_default_timezone_set("Asia/Karachi");
	$available_sheet = isset($_POST['available_sheet_d']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['available_sheet_d']) : "";
	$ser_id_update = isset($_POST['ser_id_update_d']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update_d']) : "";
	

	$update_data = " UPDATE dialysis_item SET stock='".$available_sheet."',last_update='".date('Y-m-d')."' where di_id='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: private_indoor_dashboard');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>