<?php 
if(isset($_GET['slip'])) {
    ob_start();
    session_start();
    include_once("../env/main_config.php");
    $slip = $_GET['slip'];
    $fetch_data = "SELECT ssh_p_reg.Name AS patient, ssh_p_services.ser_p_id AS MRN, ssh_p_reg.age AS Age, ssh_p_reg.phone AS Phone, ssh_p_reg.gender AS Gender, ssh_ser_cat.Name AS service, ssh_ser_cat.ser_id AS service_id, ssh_p_services.Paid AS Paid, ssh_p_services.Date AS date FROM ssh_p_services LEFT JOIN ssh_p_reg ON ssh_p_services.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID WHERE ssh_p_services.ser_p_id = '".$slip."'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ ?>
        <!DOCTYPE html>
        <html lang="en"><head>
            <meta charset="utf-8">
            <title>Service Slip</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { font-size:14px; }
                .section-title { background:lightgrey; padding:8px; font-weight:bold; }
                .divider { border-bottom:1px solid black; margin:10px 0; }
                h1,h4,h5,p { margin:0; }
                .slip-container { max-width:800px; margin:auto; }
            </style>
        </head>
        <body>
            <div class="container slip-container">
                <div class="text-center mb-3">
                    <h2><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur" ;?></h2>
                    <p><?php echo $_SESSION['com_address'] ;?></p>
                </div>
                <h4 class="section-title">Service Info</h4>
                <div class="row mb-2">
                    <div class="col-6 text-center"><h3><?php echo $row['service'] ?></h3></div>
                    <div class="col-6 text-center">
                        <h6><b>Date:</b> <?php echo $row['date'] ?> &nbsp; <b>Time:</b> <?php echo date('H:i:s', strtotime($row['date'])) ?></h6>
                        <?php
                        date_default_timezone_set("Asia/Karachi");
                        $fetch_data2 = "SELECT * FROM ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID WHERE DATE(ssh_p_services.DATE) = '".date('Y-m-d')."' AND ssh_ser_cat.ser_id = '".$row['service_id']."' AND ssh_ser_inv.ID = '".$row['service_id']."'";
                        $fetch_data2_ex = mysqli_query($con,$fetch_data2); ?>
                        <h4>Token: <?php echo mysqli_num_rows($fetch_data2_ex) ?></h4>
                    </div>
                </div>
                <h4 class="section-title">Patient Info</h4>
                <div class="mb-2">
                    <h5><?php echo $row['patient'] ?> <span style="float:right;">MRN: <?php echo $row['MRN'] ?></span></h5>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><b>Gender:</b> <?php echo $row['Gender'] ?></div>
                    <div class="col-4"><b>Age:</b> <?php echo $row['Age'] ?></div>
                    <div class="col-4"><b>Contact #:</b> <?php echo $row['Phone'] ?></div>
                </div>
                <div class="divider"></div>
                <div class="row mb-2">
                    <div class="col-4"><b>Temperature(F/C):</b></div>
                    <div class="col-4"><b>B.P(mmHg):</b></div>
                    <div class="col-4"><b>Weight(kg):</b></div>
                </div>
                <div class="divider"></div>
                <h4 class="section-title">Total Payable <span style="float:right;"><?php echo $row['Paid'] ?></span></h4>
                <p class="text-center">Verbal Consent obtained</p>
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
