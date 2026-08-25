<?php 
if(isset($_GET['slip'])) {
	ob_start();
	session_start();
	include_once("../env/main_config.php");
	$slip = $_GET['slip'];
	 date_default_timezone_set("Asia/Karachi");
    $update_data = "UPDATE ssh_p_indoor SET exit_date = '".date('Y-m-d')."'  WHERE pi_id='".$slip."' ";
    $update_data_ex = mysqli_query($con,$update_data);
	$fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id  where ssh_p_indoor.pi_id  = '".$slip."' ";
	$fetch_data_ex = mysqli_query($con,$fetch_data);
	foreach($fetch_data_ex as $row){ ?>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Print Slip</title>
			<link rel="stylesheet" href="../assets/header/bootstrap.min.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		</head>
		<body>

			<div class="container-fluid" >
				<div class="row">
					
					<div class="col-md-3 text-center">
						<img src="<?php  echo "../images/".$_SESSION['com_logo'] ;?>" alt="" width="150">
					</div>
					<div class="col-md-6 text-center">
						<h1><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur" ;?></h1>
						<h4><b>0444542324</b></h4>
						<p><?php echo $_SESSION['com_address'] ;?></p>
						<h2><b>DISCHARGE SLIP</b></h2>
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-4"></div>
					<div class="col-md-4" style="border: 0.1px groove lightgrey;"><h3><b>Medical No.</b></h3></div>
					<div class="col-md-12 mt-2">

						<div class="row">
							<div class="col-md-3" style="border: 0.1px groove lightgrey;border-right: 0px !important;" ><h3><b>Name : </b></h3></div>
							<div class="col-md-3" style="border: 0.1px groove lightgrey;border-right: 0px !important;border-left: 0px !important;"><h3><?php echo $row['Name'] ?></h3></div>
							<div class="col-md-3" style="border: 0.1px groove lightgrey;border-right: 0px !important;border-left: 0px !important;"><h3><b>Phone : </b></h3></div>
							<div class="col-md-3" style="border: 0.1px groove lightgrey;border-left: 0px !important;"><h3><?php echo $row['phone'] ?></h3></div>
							
							<div class="col-md-2" style="border: 0.1px groove lightgrey;border-right: 0px !important;"><h3><b>D.O.A : </b></h3></div>
							<div class="col-md-2" style="border: 0.1px groove lightgrey;border-right: 0px !important;border-left: 0px !important;"><h3><?php echo $row['admit_date'] ?></h3></div>
							<div class="col-md-2" style="border: 0.1px groove lightgrey;border-right: 0px !important;border-left: 0px !important;"><h3><b>D.O.O : </b></h3></div>
							<div class="col-md-2" style="border: 0.1px groove lightgrey;border-right: 0px !important;border-left: 0px !important;"><h3></h3></div>
							<div class="col-md-2" style="border: 0.1px groove lightgrey;border-right: 0px !important;border-left: 0px !important;"><h3><b>D.O.D : </b></h3></div>
							<div class="col-md-2" style="border: 0.1px groove lightgrey;border-left: 0px !important;"><h3><?php echo $row['exit_date'] ?></h3></div>
							
							<div class="col-md-12" ><h3><b>Diagnose</b></h3>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
								</div>
							</div>
							<div class="col-md-12" ><h3><b>Procedure</b></h3>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
								</div>
							</div>
							<div class="col-md-12"><h3><b>Discharge Medicine</b></h3>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
								</div>

							</div>
							<div class="col-md-12" ><h3><b>Follow UP Instruction</b></h3>

								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
									<div class="col-md-1"></div>
									<div class="col-md-1"></div>
									<div class="col-md-10" style="border: 0.1px groove lightgrey;margin-top: 45px;"></div>
								</div>

							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
							<div class="col-md-4"><h3>Signature: </h3></div>
						</div>
					
					

				</div>
				</div>
				<script type="text/javascript">
					window.print();
					window.addEventListener("afterprint", myFunction);
					function myFunction() {
						window.close();				
					}
				</script>
				<div class="footer" style="text-align:center; font-size:11px; border-top:1px dashed #000; margin-top:15px; padding-top:5px;">
    Developed by <b><a href="https://portfolio.faheemullah.site/" target="_blank" style="text-decoration:none; color:#000;">Faheem Ullah</a></b>
</div>

			</body>

			</html>
		<?php } } else{ ?>
			<img src="../images/404error.png" width="100%" height="100%">
			<?php
		} ?>







