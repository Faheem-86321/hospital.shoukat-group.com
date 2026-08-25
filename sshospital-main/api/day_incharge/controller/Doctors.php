<?php 
///////////////////////////// Insert Doctor ///////////////////////
if (isset($_POST['psubmit'])  && isset($_SESSION["token"]) && $_POST["token"]==$_SESSION["token"] ) {
	$doc_name = isset($_POST['doc_name']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_name']) : "";
	$doc_dob = isset($_POST['doc_dob']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_dob']) : "";
	$doc_address = isset($_POST['doc_address']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_address']) : "";
	$doc_phone = isset($_POST['doc_phone']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_phone']) : "";
	$doc_gender = isset($_POST['doc_gender']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_gender']) : "";
	
	$doc_joiningdate = isset($_POST['doc_joiningdate']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_joiningdate']) : "";
	$doc_relievingdate = isset($_POST['doc_relievingdate']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_relievingdate']) : "";
	$doc_timeofduty_from = isset($_POST['doc_timeofduty_from']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_timeofduty_from']) : "";
	$doc_timeofduty_to = isset($_POST['doc_timeofduty_to']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_timeofduty_to']) : "";
	$doc_qualification = isset($_POST['doc_qualification']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_qualification']) : "";
	$doc_expertise = isset($_POST['doc_expertise']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_expertise']) : "";
	$doc_wages = isset($_POST['doc_wages']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_wages']) : "";
	$doc_shares = isset($_POST['doc_shares']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_shares']) : "";
	// $doc_indoor_shares = isset($_POST['doc_indoor_shares']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_indoor_shares']) : "";
	$doc_cnic = isset($_POST['doc_cnic']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_cnic']) : "";
	$doc_dutydays = isset($_POST['doc_dutydays']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_dutydays']) : "";
	$image = $_FILES['userImage']['tmp_name']; 
	if (!empty($image)) {
		$imgContent = addslashes(file_get_contents($image));
		$insert_data = "INSERT INTO ssh_dr_reg (CNIC,Name, DOB, Address, Phone, Gender, Picture, DOJ, DOR, TOD,TOD_TO,duty_days, Qualification, Expertise, status, Wages, Shares, Indoor_Shares) VALUES ('".$doc_cnic."','".$doc_name."','".$doc_dob."','".$doc_address."','".$doc_phone."','".$doc_gender."','".$imgContent."','".$doc_joiningdate."','".$doc_relievingdate."','".$doc_timeofduty_from."','".$doc_timeofduty_to."','".$doc_dutydays."','".$doc_qualification."','".$doc_expertise."','1','".$doc_wages."','".$doc_shares."','0')";
		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			header('location: doctors');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}else{
	$insert_data = "INSERT INTO ssh_dr_reg (CNIC,Name, DOB, Address, Phone, Gender, DOJ, DOR, TOD,TOD_TO,duty_days, Qualification, Expertise, status, Wages, Shares, Indoor_Shares) VALUES ('".$doc_cnic."','".$doc_name."','".$doc_dob."','".$doc_address."','".$doc_phone."','".$doc_gender."','".$doc_joiningdate."','".$doc_relievingdate."','".$doc_timeofduty_from."','".$doc_timeofduty_to."','".$doc_dutydays."','".$doc_qualification."','".$doc_expertise."','1','".$doc_wages."','".$doc_shares."','0')";
		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			header('location: doctors');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
	
	}
///////////////////////////// Update Doctor ///////////////////////
if (isset($_POST['pupdate'])) {
	$doc_name_u = isset($_POST['doc_name_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_name_u']) : "";
	$doc_dob_u = isset($_POST['doc_dob_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_dob_u']) : "";
	$doc_address_u = isset($_POST['doc_address_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_address_u']) : "";
	$doc_phone_u = isset($_POST['doc_phone_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_phone_u']) : "";
	$doc_gender_u = isset($_POST['doc_gender_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_gender_u']) : "";
	
	$doc_doj_u = isset($_POST['doc_doj_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_doj_u']) : "";
	$doc_dor_u = isset($_POST['doc_dor_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_dor_u']) : "";
	$doc_tod_u = isset($_POST['doc_tod_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_tod_u']) : "";
	$doc_tod_to_u = isset($_POST['doc_tod_to_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_tod_to_u']) : "";
	$doc_qualification_u = isset($_POST['doc_qualification_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_qualification_u']) : "";
	$doc_expertise_u = isset($_POST['doc_expertise_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_expertise_u']) : "";
	$doc_wages_u = isset($_POST['doc_wages_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_wages_u']) : "";
	$doc_shares_u = isset($_POST['doc_shares_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_shares_u']) : "";
	// $doc_indoor_shares_u = isset($_POST['doc_indoor_shares_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_indoor_shares_u']) : "";
	$doc_id_update = isset($_POST['doc_id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_id_update']) : "";
	$doc_dutydays_u = isset($_POST['doc_dutydays_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['doc_dutydays_u']) : "";
	$update_data = "UPDATE ssh_dr_reg SET Name = '".$doc_name_u."', DOB = '".$doc_dob_u."', Address = '".$doc_address_u."', Phone = '".$doc_phone_u."', Gender = '".$doc_gender_u."', DOJ = '".$doc_doj_u."', DOR = '".$doc_dor_u."', TOD = '".$doc_tod_u."', TOD_TO = '".$doc_tod_to_u."', duty_days = '".$doc_dutydays_u."', Qualification = '".$doc_qualification_u."', Expertise = '".$doc_expertise_u."', Wages = '".$doc_wages_u."', Shares = '".$doc_shares_u."'  WHERE ssh_dr_reg.D_ID='".$doc_id_update."' ";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header('location: doctors');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}	
?>