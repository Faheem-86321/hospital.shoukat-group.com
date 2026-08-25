<?php
ob_start();
session_start();
include_once("../env/main_config.php");
include_once('models/queries.php');
/////////////////////Payment Recieve//////////////////
///////////////////////////////////////////////
if (isset($_POST['r_payment_this'])) {
	?>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<label>Amount<span style="color: red;">*</span></label>
				<input type="number" name="cash_price" class="form-control" value="<?php echo $_POST['r_payment_this'] ?>">
			</div>
			<div class="col-md-12">
				<input type="submit" name="submit_cash" class="btn btn-success m-2" value="Save" class="form-control col-md-2" style="float: right;">	</div>

		</div>
	</form>
	<?php
}
/////////////////////MArk as read//////////////////
///////////////////////////////////////////////
if (isset($_POST['markasread'])) {
	$update_data = "UPDATE ssh_dr_payment SET notification = '1'  ";
	$update_data_ex = mysqli_query($con,$update_data);
	if ($update_data_ex) {
		echo true;
	}
}
//////// Check Valid Email of user ////////////////
///////////////////////////////////////////////////
if (isset($_POST['checkvalidemail'])) {
	$checkvalidemail = $_POST['checkvalidemail'];
	$db->Select("*");
	$db->From("wt_users");
	$db->Where("email = '".$checkvalidemail."' AND close= '1' AND status = '1' ");
	$get_data_ex= $db->result();
	if (mysqli_num_rows($get_data_ex) > 0) {
		echo "false";
	}else{
		echo "true";
	}
}
////////// Update User Portal Info  ////////////////
///////////////////////////////////////////////////
if (isset($_POST['user_portal'])) {
	$cl_id = $_POST['user_portal'];
	$db->Select("*");
	$db->From("wt_users");
	$db->Where("id = '".$cl_id."' ");
	$user_view= $db->result();
	foreach($user_view as $row){ ?>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group col-md-12">
					<input type="hidden" name="user_portal_id" value="<?php echo $row['id'] ?>">
					<label for="exampleInputEmail1">Name <span style="color: green;"> (Readonly)</span></label>
					<input type="text" class="form-control" readonly value="<?php echo ucwords($row['fname'])." ".ucwords($row['lname']) ?>" name="" id="exampleInputEmail1" >
				</div>
				
				<div class="form-group col-md-6">
					<label for="exampleInputEmail1">Username <span style="color: red;"> *</span></label>
					<input type="text" class="form-control" value="<?php echo $row['user_name'] ?>" name="username_u" readonly id="exampleInputEmail1" required>
				</div>
				<div class="form-group col-md-6">
					<label for="exampleInputEmail1">New Password <span style="color: red;"> *</span></label>
					<input type="text" class="form-control" name="password_u" id="exampleInputEmail1" required>
				</div>
				<div class="col-md-12 text-right">
					<button type="submit" name="pupdate" class="btn btn-success waves-effect waves-light">Save</button>
				</div>
			</div>
		</form> 	

	<?php }
}	
////////// Delete User  ////////////////
////////////////////////////////////////
if (isset($_POST['user_del'])) {
	$cl_id = $_POST['user_del'];
	$close = 0; 
	$del_query = "UPDATE wt_users SET close = '".$close."' WHERE id = '".$cl_id."'";
	$del_query_ex = mysqli_query($con,$del_query);
	if ($del_query_ex) {

	}else{
		echo "true";
	}
}
/////////////////////Data Backup//////////////////
///////////////////////////////////////////////
if (isset($_POST['data_backup'])) {
//Core function
	function backup_tables($host, $user, $pass, $dbname, $tables = '*', $con) {

    // Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit;
		}

		mysqli_query($con, "SET NAMES 'utf8'");

    //get all of the tables
		if($tables == '*')
		{
			$tables = array();
			$result = mysqli_query($con, 'SHOW TABLES');
			while($row = mysqli_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}

		$return = '';
    //cycle through
		foreach($tables as $table)
		{
			$result = mysqli_query($con, 'SELECT * FROM '.$table);
			$num_fields = mysqli_num_fields($result);
			$num_rows = mysqli_num_rows($result);

			$return.= 'DROP TABLE IF EXISTS '.$table.';';
			$row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			$counter = 1;

        //Over tables
			for ($i = 0; $i < $num_fields; $i++) 
        {   //Over rows
        	while($row = mysqli_fetch_row($result))
        	{   
        		if($counter == 1){
        			$return.= 'INSERT INTO '.$table.' VALUES(';
        		} else{
        			$return.= '(';
        		}

                //Over fields
        		for($j=0; $j<$num_fields; $j++) 
        		{
        			$row[$j] = addslashes($row[$j]);
        			$row[$j] = str_replace("\n","\\n",$row[$j]);
        			if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
        			if ($j<($num_fields-1)) { $return.= ','; }
        		}

        		if($num_rows == $counter){
        			$return.= ");\n";
        		} else{
        			$return.= "),\n";
        		}
        		++$counter;
        	}
        }
        $return.="\n\n\n";
    }

    //save file
    $fileName = '../backup/'.date('Y-m-d').'.sql';
    $handle = fopen($fileName,'w+');
    fwrite($handle,$return);
    if(fclose($handle)){
    	echo "Done, the file name is: ".$fileName;
    	exit; 
    }
}
//Call the core function
backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables, $con);

}

?>