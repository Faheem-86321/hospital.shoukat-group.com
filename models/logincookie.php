<?php
  if (!empty($_COOKIE['user_id'])){
    include_once 'env/main_config.php';
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['user_email'] = $_COOKIE['user_email'];
    $_SESSION['final_pass'] = $_COOKIE['final_pass'];
    $_SESSION['user_name'] = $_COOKIE['user_name'];
    $_SESSION['user_type'] = $_COOKIE['user_type'];
    $_SESSION['uname'] = $_COOKIE['uname'];
    $_SESSION['sr_no'] = $_COOKIE['sr_no'];
    $_SESSION['profile_pic'] = $_COOKIE['profile_pic'];
    $_SESSION['portal_type'] = $_COOKIE['portal_type'];
    $_SESSION['region'] = $_COOKIE['region'];
    header('Location: '.$_SESSION['user_type'].'/dashboard');
   }
 ?>