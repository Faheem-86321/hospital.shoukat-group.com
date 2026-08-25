<?php
///////////////////////////// Update Service ///////////////////////
if (isset($_POST['pupdate'])) {
	date_default_timezone_set("Asia/Karachi");
	$available_sheet = isset($_POST['available_sheet']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['available_sheet']) : "";
	$ser_id_update = isset($_POST['ser_id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update']) : "";
	
	$expense_x = isset($_POST['expense_x']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['expense_x']) : "";
	$insert_data_exp = "INSERT INTO ssh_expenses (services,Title,Amount,Date,user_id) VALUES ('1','X-Rays Product','".$expense_x."','".date('Y-m-d')."','".$_SESSION['user_id']."')";
	$insert_data_exp_ex = mysqli_query($con,$insert_data_exp);
	$update_data = " UPDATE ssh_ser_inv SET Stock='".$available_sheet."',last_date='".date('Y-m-d')."' where ID='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: outdoor_dashboard');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
	///////////////////////////// Update Service ///////////////////////
if (isset($_POST['ct_pupdate'])) {
	date_default_timezone_set("Asia/Karachi");
	$available_sheet = isset($_POST['available_sheet_ct']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['available_sheet_ct']) : "";
	$ser_id_update = isset($_POST['ser_id_update_ct']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update_ct']) : "";
	$expense_ct = isset($_POST['expense_ct']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['expense_ct']) : "";
	$insert_data_exp = "INSERT INTO ssh_expenses (services,Title,Amount,Date,user_id) VALUES ('2','Ct-Scan Product','".$expense_ct."','".date('Y-m-d')."','".$_SESSION['user_id']."')";
	$insert_data_exp_ex = mysqli_query($con,$insert_data_exp);
	

	$update_data = " UPDATE ssh_ser_inv SET Stock='".$available_sheet."',last_date='".date('Y-m-d')."' where ID='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: outdoor_dashboard');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>