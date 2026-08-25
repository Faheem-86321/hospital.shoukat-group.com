<?php 
///////////////////////////// Insert Service ///////////////////////
if (isset($_POST['psubmit'])) {
	date_default_timezone_set("Asia/Karachi");
	$productname = $_POST['productname'];
	$expense_d = isset($_POST['expense_d']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['expense_d']) : "";
	$quantity = isset($_POST['quantity']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['quantity']) : "";
	// $paid = $_POST['paid'];
	// $payment_date = $_POST['payment_date'];
	

	$insert_data = "INSERT INTO ssh_expenses (services,Title,Amount,Date,user_id,quantity) VALUES ('1','".$productname."','".$expense_d."','".date('Y-m-d')."','".$_SESSION['user_id']."','".$quantity."')";

		$insert_data_ex = mysqli_query($con,$insert_data);
		if ($insert_data_ex) {
			$ssh_ser_inv_stock = 0;
			$fetch_data = "SELECT * FROM `ssh_ser_inv` where Title Like '%".$productname."%' ";
			$fetch_data_ex = mysqli_query($con,$fetch_data);
			foreach($fetch_data_ex as $row){
				$ssh_ser_inv_stock = $row['Stock'];
			}
			$total_stock_inv = $ssh_ser_inv_stock + $quantity;
			$update_data = " UPDATE ssh_ser_inv SET Stock ='".$total_stock_inv."', last_date='".date('Y-m-d')."' where  Title Like '%".$productname."%' ";
			$update_data_ex = mysqli_query($con,$update_data);

			$ssh_ser_dialysis_item_stock = 0;
			$fetch_data_dia = "SELECT * FROM `dialysis_item` where item_name Like '%".$productname."%' ";
			$fetch_data_dia_ex = mysqli_query($con,$fetch_data_dia);
			foreach($fetch_data_dia_ex as $row){
				$ssh_ser_dialysis_item_stock = $row['stock'];
			}
			$total_stock_dialysis_item = $ssh_ser_dialysis_item_stock + $quantity;
			$update_data_dia = " UPDATE dialysis_item SET stock ='".$total_stock_dialysis_item."', last_update='".date('Y-m-d')."' where  item_name Like '%".$productname."%' ";
			$update_data_dia_ex = mysqli_query($con,$update_data_dia);

			header('location: product_inventory');
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
///////////////////////////// Update  ///////////////////////
if (isset($_POST['pupdate_payment'])) {
	$payment_date = $_POST['payment_date'];
	$paid = isset($_POST['paid']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['paid']) : "";
	
	$ser_id_update = isset($_POST['ser_id_update']) ? preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $_POST['ser_id_update']) : "";
	

	$update_data = " UPDATE ssh_expenses SET paid='".$paid."', payment_date='".$payment_date."' where Voucher='".$ser_id_update."'";
		$update_data_ex = mysqli_query($con,$update_data);
		if ($update_data_ex) {
			header("Location: " . $_SERVER['REQUEST_URI']);
		}
		else{
			echo "<div class='alter alter-danger'>Data does not exist!</div>";
		}
	}
?>