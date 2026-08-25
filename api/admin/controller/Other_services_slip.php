<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
	$pat_id = isset($_POST['pat_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_id']) : "";
	$service_id = isset($_POST['service_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['service_id']) : "";
	$charges = isset($_POST['charges']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['charges']) : "";
	$insert_data = "INSERT INTO ssh_p_services (MRN,C_ID,Paid,Date) VALUES ('".$pat_id."','".$service_id."','".$charges."','".date('Y-m-d H:i:s')."')";
		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			$last_id = $con->insert_id;?>
			<script type="text/javascript">
				window.open('service_slip.html.php?slip=<?php echo $last_id ?>', '_blank');
			</script>
			<?php
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
///////////////////////////// Update Service ///////////////////////
	if (isset($_POST['pupdate'])) {
		$ser_name_u = isset($_POST['ser_name_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_name_u']) : "";
		$room_name_u = isset($_POST['room_name_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['room_name_u']) : "";
		$fees_u = isset($_POST['fees_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['fees_u']) : "";
		$ser_id_update = isset($_POST['ser_id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update']) : "";


		$update_data = " UPDATE ssh_services SET S_name='".$ser_name_u."', Room='".$room_name_u."', Fees='".$fees_u."' where S_ID='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: services');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>