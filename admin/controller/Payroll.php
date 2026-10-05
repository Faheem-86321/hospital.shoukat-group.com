<?php

if (isset($_POST['Generatesalary'])) {

    $filename = $_FILES["excel_file"]["tmp_name"];
    $pDate = date('Y-m-d');

    if ($_FILES["excel_file"]["size"] > 0) {
        $file = fopen($filename, "r");

        $rowCounter = 0;  

        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        	 
            $rowCounter++;

            if ($rowCounter === 1 || $rowCounter === 2) {
                continue;
            }

            $yee_insert = "INSERT INTO `payments` (`p_date`,`p_purpose`, `e_id`, `total_salary`, `bonus`, `absents`, `deductions`, `p_debit`, `close`, `status`) VALUES ('$pDate','Salary Generated', '$emapData[0]', '$emapData[3]', '$emapData[4]', '$emapData[5]', '$emapData[6]', '$emapData[7]','1','1')";
            $_insert_ex = mysqli_query($con, $yee_insert);

            if (!$_insert_ex) {
                echo "<script type=\"text/javascript\">
                    alert(\"Error: There is a problem with your CSV File.\");
                </script>";
            }
            
        }

        fclose($file);
    }
} 



	/*<<<<< ADD PAYMENT >>>>>*/

	if(isset($_POST['submit_payment'])){
		$e_id =  $_POST['e_name'];
		$date = $_POST['p_date'];
		$cash = $_POST['e_cash'];
		$purpose = $_POST['p_purpose'];

		if ($purpose == "bonus") {
			$add_payment = "INSERT INTO payments (`e_id`, `p_date`, `p_purpose`, `p_debit`, `p_credit`, `close`, `status`) VALUES ('".$e_id."','".$date."','".$purpose."','".$cash."','".$cash."','1','1')";
				$add_payment_ex = mysqli_query($con,$add_payment);
			}
			elseif($purpose == "return") {
				$add_payment = "INSERT INTO payments (`e_id`, `p_date`, `p_purpose`, `p_debit`, `p_credit`, `close`, `status`) VALUES ('".$e_id."','".$date."','".$purpose."','".$cash."','0','1','1')";
					$add_payment_ex = mysqli_query($con,$add_payment);
				}
				else{
					$add_payment = "INSERT INTO payments (`e_id`, `p_date`, `p_purpose`, `p_debit`, `p_credit`, `close`, `status`) VALUES ('".$e_id."','".$date."','".$purpose."','0','".$cash."','1','1')";
						$add_payment_ex = mysqli_query($con,$add_payment);
					}

					if($add_payment_ex){
						header('location: payroll');
					}
					else{
						echo "<div class='alert alert-success'>
						<strong>There is an error in the query!
						</div>";
					}


				}

				if(isset($_POST['updatep'])){
					$payroll_id =  $_POST['payroll_id'];
					$employee_id =  $_POST['employee_id'];
					$debit =  $_POST['p_debit'];
					$credit = $_POST['p_credit'];

					$update_payment = "UPDATE payments SET p_debit = '".$debit."' , p_credit = '".$credit."' WHERE p_id = '".$payroll_id."'";
					$update_payment_ex = mysqli_query($con,$update_payment);

					if($update_payment_ex){
						header('location: payroll');
					}
					else{
						echo "<div class='alert alert-success'>
						<strong>There is an error in the query!
						</div>";
					}


				}


			?>