<?php 
if(isset($_GET['slip'])) {
    ob_start();
    session_start();
    include_once("../env/main_config.php");
    $slip = $_GET['slip'];
    $fetch_data = "SELECT * FROM ssh_p_indoor 
        JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID 
        LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID 
        LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id  
        WHERE ssh_p_indoor.pi_id  = '".$slip."' ";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Discharge Slip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 14px; }
        h2,h4,h5 { margin: 0; padding: 2px 0; }
        .section-title { background: #f1f1f1; padding: 6px; font-weight: bold; margin-top: 15px; }
        .divider { border-bottom: 1px solid #000; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 900px;">
        <div class="text-center mb-3">
            <h2><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur"; ?></h2>
            <h6><?php echo $_SESSION['com_address']; ?><br><b>Contact: 0444-542324</b></h6>
            <h3 class="mt-2"><b>DISCHARGE BILL</b></h3>
        </div>

        <!-- Case Info -->
        <h4 class="section-title">Case Info</h4>
        <div class="row">
            <div class="col-6"><b>Case:</b> <?php echo $row['Title'] ?? '-'; ?></div>
            <div class="col-6 text-end"><b>Room No:</b> <?php echo $row['room_no'] ?? '-'; ?></div>
        </div>
        <div class="row mt-1">
            <div class="col-6"><b>Date of Admit:</b> <?php echo $row['admit_date']; ?></div>
            <div class="col-6 text-end"><b>Date of Discharge:</b> <?php echo $row['exit_date'] ?? '-'; ?></div>
        </div>

        <!-- Patient Info -->
        <h4 class="section-title">Patient Info</h4>
        <div class="divider"></div>
        <div class="row">
            <div class="col-12">
                <h5 style="float:left;"><?php echo $row['Name']; ?></h5>
                <h5 style="float:right;">Visitor ID: <?php echo $row['visitor_id']; ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-4"><b>Age:</b> <?php echo $row['age']; ?></div>
            <div class="col-4"><b>Gender:</b> <?php echo $row['gender']; ?></div>
            <div class="col-4"><b>Contact:</b> <?php echo $row['phone']; ?></div>
        </div>
        <div class="row mt-2">
            <div class="col-12"><b>Total Bill:</b> <span class="float-end"><?php echo $row['Paid']; ?></span></div>
        </div>

        <!-- Doctors -->
        <h4 class="section-title">Doctors</h4>
        <div class="row">
        <?php  
            date_default_timezone_set("Asia/Karachi");
            $fetch_data12 = "SELECT * FROM ssh_p_indoor_doctors 
                JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID 
                WHERE ssh_p_indoor_doctors.pi_id  = '".$slip."' 
                AND (ssh_p_indoor_doctors.D_ID != 16 AND ssh_p_indoor_doctors.D_ID != 17)";
            $fetch_data12_ex = mysqli_query($con,$fetch_data12);
            foreach($fetch_data12_ex as $row1){ ?>
                <div class="col-6 mb-2">
                    <h5><?php echo $row1['Name']; ?></h5>
                </div>
        <?php } ?>
        </div>
    </div>

    <script>
        window.onload = () => {
            window.print();
            window.onafterprint = () => window.close();
        };
    </script>
</body>
<div class="footer" style="text-align:center; font-size:11px; border-top:1px dashed #000; margin-top:15px; padding-top:5px;">
    Developed by <b><a href="https://portfolio.faheemullah.site/" target="_blank" style="text-decoration:none; color:#000;">Faheem Ullah</a></b>
</div
</html>
<?php } } else { ?>
    <img src="../images/404error.png" width="100%" height="100%">
<?php } ?>
