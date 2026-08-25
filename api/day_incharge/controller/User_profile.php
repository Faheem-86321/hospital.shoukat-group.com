<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Update User Info /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pupdate'])) {
    $fname = isset($_POST['fname']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['fname']) : "";
    $lname = isset($_POST['lname']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['lname']) : "";
    $aboutme = isset($_POST['aboutme']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['aboutme']) : "";
    $email = isset($_POST['email']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['email']) : "";
    $address = isset($_POST['address']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['address']) : "";
    $targetfolder = "../images/";
    $name_cv = $_FILES['profile_pic']['name'];
    $targetfolder = $targetfolder . basename( $_FILES['profile_pic']['name']) ;
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetfolder);

    $id_update = isset($_POST['id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['id_update']) : "";
    $phone = isset($_POST['phone']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['phone']) : "";
    $salary_u = isset($_POST['salary_u']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['salary_u']) : "";
    
    if(empty($name_cv)){
         $updateuser = "UPDATE wt_users SET fname = '".$fname."',lname = '".$lname."',aboutme = '".$aboutme."',email = '".$email."',address = '".$address."',phone = '".$phone."',salary = '".$salary_u."' WHERE id = '".$id_update."' ";
         $updateuser_ex = mysqli_query($con,$updateuser);
         if ($updateuser_ex) {

           header('Location: '.$_SERVER['REQUEST_URI']);
    }
    else{
        echo "<div class='alter alter-danger'>Data does not exist!</div>";
 }
}else{
       $updateuser = "UPDATE wt_users SET fname = '".$fname."',lname = '".$lname."',aboutme = '".$aboutme."',email = '".$email."',address = '".$address."',profile_pic = '".$name_cv."',phone = '".$phone."',salary = '".$salary_u."' WHERE id = '".$id_update."' ";
    $updateuser_ex = mysqli_query($con,$updateuser);
    if ($updateuser_ex) {

           header('Location: '.$_SERVER['REQUEST_URI']);
    }
    else{
        echo "<div class='alter alter-danger'>Data does not exist!</div>";
 }
}
}

?>
