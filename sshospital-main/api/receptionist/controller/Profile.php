<?php
/////////////// Fetch User Info ////////////////////
$db->Select("*");
$db->From("wt_users");
$db->Where("id = '".$_SESSION['user_id']."'");
$user_update = $db->result(); 
$row = mysqli_fetch_array($user_update);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Update My profile /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
   if(empty($name_cv)){
     $updateuser = "UPDATE wt_users SET fname = '".$fname."',lname = '".$lname."',aboutme = '".$aboutme."',email = '".$email."',address = '".$address."',phone = '".$phone."' WHERE id = '".$id_update."' ";
     $updateuser_ex = mysqli_query($con,$updateuser);
     if ($updateuser_ex) {
       header('location: profile');
}
else{
      echo "<div class='alter alter-danger'>Data does not exist!</div>";
}
}else{
       $updateuser = "UPDATE wt_users SET fname = '".$fname."',lname = '".$lname."',aboutme = '".$aboutme."',email = '".$email."',address = '".$address."',profile_pic = '".$name_cv."',phone = '".$phone."' WHERE id = '".$id_update."' ";
       $updateuser_ex = mysqli_query($con,$updateuser);
       if ($updateuser_ex) {
             
          header('location: profile');
   }
   else{
      echo "<div class='alter alter-danger'>Data does not exist!</div>";
}
}
}

?>
