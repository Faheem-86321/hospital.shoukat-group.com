 <?php
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Change Password /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 $user_id = $_SESSION['user_id'];
 if(isset($_POST['change'])){
 	$password = $_POST['password'];
  $last_pass = md5($password );
  $confirm_password = $_POST['confirm_password'];
  if($password == $confirm_password){
     $update_q = "UPDATE  wt_users SET password ='".$last_pass."' WHERE id = '".$_SESSION['user_id']."'AND status= '1' ";
     $execuit = mysqli_query($con,$update_q );
     if ($execuit) {
        header('Location:../login');
        session_unset();
     }
  }
  else{
    $message = "Please Enter Correct Password";  
 }

}
?>
