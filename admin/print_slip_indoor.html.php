<?php 
if(isset($_GET['slip'])) {
	ob_start();
	session_start();
	include_once("../env/main_config.php");
	$slip = $_GET['slip'];
	$fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id  where ssh_p_indoor.pi_id  = '".$slip."' ";
	$fetch_data_ex = mysqli_query($con,$fetch_data);
	foreach($fetch_data_ex as $row){ ?>
		<html><head>
			<meta charset="utf-8">
			<title>Print Slip</title>
			<link rel="stylesheet" href="../assets/header/bootstrap.min.css">
		</head>
		<body>
			<div class="container-fluid" style="padding: 0px 300px !important;">
				<div class="row">
					<div class="col-md-12 text-center">
						<h1><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur" ;?></h1>
						<p><?php echo $_SESSION['com_address'] ;?></p>
					</div>
					<div class="col-md-12">
						<h1 class="text-center">Admission Slip</h1>
						<h4 style="background:lightgrey;padding:4px;"><b>Case Info:</b></h4>
						<div class="row">
							<div class="col-md-6 text-center"><h1><?php echo $row['Title'] ?></h1></div>
							<div class="col-md-6 text-center">
								<h5><b>Date:</b> <?php echo $row['admit_date'] ?> &nbsp; <b>Time:</b> <?php echo date('H:i:s', strtotime($row['admit_date'])) ?></h5>
								<h1>Room No: <?php echo $row['room_no'] ?></h1>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h4 style="background:lightgrey;padding:4px;"><b>Patient Info:</b></h4>
						<h1><?php echo $row['Name'] ?> <span style="float:right;">Visitor ID: <?php echo $row['visitor_id'] ?></span></h1>
						<div class="row">
							<div class="col-md-6"><h5><b>Gender:</b> <?php echo $row['gender'] ?></h5></div>
							<div class="col-md-6"><h5><b>Age:</b> <?php echo $row['age'] ?></h5></div>
							<div class="col-md-6"><h5><b>Contact #:</b> <?php echo $row['phone'] ?></h5></div>
						</div>
					</div>
					<div class="col-md-12">
						<h4 style="background:lightgrey;padding:4px;"><b>Doctors:</b></h4>
						<div class="row">
						<?php date_default_timezone_set("Asia/Karachi");
						$fetch_data12 = "SELECT * FROM ssh_p_indoor_doctors JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID where ssh_p_indoor_doctors.pi_id  = '".$slip."' AND (ssh_p_indoor_doctors.D_ID != 16 AND ssh_p_indoor_doctors.D_ID != 17)";
						$fetch_data12_ex = mysqli_query($con,$fetch_data12);
						foreach($fetch_data12_ex as $row1){ ?>
							<div class="col-md-6"><h1><?php echo $row1['Name'] ?></h1></div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<script>window.print();window.addEventListener("afterprint",function(){window.close();});</script>
		</body>
		<div class="footer" style="text-align:center;font-size:11px;border-top:1px dashed #000;margin-top:15px;padding-top:5px;">
			Developed by <b><a href="https://portfolio.faheemullah.site/" target="_blank" style="text-decoration:none;color:#000;">Faheem Ullah</a></b>
		</div>
		</html>
	<?php } } else { ?>
		<img src="../images/404error.png" width="100%" height="100%">
	<?php } ?>
