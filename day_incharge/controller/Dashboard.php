<?php 
///////////////////////////// Insert Cash ///////////////////////
if (isset($_POST['submit_cash'])) {
    $cash_price = isset($_POST['cash_price']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['cash_price']) : "";
    $insert_data = "INSERT INTO ssh_dr_payment(Date,D_ID,Payment) VALUES('".date('Y-m-d')."','0','".$cash_price."')";
        $insert_data_ex = mysqli_query($con,$insert_data);
        if ($insert_data_ex) {
            header('location: dashboard');
        }
        else{
            echo "<div class='alter alter-danger'>Data does not exist!</div>";
        }
    }



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
$db->Where("email = '".$user_email."' ");
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