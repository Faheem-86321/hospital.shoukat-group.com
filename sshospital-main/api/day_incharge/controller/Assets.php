<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
	$as_title = isset($_POST['as_title']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['as_title']) : "";
	$as_product = $_POST['as_product'];
	$insert_data = "INSERT INTO ssh_assets (A_Name) VALUES ('".$as_title."')";
	$insert_data_ex = mysqli_query($con,$insert_data);
	if ($insert_data_ex) {
		$last_id = $con->insert_id;
		for ($i=0; $i < count($as_product) ; $i++) { 
			$as_product_u = $_POST['as_product'][$i];
			$as_price = $_POST['as_price'][$i];
			$insert_data_type = "INSERT INTO ssh_assets_types (A_id,name,value) VALUES ('".$last_id."','".$as_product_u."','".$as_price."')";
			$insert_data_type_ex = mysqli_query($con,$insert_data_type);
		}
	}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['pupdate'])) {
	date_default_timezone_set("Asia/Karachi");
	$as_title_u = isset($_POST['as_title_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['as_title_u']) : "";
	$as_a_id_u = isset($_POST['as_a_id_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['as_a_id_u']) : "";
	$as_product_u = $_POST['as_product_u'];
	$insert_data = "UPDATE `ssh_assets` SET `A_Name`='".$as_title_u."' WHERE A_ID = '".$as_a_id_u."' ";
	$insert_data_ex = mysqli_query($con,$insert_data);
	if ($insert_data_ex) {
		$del_data1 = "DELETE FROM ssh_assets_types where A_id='".$as_a_id_u."'";
        $del_data1_ex = mysqli_query($con,$del_data1);
		for ($i=0; $i < count($as_product_u) ; $i++) { 
			$as_product_u_u = $_POST['as_product_u'][$i];
			$as_price_u = $_POST['as_price_u'][$i];
			$insert_data_type = "INSERT INTO ssh_assets_types (A_id,name,value) VALUES ('".$as_a_id_u."','".$as_product_u_u."','".$as_price_u."')";
			$insert_data_type_ex = mysqli_query($con,$insert_data_type);
		}
	}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>