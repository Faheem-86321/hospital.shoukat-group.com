<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");

	$service_id = isset($_POST['service_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['service_id']) : "";
	$charges = isset($_POST['charges']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['charges']) : "";
	$discount = isset($_POST['discount']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['discount']) : "";

	$fetch_data = "SELECT * FROM ssh_ser_cat JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.Id
	WHERE ssh_ser_cat.C_ID='".$service_id."' ";
	$fetch_data_ex = mysqli_query($con,$fetch_data);
	foreach($fetch_data_ex as $row){ 
		$pr_id = $row['ID'];
		$ser_count = $row['Stock'] - $row['sets'] ;
	}
	$update_data_12 = " UPDATE ssh_ser_inv SET Stock ='".$ser_count."' where ID='".$pr_id."'";
	$update_data_12_ex = mysqli_query($con,$update_data_12);


	$pat_id = $_POST['pat_id'];
	if (!empty($pat_id)){
		$pat_id = isset($_POST['pat_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_id']) : "";
		$doc_id = isset($_POST['doc_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_id']) : "";
		$pat_Name_update = isset($_POST['pat_Name_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Name_update']) : "";
		
		$pat_Age_update = isset($_POST['pat_Age_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Age_update']) : "";
		$pat_Phone_update = isset($_POST['pat_Phone_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Phone_update']) : "";
		$pat_gender_update = isset($_POST['pat_gender_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_gender_update']) : "";
		$update_data = "UPDATE ssh_p_reg SET Name='".$pat_Name_update."', Age='".$pat_Age_update."', Phone='".$pat_Phone_update."', Gender='".$pat_gender_update."' Where P_ID = '".$pat_id."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			$insert_data = "INSERT INTO ssh_p_services (P_ID,C_ID,Paid,Discount,Date,user_id) VALUES ('".$pat_id."','".$service_id."','".$charges."','".$discount."','".date('Y-m-d H:i:s')."','".$_SESSION['user_id']."')";
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
	}else{
		$doc_id = isset($_POST['doc_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_id']) : "";
		$pat_Name = isset($_POST['pat_Name']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Name']) : "";
		$pat_Age = isset($_POST['pat_Age']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Age']) : "";
		$pat_Phone = isset($_POST['pat_Phone']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_Phone']) : "";
		$pat_gender = isset($_POST['pat_gender']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['pat_gender']) : "";
		$insert1_data = "INSERT INTO ssh_p_reg(Name,Age,Phone,Gender) VALUES ('".$pat_Name."','".$pat_Age."','".$pat_Phone."','".$pat_gender."')";
			$insert1_data_ex = mysqli_query($con,$insert1_data);
			if ($insert1_data_ex) {
				$last_p_id = $con->insert_id;
				$charges = isset($_POST['charges']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['charges']) : "";
				$paid = isset($_POST['paid']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['paid']) : "";
				$insert_data = "INSERT INTO ssh_p_services (P_ID,C_ID,Paid,Discount,Date,user_id) VALUES ('".$last_p_id."','".$service_id."','".$charges."','".$discount."','".date('Y-m-d H:i:s')."','".$_SESSION['user_id']."')";
					$insert_data_ex = mysqli_query($con,$insert_data);
					if ($insert_data_ex) {
						$last_id = $con->insert_id ;?>
						<script type="text/javascript">
							window.open('service_slip.html.php?slip=<?php echo $last_id ?>', '_blank');
						</script>

					<?php }
					else{
						echo "<div class='alter alter-danger'>Data does not exist!</div>";
					}
				}	
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