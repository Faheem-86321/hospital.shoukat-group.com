<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Update User /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pupdate'])) {
	$user_portal_id = isset($_POST['user_portal_id']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['user_portal_id']) : "";
	$password_u = md5($_POST['password_u']);
	$updateuser = "UPDATE wt_users SET password = '".$password_u."' WHERE id = '".$user_portal_id."' ";
	$updateuser_ex = mysqli_query($con,$updateuser);
	if ($updateuser_ex) {
		header('location: users');
	}
	else{
		echo "<div class='alter alter-danger'>Data does not exist!</div>";
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Insert User /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
if (isset($_POST['psubmit'])) {
	$fname = isset($_POST['fname']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['fname']) : "";
	$lname = isset($_POST['lname']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['lname']) : "";
	$about = isset($_POST['about']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['about']) : "";
	$email = isset($_POST['email']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['email']) : "";
	$address = isset($_POST['address']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['address']) : "";
	$role = isset($_POST['role']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['role']) : "";
	$username = isset($_POST['username']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['username']) : "";
	$password = md5($_POST['password']);
	$current_date = date('Y-m-d');
	$phone = isset($_POST['phone']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['phone']) : "";
	$salary = isset($_POST['salary']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['salary']) : "";
	$current_date = date('Y-m-d');
	$targetfolder = "../images/";
	$name_cv = $_FILES['profile_pic']['name'];
	$targetfolder = $targetfolder . basename($_FILES['profile_pic']['name']) ;
	move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetfolder);
	if(empty($name_cv)){
	$user = "INSERT INTO `wt_users` (`fname`,`lname`,`address`,`user_name`, `email`,`aboutme`, `password`,`phone`,`type`,`profile_pic`,`joining_date`,`salary`,`close`, `status`) VALUES ('".$fname."','".$lname."','".$address."','".$username."','".$email."','".$about."','".$password."','".$phone."','".$role."','avatar.png','".$current_date."','".$salary."','1','1')";
		$user_ex = mysqli_query($con,$user);
	}else{
		$user = "INSERT INTO `wt_users` (`fname`,`lname`,`address`,`user_name`, `email`,`aboutme`, `password`,`phone`,`type`,`profile_pic`,`joining_date`,`salary`,`close`, `status`) VALUES ('".$fname."','".$lname."','".$address."','".$username."','".$email."','".$about."','".$password."','".$phone."','".$role."','".$name_cv."','".$current_date."','".$salary."','1','1')";
		$user_ex = mysqli_query($con,$user);
	}	
		if ($user_ex) {
			header('location: users');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}

?>