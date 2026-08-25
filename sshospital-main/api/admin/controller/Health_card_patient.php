<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
	$pat_id = $_POST['pat_id'];
	if (!empty($pat_id)){
		$pat_id = isset($_POST['pat_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_id']) : "";
		$pat_Name_update = isset($_POST['pat_Name_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Name_update']) : "";
		
		$pat_Age_update = isset($_POST['pat_Age_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Age_update']) : "";
		$pat_Phone_update = isset($_POST['pat_Phone_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Phone_update']) : "";
		$pat_gender_update = isset($_POST['pat_gender_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_gender_update']) : "";

		$update_data = "UPDATE ssh_p_reg SET Name='".$pat_Name_update."', Age='".$pat_Age_update."', Phone='".$pat_Phone_update."', Gender='".$pat_gender_update."' Where P_ID = '".$pat_id."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
				$visitor_id = isset($_POST['visitor_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['visitor_id']) : "";
				$case_id = isset($_POST['case_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['case_id']) : "";
				$Paid = isset($_POST['Paid']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['Paid']) : "";
				$room_id = isset($_POST['room_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['room_id']) : "";

				$insert_data = "INSERT INTO `ssh_p_indoor`(`visitor_id`, `P_ID`, `S_ID`, `Paid`, `admit_date`, `admition_type`, `room_id`, `close`) VALUES ('".$visitor_id."','".$pat_id."','".$case_id."','".$Paid."','".date('Y-m-d')."','1','".$room_id."','1')";
				$insert_data_ex = mysqli_query($con,$insert_data);
				if ($insert_data_ex) {
					$last_id = $con->insert_id;
					$doc_id = $_POST['doc_id'];
					for ($i=0; $i < count($doc_id) ; $i++) { 
						$doc_id_u = $_POST['doc_id'][$i];
						$doctor_payment = $_POST['doctor_payment'][$i];
						$insert_data_doc = "INSERT INTO `ssh_p_indoor_doctors`(`pi_id`, `D_ID`, `D_Fee`) VALUES ('".$last_id."','".$doc_id_u."','".$doctor_payment."')";
						$insert_data_doc_ex = mysqli_query($con,$insert_data_doc);
					}
					 ?>
					<script type="text/javascript">
						window.open('print_slip_indoor.html.php?slip=<?php echo $last_id ?>', '_blank');
					</script>
					<?php
				}
				else{
					echo "<div class='alter alter-danger'>Data does not exist!</div>";
				}
		}		
	}else{
		$pat_Name = isset($_POST['pat_Name']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Name']) : "";
		$pat_Age = isset($_POST['pat_Age']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Age']) : "";
		$pat_Phone = isset($_POST['pat_Phone']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Phone']) : "";
		$pat_gender = isset($_POST['pat_gender']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_gender']) : "";
		$insert1_data = "INSERT INTO ssh_p_reg(Name,Age,Phone,Gender) VALUES ('".$pat_Name."','".$pat_Age."','".$pat_Phone."','".$pat_gender."')";
			$insert1_data_ex = mysqli_query($con,$insert1_data);
			if ($insert1_data_ex) {
				$last_p_id = $con->insert_id;
				$visitor_id = isset($_POST['visitor_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['visitor_id']) : "";
				$case_id = isset($_POST['case_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['case_id']) : "";
				$Paid = isset($_POST['Paid']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['Paid']) : "";
				$room_id = isset($_POST['room_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['room_id']) : "";

				$insert_data = "INSERT INTO `ssh_p_indoor`(`visitor_id`, `P_ID`, `S_ID`, `Paid`, `admit_date`, `admition_type`, `room_id`, `close`) VALUES ('".$visitor_id."','".$last_p_id."','".$case_id."','".$Paid."','".date('Y-m-d')."','1','".$room_id."','1')";
				$insert_data_ex = mysqli_query($con,$insert_data);
					if ($insert_data_ex) {
						$last_id = $con->insert_id;
					$doc_id = $_POST['doc_id'];
					for ($i=0; $i < count($doc_id) ; $i++) { 
						$doc_id_u = $_POST['doc_id'][$i];
						$doctor_payment = $_POST['doctor_payment'][$i];
						$insert_data_doc = "INSERT INTO `ssh_p_indoor_doctors`(`pi_id`, `D_ID`, `D_Fee`) VALUES ('".$last_id."','".$doc_id_u."','".$doctor_payment."')";
						$insert_data_doc_ex = mysqli_query($con,$insert_data_doc);
					}?>
					<script type="text/javascript">
						window.open('print_slip_indoor.html.php?slip=<?php echo $last_id ?>', '_blank');
					</script>
					<?php }
					else{
						echo "<div class='alter alter-danger'>Data does not exist!</div>";
					}
				}	
			}
}

if (isset($_POST['updateindoor'])) {
	date_default_timezone_set("Asia/Karachi");
	$update_admit_id = $_POST['update_admit_id'];
	$case_id_u = isset($_POST['case_id_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['case_id_u']) : "";
	$Paid_u = isset($_POST['Paid_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['Paid_u']) : "";
	
	$insert_data = "UPDATE `ssh_p_indoor` SET `S_ID`='".$case_id_u."',`Paid`='".$Paid_u."' WHERE pi_id = '".$update_admit_id."' ";
	$insert_data_ex = mysqli_query($con,$insert_data);
	if ($insert_data_ex) {
		$del_data = "DELETE FROM `ssh_p_indoor_doctors` WHERE pi_id = '".$update_admit_id."' ";
		$del_data_ex = mysqli_query($con,$del_data);
		$doc_id = $_POST['doc_id'];
		for ($i=0; $i < count($doc_id) ; $i++) { 
			$doc_id_u = $_POST['doc_id'][$i];
			$doctor_payment = $_POST['doctor_payment'][$i];
			$insert_data_doc = "INSERT INTO `ssh_p_indoor_doctors`(`pi_id`, `D_ID`, `D_Fee`) VALUES ('".$update_admit_id."','".$doc_id_u."','".$doctor_payment."')";
			$insert_data_doc_ex = mysqli_query($con,$insert_data_doc);
		} 
	}else{
		echo "<div class='alter alter-danger'>Data does not exist!</div>";
	}
				
	
}
?>