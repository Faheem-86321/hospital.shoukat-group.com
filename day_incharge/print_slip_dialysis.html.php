<?php 
if(isset($_GET['slip'])) {
	ob_start();
	session_start();
	include_once("../env/main_config.php");
	$slip = $_GET['slip'];
	$fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID where ssh_p_dialysis.pd_id  = '".$slip."' ";
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

			<div class="container-fluid" style="padding: 0px 300px !important;">
				<div class="row">
					<div class="col-md-12 text-center">
						<h1><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur" ;?></h1>
						<p><?php echo $_SESSION['com_address'] ;?></p>
					</div>
					<div class="col-md-12 " >
						<h4 style="background: lightgrey;padding: 15px;"><b>Case Info:</b></h4>

						<div class="row">
							<div class="col-md-6 text-center">
								<h1> Dialysis </h1>
							</div>
							<div class="col-md-6 text-center">
								<h5><b>Date: </b> <?php echo $row['date'] ?></h5><?php
								$fetch_data2 = "SELECT * FROM ssh_p_dialysis WHERE Date = '".date('Y-m-d')."'";
								$fetch_data2_ex = mysqli_query($con,$fetch_data2); ?>
								<h1>Token: <?php echo mysqli_num_rows($fetch_data2_ex) ?></h1>
							</div>

						</div>

					</div>
					<div class="col-md-12 " >
						<h4 style="background: lightgrey;padding: 15px;"><b>Patient Info:</b></h4>

						<h1><?php echo $row['Name'] ?></h1>
						<div class="row">
							<div class="col-md-6">
								<h5><b>Gender: </b> <?php echo $row['gender'] ?> </h5>
							</div>
							<div class="col-md-6">
								<h5><b>Age: </b> <?php echo $row['age'] ?></h5>
							</div>
							<div class="col-md-6">
								<h5><b>Contact #: </b> <?php echo $row['phone'] ?></h5>
							</div>
						</div>

					</div>
				<!-- <div class="col-md-4">
					<h4><b>Doctor Info:</b></h4>
					<h1><?php echo $row['d_name'] ?></h1>
					<div class="row">
						<div class="col-md-6">
							<h6><b><?php echo $row['Expertise'] ?></b><br><b><?php echo $row['Qualification'] ?></b> </h6>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<h5><b>Visit #:  </b><?php echo $row['visit'] ?></h5>
								</div>
								<div class="col-md-12">
									<h5><b>Date & Time: </b><?php echo $row['A_Date'] ?> </h5>
								</div>
							</div>
						</div>
						

					</div>
				</div> -->
				
				<div class="col-md-12" style="border-bottom: 1px solid black; margin-top: 20px ;">
					<!-- <div class="row">
						<div class="col-md-4">
							<h5><b>Temperature(F/C): </b></h5>
						</div>
						<div class="col-md-4">
							<h5><b>B.P(mmHg): </b></h5>
						</div>
						<div class="col-md-4">
							<h5><b>Weight(kg): </b></h5>
						</div>
					</div> -->
				</div>
				<div class="col-md-12">
					<h4 style="background: lightgrey;padding: 15px;"><b>Total Payable:</b> <b style="float: right;"><?php echo $row['Paid'] ?></b></h4>
					
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







