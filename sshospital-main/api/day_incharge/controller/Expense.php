<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
	$ex_title = isset($_POST['ex_title']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ex_title']) : "";
	$ex_price = isset($_POST['ex_price']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ex_price']) : "";
	$ex_date = isset($_POST['ex_date']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ex_date']) : "";
	
	

	$insert_data = "INSERT INTO ssh_expenses (Title,Amount,Date,user_id) VALUES ('".$ex_title."','".$ex_price."','".$ex_date."','".$_SESSION['user_id']."')";
		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			header('location: expense');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
///////////////////////////// Update Service ///////////////////////
if (isset($_POST['pupdate'])) {
	$ex_title_u = isset($_POST['ex_title_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ex_title_u']) : "";
	$ex_price_u = isset($_POST['ex_price_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ex_price_u']) : "";
	$ex_date_u = isset($_POST['ex_date_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ex_date_u']) : "";
	$ser_id_update = isset($_POST['ser_id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update']) : "";
	

	$update_data = " UPDATE ssh_expenses SET Title='".$ex_title_u."', Amount='".$ex_price_u."', Date='".$ex_date_u."' where Voucher='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: expense');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>