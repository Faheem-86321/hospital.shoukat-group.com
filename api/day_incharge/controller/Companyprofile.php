<?php
/////////////// Fetch Company Info //////////////////// 
$db->Select("*");
$db->From("company_info");
$db->Where("close ='1' AND status = '1'");
$company_ex = $db->result(); 
/////////////// Fetch User Info //////////////////// 
$db->Select("*");
$db->From("wt_users");
$db->Where("id = '".$_SESSION['user_id']."'");
$user_update = $db->result(); 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Update User Info /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update'])){
    $fname = isset($_POST['fname']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['fname']) : "";
    $lname = isset($_POST['lname']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['lname']) : "";
    $email = isset($_POST['email']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['email']) : "";
    $password1 = isset($_POST['password']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['password']) : "";
    $password = md5($password1);
    $phone_no = isset($_POST['phoneno']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['phoneno']) : "";
    $add_user_sql = "UPDATE  wt_users SET fname = '".$fname."',lname = '".$lname."',phone = '".$phone_no."' WHERE id = '".$_SESSION['user_id']."'";
    $add_user_sql_ex = mysqli_query($con,$add_user_sql);
    if ($add_user_sql_ex) {
       header('Location:../login');
   }
   else{
    echo "error";
}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Update Company Info ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if(isset($_POST['updatecompany'])){
    $companyname = isset($_POST['companyname']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['companyname']) : "";
    $companyphone = isset($_POST['companyphone']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['companyphone']) : "";
    $companytel = isset($_POST['companytel']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['companytel']) : "";
    $companyemail = isset($_POST['companyemail']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['companyemail']) : "";
    $companyaddress = isset($_POST['companyaddress']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['companyaddress']) : "";
    $logo_photo = $_FILES['logo_photo']['name'];
    $folder = "../images/";   
    move_uploaded_file($_FILES['logo_photo']['tmp_name'], $folder . $logo_photo);
    $add_user_sql = "UPDATE  company_info SET com_name = '".$companyname."',com_phone = '".$companyphone."',com_tel = '".$companytel."',com_email = '".$companyemail."',com_logo = '".$logo_photo."',com_address = '".$companyaddress."',close = '1',status = '1' WHERE com_id = '1' ";
    $add_user_sql_ex = mysqli_query($con,$add_user_sql);
    if ($add_user_sql_ex) {
        header('Location: dashboard');
    }
    else{
        echo "error";
    }
}
?>
