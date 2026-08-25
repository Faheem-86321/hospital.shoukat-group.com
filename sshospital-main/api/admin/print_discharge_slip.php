<?php 
if (isset($_GET['slip'])) {
    ob_start();
    session_start();
    include_once("../env/main_config.php");
    $slip = $_GET['slip'];
    date_default_timezone_set("Asia/Karachi");

    // Update exit date
    $update_data = "UPDATE ssh_p_indoor 
                    SET exit_date = '".date('Y-m-d')."'  
                    WHERE pi_id='".$slip."' ";
    mysqli_query($con, $update_data);

    // Fetch patient + indoor info
    $fetch_data = "SELECT * FROM ssh_p_indoor 
        JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID 
        LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID 
        LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id  
        WHERE ssh_p_indoor.pi_id = '".$slip."' ";
    $fetch_data_ex = mysqli_query($con, $fetch_data);

    foreach ($fetch_data_ex as $row) { ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Discharge Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 80mm;       /* ✅ width for thermal printer */
            margin: 0 auto;
        }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 4px 0; }
        table { width: 100%; }
        td { padding: 2px 0; vertical-align: top; }
        h3,h4 { margin: 2px 0; }
        .section { margin-top: 6px; }
        .space { height: 40px; border-bottom: 1px dashed #000; margin: 3px 0; }

        @media print {
            @page {
                size: 80mm auto;   /* ✅ force roll paper width */
                margin: 2mm;
            }
            body {
                width: 80mm;
                margin: 0;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="center">
        <img src="<?php echo "../images/".$_SESSION['com_logo']; ?>" alt="Logo" style="max-height:50px;"><br>
        <h3><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur"; ?></h3>
        <small><?php echo $_SESSION['com_address']; ?><br>Contact: 0444-542324</small>
        <div class="line"></div>
        <h4><b>DISCHARGE SLIP</b></h4>
        <div class="line"></div>
    </div>

    <table>
        <tr><td><b>Name:</b></td><td><?php echo $row['Name']; ?></td></tr>
        <tr><td><b>Phone:</b></td><td><?php echo $row['phone']; ?></td></tr>
        <tr><td><b>D.O.A:</b></td><td><?php echo $row['admit_date']; ?></td></tr>
        <tr><td><b>D.O.D:</b></td><td><?php echo $row['exit_date']; ?></td></tr>
    </table>

    <div class="section"><b>Diagnose:</b></div>
    <div class="space"></div>
    <div class="space"></div>

    <div class="section"><b>Procedure:</b></div>
    <div class="space"></div>
    <div class="space"></div>

    <div class="section"><b>Discharge Medicine:</b></div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>

    <div class="section"><b>Follow Up Instructions:</b></div>
    <div class="space"></div>
    <div class="space"></div>

    <p style="text-align:right; margin-top:20px;">Signature: __________</p>
    <div class="footer" style="text-align:center; font-size:10px; border-top:1px dashed #000; margin-top:10px; padding-top:3px;">
        Developed by <b><a href="https://portfolio.faheemullah.site/" target="_blank" style="text-decoration:none; color:#000;">Faheem Ullah</a></b>
    </div>

    <script>
        window.onload = () => {
            window.print();
            window.onafterprint = () => window.close();
        };
    </script>
</body>

</html>
<?php } } else { ?>
    <img src="../images/404error.png" width="100%" height="100%">
<?php } ?>