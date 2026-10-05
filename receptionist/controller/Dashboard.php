<?php 





// New Code end here
// This Queries will be same
$user_email = $_SESSION['user_email'];
$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];
$current_date =  date('Y-m-d');
$current_time =  date('H:i:s');
$current_month =  date('m-Y');
$db->Select("*");
$db->From("wt_users");
$db->Where("email = '".$user_email."'");
$execuit = $db->result(); 
$db->Select("*");
$db->From("wt_users");
$db->Where("status = '1' AND type = 'user'");
$execuit_product = $db->result(); 
$num_product = mysqli_num_rows($execuit_product);
$db->Select("*");
$db->From("wt_users");
$db->Where("status = '1' AND type = 'admin'");
$execuit_user = $db->result(); 
$num_user = mysqli_num_rows($execuit_user);
?>