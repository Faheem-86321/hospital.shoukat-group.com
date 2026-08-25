<?php 
///////////////////////////// Insert Patient Record ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
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
			$charges = isset($_POST['charges']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['charges']) : "";
			$paid = isset($_POST['paid']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['paid']) : "";
			$d_pay = isset($_POST['d_pay']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['d_pay']) : "";
			$insert_data = "INSERT INTO ssh_p_dpr(P_ID,D_ID,D_Pay,A_Date,Charges,Paid,Status,user_id) VALUES('".$pat_id."','".$doc_id."','".$d_pay."','".Date('Y-m-d H:i:s')."','".$charges."','".$paid."','0','".$_SESSION['user_id']."')";
				$insert_data_ex = mysqli_query($con,$insert_data);
				if ($insert_data_ex) {
					$last_id = $con->insert_id;?>
					<script type="text/javascript">
						window.open('print_slip.html.php?slip=<?php echo $last_id ?>', '_blank');
					</script>

				<?php }
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
					$d_pay = isset($_POST['d_pay']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['d_pay']) : "";
					$insert_data = "INSERT INTO ssh_p_dpr(P_ID,D_ID,D_Pay,A_Date,Charges,Paid,Status,user_id) VALUES('".$last_p_id."','".$doc_id."','".$d_pay."','".Date('Y-m-d H:i:s')."','".$charges."','".$paid."','0','".$_SESSION['user_id']."')";
						$insert_data_ex = mysqli_query($con,$insert_data);
						if ($insert_data_ex) {
							$last_id = $con->insert_id ;?>
							<script type="text/javascript">
								window.open('print_slip.html.php?slip=<?php echo $last_id ?>', '_blank');
							</script>

						<?php }
						else{
							echo "<div class='alter alter-danger'>Data does not exist!</div>";
						}
					}	
				}

			}

///////////////////////////// Insert Patient Record ///////////////////////
if (isset($_POST['priceupdate'])) {
	$p_r_id = isset($_POST['p_r_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['p_r_id']) : "";
	$paid_u = isset($_POST['paid_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['paid_u']) : "";
	if ($paid_u < 50) {
		$update_data = "UPDATE ssh_p_dpr SET Paid = '".$paid_u."',D_Pay = '0'  WHERE MRN='".$p_r_id."' ";
    $update_data_ex = mysqli_query($con,$update_data);
	}else{
		$update_data = "UPDATE ssh_p_dpr SET Paid = '".$paid_u."'  WHERE MRN='".$p_r_id."' ";
    $update_data_ex = mysqli_query($con,$update_data);
  }
    if ($update_data_ex) {
      header('location: outdoor');
   }else{
       echo 'false';
   }
}	
?>