<?php 
if(isset($_GET['slip'])) {
    ob_start();
    session_start();
    include_once("../env/main_config.php");
    $slip = $_GET['slip']; 
    date_default_timezone_set("Asia/Karachi");
    $fetch_data = "SELECT ssh_p_reg.Name AS p_name, ssh_p_reg.Gender, ssh_p_reg.age, ssh_p_reg.phone, ssh_p_dpr.MRN, ssh_p_dpr.Paid, (SELECT COUNT(P_ID)+1 FROM ssh_p_dpr WHERE P_ID=1) AS visit, ssh_p_dpr.A_Date, ssh_dr_reg.Name AS d_name, ssh_dr_reg.D_ID AS D_ID, ssh_dr_reg.Qualification AS Qualification, ssh_dr_reg.Expertise AS Expertise FROM ssh_p_dpr LEFT JOIN ssh_p_reg ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_dr_reg ON ssh_p_dpr.D_ID = ssh_dr_reg.D_ID WHERE ssh_p_dpr.MRN = '".$slip."'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ ?>
        <!DOCTYPE html>
        <html lang="en"><head>
            <meta charset="utf-8">
            <title>Print Slip</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { font-size:14px; }
                h2,h4,h5 { margin:0; padding:2px 0; }
                .section-title { background:lightgrey; padding:5px; font-weight:bold; }
                .divider { border-bottom:1px solid black; margin:10px 0; }
            </style>
        </head>
        <body>
            <div class="container" style="max-width:800px;">
                <div class="text-center">
                    <h2><?php echo $_SESSION['com_name']." & Dental Hospital, Depalpur" ;?></h2>
                    <h5><?php echo $_SESSION['com_address'] ;?> <br><b>Contact: 0444-542324</b></h5>
                </div>
                <h4 class="section-title">Doctor</h4>
                <div class="row">
                    <div class="col-6 text-center"><h4><?php echo $row['d_name'] ?></h4></div>
                    <div class="col-6 text-center">
                        <h5><b>Date:</b> <?php echo date('Y-m-d',strtotime($row['A_Date'])) ?> &nbsp; <b>Time:</b> <?php echo date('H:i:s',strtotime($row['A_Date'])) ?></h5>
                        <?php 
                        $fetch_data2 = "SELECT COUNT(ssh_p_dpr.MRN) AS token FROM ssh_p_dpr WHERE ssh_p_dpr.D_ID = '".$row['D_ID']."' AND DATE(ssh_p_dpr.A_DATE) = '".date('Y-m-d')."'";
                        $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                        foreach($fetch_data2_ex as $row1){ ?>
                            <h4>Token: <?php echo $row1['token'] ?></h4>
                        <?php } ?>
                    </div>
                </div>
                <h4 class="section-title">Patient Info</h4>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-6"><b>Temperature(F/C):</b></div>
                    <div class="col-6"><b>B.P(mmHg):</b></div>
                    <div class="col-6"><b>Pulse(bpm):</b></div>
                    <div class="col-6"><b>Weight(kg):</b></div>
                    <div class="col-6"><b>Height(ft/inch):</b></div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-12">
                        <h5 style="float:left;"><?php echo $row['p_name'] ?></h5>
                        <h5 style="float:right;">MRN: <?php echo $row['MRN'] ?></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"><b>Gender:</b> <?php echo $row['Gender'] ?></div>
                    <div class="col-4"><b>Age:</b> <?php echo $row['age'] ?></div>
                    <div class="col-4"><b>Contact #:</b> <?php echo $row['phone'] ?></div>
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
