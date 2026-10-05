<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	$room_no = isset($_POST['room_no']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['room_no']) : "";
	
		// $insert_data = "INSERT INTO indoor_room (room_no,status) VALUES ('".$room_no."','0')";
		// $insert_data_ex = mysqli_query($con,$insert_data);
	
	$filename=$_FILES["excel_file"]["tmp_name"];
		
		if($_FILES["excel_file"]["size"] > 0)
		{
			$file = fopen($filename, "r");
			while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
			{
				$insert_data = "INSERT INTO ssh_cases_indoor (Title, Charges, type, close) VALUES ('".$emapData[0]."','0','0','1')";
				$insert_data_ex = mysqli_query($con,$insert_data);
	          // //It wiil insert a row to our subject table from our csv file`
			// 	$employee_insert = "INSERT INTO `wt_users` (`fname`, `address`, `user_name`, `email`, `aboutme`, `password`,`profile_pic`, `phone`, `region`, `type`, `portal_type`, `joining_date`, `gardian`, `state`, `zip_code`, `country`,  `location`,  `driving_no`, `driving_no_ex`, `number_residence`, `sex`, `marital_status`, `dob`, `cnic`, `cnic_ex`,  `nationality`, `blood_group`, `close`, `status`, `live_status`) VALUES ('".$emapData[1]."', '".$emapData[2]."', '".$emapData[3]."', '".$emapData[4]."','".$emapData[5]."', '827ccb0eea8a706c4c34a16891f84e7b', 'avatar.png', '".$emapData[6]."',  '".$region_to_import."', 'user', 'employee', '".date("Y-m-d", strtotime($emapData[7]))."', '".$emapData[8]."', '".$emapData[9]."', '".$emapData[10]."', '".$emapData[11]."',  '".$emapData[12]."',  '".$emapData[13]."', '".date("Y-m-d", strtotime($emapData[14]))."', '".$emapData[15]."', '".$emapData[16]."', '".$emapData[17]."', '".date("Y-m-d", strtotime($emapData[18]))."', '".$emapData[19]."', '".date("Y-m-d", strtotime($emapData[20]))."', '".$emapData[21]."','".$emapData[22]."',  '1', '1', '1')";
			// 		$employee_insert_ex = mysqli_query($con,$employee_insert);
			// 		if(! $employee_insert_ex)
			// 		{
			// 			echo "<script type=\"text/javascript\">
			// 			alert(\"Error: There is a problem with your CSV File.\");

			// 			</script>";
			// 		}

				}
				fclose($file);

			}

		
	}
?>