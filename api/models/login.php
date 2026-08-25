<?php 
include_once '../env/main_config.php';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Chechk Valid User /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['logintyww'])) {
  ob_start();
  session_start();
  $log_user = $_POST['userjsd'];
  $log_pass = $_POST['passjfbdj'];
  $final_pass = md5($log_pass);
  $log_sql = "SELECT * FROM wt_users WHERE (user_name = '".$log_user."' OR  email = '".$log_user."') AND password = '".$final_pass."' AND status = '1' AND close = '1' ";
   $log_sql_ex = mysqli_query($con,$log_sql);
   if (mysqli_num_rows($log_sql_ex) == '1') {
    foreach ($log_sql_ex as $log_sql_ex1) {
      $_SESSION['final_pass'] = $log_sql_ex1['password'];
      setcookie('final_pass', $log_sql_ex1['password'],time()+(60*60*24*30),'/');
      $_SESSION['user_id'] = $log_sql_ex1['id'];
      setcookie('user_id', $log_sql_ex1['id'],time()+(60*60*24*30),'/');
      $_SESSION['user_name'] = $log_sql_ex1['user_name'];
      setcookie('user_name', $log_sql_ex1['user_name'],time()+(60*60*24*30),'/');
      $_SESSION['user_email'] = $log_sql_ex1['email'];
      setcookie('user_email', $log_sql_ex1['email'],time()+(60*60*24*30),'/');
      $_SESSION['user_type'] = $log_sql_ex1['type'];
      setcookie('user_type', $log_sql_ex1['type'],time()+(60*60*24*30),'/');
      $_SESSION['profile_pic'] = $log_sql_ex1['profile_pic'];
      setcookie('profile_pic', $log_sql_ex1['profile_pic'],time()+(60*60*24*30),'/');
      $_SESSION['uname'] = $log_sql_ex1['fname']." ".$log_sql_ex1['lname'];
      setcookie('uname', $_SESSION['uname'],time()+(60*60*24*30),'/');
    }if ($_SESSION['user_type'] == 'admin') {
      header('Location: ../admin/dashboard');
    }elseif ($_SESSION['user_type'] == 'receptionist') {
      header('Location: ../receptionist/dashboard');
    }elseif ($_SESSION['user_type'] == 'day_incharge') {
      header('Location: ../day_incharge/dashboard');
    }else{
      echo "Page Not Found";
    }
  }
  else{
    $_SESSION['loginfail'] = "<div class='alert alert-danger' style = 'text-align : center;'><strong>Please enter correct username and password!!</strong></div>";
    header('Location: ../login');
    
  }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Forgot Password /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['getpassword'])){
  $useremailfornewpass = $_POST['useremailfornewpass'];
  $log_sql = "SELECT * FROM wt_users WHERE email = '".$useremailfornewpass."' AND close = '1' AND status = '1'";
  $log_sql_ex = mysqli_query($con,$log_sql);
  $registration_proress = 0;
  $current_time = date('d-m-Y H:i:s');
  $Exptime = date('Y-m-d H:i:s', time() + (60*60*2));
  $token = hash('ripemd160',sha1(md5($email."".$current_time)));
  $insert_token = "UPDATE `wt_users` SET `cc_token`='".$token."',`cc_token_exp_time`='".$Exptime."' WHERE email = '".$useremailfornewpass."'";
  $insert_token_ex = mysqli_query($con,$insert_token);
  if (mysqli_num_rows($log_sql_ex) == 1) {
    foreach($log_sql_ex as $row){
      $nameofuser = $row['fname']." ".$row['lname'];
    }
    $data['gett'] = $token;
    $data['ctime'] = date('d-m-Y H:i:s');
    $urltoken = base64_encode(json_encode($data));
    $urllink = "https://".$_SERVER['HTTP_HOST']."/create_password?registration_id=".$urltoken."";
    $IhreNachricht = "You are almost there! Please click the link below to Create New password !<br><br>

    <a href='".$urllink."'>Create Password</a><br><br>

    This link will expire after exactly 2 hours<br>

    If you have any questions, feel free to reply to this email and we will be more than happy to help!<br><br><br><br>

    ".$_SESSION['com_name']." :)";
    $sender = $_SESSION['com_email'];
    $recipient = $useremailfornewpass;
    $subject = "Reset Password";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$sender."\r\n".
    'Reply-To: '.$sender."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $message = "<!DOCTYPE html>
    <head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Supermums CRM</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'/>

    <style type='text/css'>
    a[x-apple-data-detectors] {color: inherit !important;}
    </style>

    </head>
    <body style='margin: 0; padding: 0;'>
    <table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    <td style='padding: 20px 0 30px 0;'>

    <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse; border: 1px solid #cccccc;'>
    <tr>
    <td align='center' style='padding: 40px 0 30px 0;'>
    <img src='https://www.easyloan.ae/img/web-logo.png' alt='Creating Email Magic.' width='300' height='80' style='display: block;' />
    </td>
    </tr>
    <tr>
    <td bgcolor='#ffffff' style='padding: 40px 30px 40px 30px;'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;'>
    <tr>
    <td style='color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;'>
    <p style='margin: 0;'>
    <b>Dear '".ucwords($nameofuser)."'</b>,<br>
    '".$IhreNachricht."'
    </p>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr style='height: 150px'>
    <td bgcolor='#043768' style='padding: 30px 30px; text-align:center;'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;'>
    <tr>
    <td style='color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;'>
    <p style='margin: 0;'>

    <h4>".$_SESSION['com_address']."</h4>
    </p>

    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>

    </td>
    </tr>
    </table>
    </body>
    </html>";
    mail($recipient, $subject, $message, $headers);
    $_SESSION['msg'] = "<div class='alert alert-success' style = 'text-align : center;'><strong>Please Confirm your email to reset the password!!</div>";
    header("Location: ../login ");
  }
}

?>




