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
				
				$Paid = isset($_POST['Paid']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['Paid']) : "";
				$injection = isset($_POST['injection']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['injection']) : "";
				if ($injection == 1) {
					$fetch_data = "SELECT * FROM dialysis_item ";
					$fetch_data_ex = mysqli_query($con,$fetch_data);
					foreach($fetch_data_ex as $row){ 
						$pr_id = $row['di_id'];
						$ser_count = $row['stock'] - 1;
						$update_data_12 = " UPDATE dialysis_item SET stock ='".$ser_count."' where di_id='".$pr_id."'";
						$update_data_12_ex = mysqli_query($con,$update_data_12);
					}
					
				}else{
					$fetch_data = "SELECT * FROM dialysis_item where di_id != 5 ";
					$fetch_data_ex = mysqli_query($con,$fetch_data);
					foreach($fetch_data_ex as $row){ 
						$pr_id = $row['di_id'];
						$ser_count = $row['stock'] - 1;
						$update_data_12 = " UPDATE dialysis_item SET stock ='".$ser_count."' where di_id='".$pr_id."'";
						$update_data_12_ex = mysqli_query($con,$update_data_12);
					}
				}

				$insert_data = "INSERT INTO `ssh_p_dialysis`(`visitor_id`,`injection`, `P_ID`,`Paid`, `date`, `admission_type`) VALUES ('".$visitor_id."','".$injection."','".$pat_id."','".$Paid."','".date('Y-m-d')."','0')";
				$insert_data_ex = mysqli_query($con,$insert_data);
				if ($insert_data_ex) {
					$last_id = $con->insert_id;
					 ?>
					<script type="text/javascript">
						window.open('print_slip_dialysis.html.php?slip=<?php echo $last_id ?>', '_blank');
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
				
				$Paid = isset($_POST['Paid']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['Paid']) : "";
				$injection = isset($_POST['injection']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['injection']) : "";
				if ($injection == 1) {
					$fetch_data = "SELECT * FROM dialysis_item ";
					$fetch_data_ex = mysqli_query($con,$fetch_data);
					foreach($fetch_data_ex as $row){ 
						$pr_id = $row['di_id'];
						$ser_count = $row['stock'] - 1;
						$update_data_12 = " UPDATE dialysis_item SET stock ='".$ser_count."' where di_id='".$pr_id."'";
						$update_data_12_ex = mysqli_query($con,$update_data_12);
					}
					
				}else{
					$fetch_data = "SELECT * FROM dialysis_item where di_id != 5 ";
					$fetch_data_ex = mysqli_query($con,$fetch_data);
					foreach($fetch_data_ex as $row){ 
						$pr_id = $row['di_id'];
						$ser_count = $row['stock'] - 1;
						$update_data_12 = " UPDATE dialysis_item SET stock ='".$ser_count."' where di_id='".$pr_id."'";
						$update_data_12_ex = mysqli_query($con,$update_data_12);
					}
				}

				$insert_data = "INSERT INTO `ssh_p_dialysis`(`visitor_id`,`injection`, `P_ID`,`Paid`, `date`, `admission_type`) VALUES ('".$visitor_id."','".$injection."','".$last_p_id."','".$Paid."','".date('Y-m-d')."','0')";
				$insert_data_ex = mysqli_query($con,$insert_data);
				if ($insert_data_ex) {
					$last_id = $con->insert_id;
					 ?>
					<script type="text/javascript">
						window.open('print_slip_dialysis.html.php?slip=<?php echo $last_id ?>', '_blank');
					</script>
					<?php
				}
					else{
						echo "<div class='alter alter-danger'>Data does not exist!</div>";
					}
				}	
			}
}

?>