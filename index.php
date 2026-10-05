<?php 
  session_start();
  ob_start(); 
if(!isset($_GET['page'])){
  $_GET['page']= "login";
}
if(file_exists("web_temp/". $_GET['page'].".html.php")) 
{
  /* Common Header */
  $head_title = $_GET['page'];
  include_once("models/logincookie.php");
  include_once("env/main_config.php");
  include_once("common/header.php");
  
  include_once("web_temp/". $_GET['page'].".html.php");
  include_once("common/footer.php");
}else{
  ?>
  <img src="images/html-404-error.jpg" width="100%" height="100%">
  <?php
  die();
}
?>

