<?php 
if (isset($_GET['slip'])) {
    ob_start();
    session_start();
    include_once("../env/main_config.php");
    $slip = $_GET['slip'];
    $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID WHERE ssh_p_dialysis.pd_id = '".$slip."'";
    $fetch_data_ex = mysqli_query($con, $fetch_data);
    foreach ($fetch_data_ex as $row) { ?>
        <html><head>
            <meta charset="utf-8">
            <title>Print Slip</title>
            <link rel="stylesheet" href="../assets/header/bootstrap.min.css">
            <style>
                @media print {
                    body { font-size:14px; margin:0; padding:0; }
                    .container-fluid { width:100% !important; padding:0 20px !important; }
                    .token { font-size:28px; font-weight:bold; margin-top:10px; }
                }
            </style>
        </head>
        <body>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur"; ?></h1>
                        <p><?php echo $_SESSION['com_address']; ?></p>
                    </div>
                    <div class="col-md-12">
                        <h1 class="text-center">Dialysis Slip</h1>
                        <h4 style="background:lightgrey;padding:10px;"><b>Case Info:</b></h4>
                        <div class="row">
                            <div class="col-md-6 text-center"><h2>Dialysis</h2></div>
                            <div class="col-md-6 text-center">
                                <h5><b>Date:</b> <?php echo $row['date']; ?> &nbsp; <b>Time:</b> <?php echo date('H:i:s', strtotime($row['date'])); ?></h5>
                                <?php
                                $fetch_data2 = "SELECT * FROM ssh_p_dialysis WHERE Date = '".date('Y-m-d')."'";
                                $fetch_data2_ex = mysqli_query($con, $fetch_data2); ?>
                                <div class="token">Token: <?php echo mysqli_num_rows($fetch_data2_ex); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h4 style="background:lightgrey;padding:10px;"><b>Patient Info:</b></h4>
                        <h2><?php echo $row['Name']; ?> <span style="float:right;">Visitor ID: <?php echo $row['visitor_id']; ?></span></h2>
                        <div class="row">
                            <div class="col-md-6"><h5><b>Gender:</b> <?php echo $row['gender']; ?></h5></div>
                            <div class="col-md-6"><h5><b>Age:</b> <?php echo $row['age']; ?></h5></div>
                            <div class="col-md-6"><h5><b>Contact #:</b> <?php echo $row['phone']; ?></h5></div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top:20px;">
                        <h4 style="background:lightgrey;padding:10px;"><b>Total Payable:</b> <b style="float:right;"><?php echo $row['Paid']; ?></b></h4>
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
