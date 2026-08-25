<?php 
include_once("../env/main_config.php");
$validate_data = "Select * from wt_users where id = '".$_SESSION['user_id']."' AND user_name = '".$_SESSION['user_name']."'   ";
$validate_data_ex = mysqli_query($con,$validate_data);
if($_SESSION['user_type'] != "day_incharge" || mysqli_num_rows($validate_data_ex) !== 1){
	header("Location: logout");
}



?>
	