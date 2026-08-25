
<style type="text/css">
	*{
		margin: 0;
		padding: 0;
	}
</style>
<?php 
	ob_start();
session_start();
if(!isset($_GET['page'])){
	$_GET['page']= "dashboard";
}
if(file_exists("controller/". $_GET['page'].".php")) 
{

	/* Common Header */
	$head_title = $_GET['page'];
	
	include_once("../env/main_config.php");
	include_once('models/login.php');
	include_once('models/queries.php');
	
	include_once("common/header.php");
	
	
	/* include Body */
	
	// incldue Controller here
	include_once("controller/". $_GET['page'].".php");
	
	// incldue template here
	include_once("template/". $_GET['page'].".html.php");
	
	/* Common Footer */
	include_once("common/footer.php");
	
}else{
	?>
	<img src="../images/404error.png" width="100%" height="100%">
	<?php
	die();
}


?>
