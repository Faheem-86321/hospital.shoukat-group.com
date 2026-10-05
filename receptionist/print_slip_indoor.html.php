<?php 
if(isset($_GET['slip'])) {
    ob_start();
    session_start();
    include_once("../env/main_config.php");
    $slip = $_GET['slip'];
    $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id WHERE ssh_p_indoor.pi_id = '".$slip."'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ ?>
        <!DOCTYPE html>
        <html lang="en"><head>
            <meta charset="utf-8">
            <title>Admission Slip</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { font-size:14px; }
                .section-title { background:lightgrey; padding:6px; font-weight:bold; margin-top:10px; }
                .divider { border-bottom:1px solid black; margin:10px 0; }
                h1,h2,h4,h5,p { margin:0; }
                .slip-container { max-width:800px; margin:auto; }
            </style>
        </head>
        <body>
            <div class="container slip-container">
                <div class="text-center mb-3">
                    <h2><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur" ;?></h2>
                    <p><?php echo $_SESSION['com_address'] ;?></p>
                </div>
                <h2 class="text-center mb-2">Admission Slip</h2>
                <h4 class="section-title">Case Info</h4>
                <div class="row mb-2">
                    <div class="col-6 text-center"><h4><?php echo $row['Title'] ?></h4></div>
                    <div class="col-6 text-center">
                        <?php date_default_timezone_set('Asia/Karachi'); ?>

<h6>
    <b>Date:</b> <?php echo date('d-m-Y', strtotime($row['admit_date'])); ?>
    &nbsp;
    <b>Time:</b> <?php echo date('h:i:s A'); ?>
</h6>
                        <h5>Room No: <?php echo $row['room_no'] ?></h5>
                    </div>
                </div>
                <h4 class="section-title">Patient Info</h4>
                <div class="mb-2">
                    <h5><?php echo $row['Name'] ?> <span style="float:right;">Visitor ID: <?php echo $row['visitor_id'] ?></span></h5>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><b>Gender:</b> <?php echo $row['gender'] ?></div>
                    <div class="col-4"><b>Age:</b> <?php echo $row['age'] ?></div>
                    <div class="col-4"><b>Contact #:</b> <?php echo $row['phone'] ?></div>
                </div>
                <h4 class="section-title">Doctors</h4>
                <div class="row mb-2">
                    <?php
                    date_default_timezone_set("Asia/Karachi");
                    $fetch_data12 = "SELECT * FROM ssh_p_indoor_doctors JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID WHERE ssh_p_indoor_doctors.pi_id = '".$slip."' AND (ssh_p_indoor_doctors.D_ID != 16 AND ssh_p_indoor_doctors.D_ID != 17)";
                    $fetch_data12_ex = mysqli_query($con,$fetch_data12);
                    foreach($fetch_data12_ex as $row1){ ?>
                        <div class="col-6"><h5><?php echo $row1['Name'] ?></h5></div>
                    <?php } ?>
                </div>
            </div>
            <script>window.onload=()=>{window.print();window.onafterprint=()=>window.close();};</script>
        </body>
        <div class="footer" style="text-align:center;font-size:11px;border-top:1px dashed #000;margin-top:15px;padding-top:5px;">
            Developed by <b><a href="https://portfolio.faheemullah.site/" target="_blank" style="text-decoration:none;color:#000;">Faheem Ullah</a></b>
        </div>
        </html>
<?php } } else { ?>
    <img src="../images/404error.png" width="100%" height="100%">
<?php } ?>
