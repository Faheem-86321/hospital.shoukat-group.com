<?php 
setcookie('user_id', '' , 60,'/');
setcookie('user_email', '' , 60,'/');
setcookie('final_pass', '' , 60,'/');
setcookie('user_type', '' , 60,'/');
setcookie('user_name', '' , 60,'/');
setcookie('name', '' , 60,'/');
setcookie('profile_pic', '' , 60,'/');
session_unset();
header('Location: ../login');

 ?>