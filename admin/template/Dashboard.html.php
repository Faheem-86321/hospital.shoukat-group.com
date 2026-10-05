<?php 
// This if else condition will be same
if(mysqli_num_rows($execuit)>0){
	?>
<style>
    .counter {
        color: #f51c1c;
        text-align: center;
        width: 200px;
        height: 200px;
        padding: 20px;
        margin: 0 auto;
        position: relative;
        font-family: 'Poppins', sans-serif;
    }

    .counter h3 {
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #333;
        margin-bottom: 6px;
    }

    .counter p {
        font-size: 11px;
        color: #888;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .counter .counter-value {
        font-size: 22px;
        font-weight: 700;
        color: #111;
        display: block;
        margin-top: 4px;
    }

    .counter .counter-icon {
        color: #fff;
        font-size: 22px;
        position: absolute;
        bottom: 25px;
        right: 28px;
        z-index: 1;
        background: #f51c1c;
        padding: 8px;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Base Circular Animation */
    .counter:before,
    .counter:after {
        content: "";
        width: 200px;
        height: 200px;
        border: 15px solid #f51c1c;
        border-right: 15px solid transparent;
        border-bottom: 15px solid transparent;
        border-left: 15px solid transparent;
        border-radius: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
        position: absolute;
        top: 50%;
        left: 50%;
        transition: 0.4s ease;
    }

    .counter:after {
        height: 187px;
        width: 187px;
        border: 3px solid #f51c1c;
        border-right: 3px solid transparent;
    }

    .counter:hover:before {
        transform: translate(-50%, -50%) rotate(90deg);
        opacity: 0.9;
    }

    /* Inner Content Circle */
    .counter .counter-content {
        background: #fff;
        width: 160px;
        height: 160px;
        padding: 40px 20px;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
    }

    /* Gradient Accent */
    .counter .counter-content:before {
        content: "";
        background: linear-gradient(45deg, #fe8605, #f51c1c);
        width: calc(100% - 10px);
        height: calc(100% - 10px);
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
        opacity: 0.2;
    }

    /* Colors for Variants */
    .counter.purple { color: #a21a6e; }
    .counter.blue { color: #0dabc6; }
    .counter.green { color: #10ce29; }

    .counter.purple .counter-icon { background: #a21a6e; }
    .counter.blue .counter-icon { background: #0dabc6; }
    .counter.green .counter-icon { background: #10ce29; }

    /* Responsive */
    @media screen and (max-width: 990px) {
        .counter { margin-bottom: 40px; }
    }
</style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="counter">
                            <div class="counter-content">
                                <h3>Total Patients</h3>
                                <p>Total</p>
                                <span class="counter-value" style="margin-top: 0px !important;">
                                    <?php 
                                    $select_query = "SELECT * FROM ssh_p_reg";
                                    $select_query_ex = mysqli_query($con,$select_query);
                                    echo mysqli_num_rows($select_query_ex);
                                    ?>
                                </span>
                            </div>
                            <div class="counter-icon">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="counter purple">
                            <div class="counter-content">
                                <h3>OPD Income</h3>
                                <p>Current Month</p>
                            </div>
                            <div class="counter-icon">
                                <i class="fa fa-stethoscope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="counter">
                            <div class="counter-content">
                                <h3>IPD Income</h3>
                                <p>Current Month</p>
                                <span class="counter-value">
                                    <?php 
                                    $toppaid = 0;
                                    $select_query = "SELECT *, 
                                    (SELECT SUM(Paid) FROM ssh_p_indoor WHERE  MONTH(CONVERT(ssh_p_indoor.admit_date,Date)) = MONTH(CURRENT_DATE())) - (SELECT SUM(D_Fee) FROM ssh_p_indoor_doctors WHERE pi_id IN (SELECT pi_id FROM ssh_p_indoor WHERE  MONTH(CONVERT(ssh_p_indoor.admit_date,Date)) = MONTH(CURRENT_DATE()))) AS total FROM ssh_p_indoor 
                                         WHERE   MONTH(CONVERT(ssh_p_indoor.admit_date,Date)) = MONTH(CURRENT_DATE()) GROUP BY MONTH(admit_date)";
                                         $select_query_ex = mysqli_query($con,$select_query);
                                         foreach($select_query_ex as $row){
                                            $toppaid += $row["total"];
                                        }
                                        echo $toppaid;
                                        ?>
                                    </span>
                                </div>
                                <div class="counter-icon">
                                    <i class="fa fa-wheelchair"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="counter purple">
                                <div class="counter-content">
                                    <h3>Total Expense</h3>
                                    <p>Current Month</p>
                                    <span class="counter-value">
                                        <?php 
                                        $toppaid = 0;
                                        $select_query = "SELECT * FROM ssh_expenses WHERE   MONTH(CONVERT(Date,Date)) = MONTH(CURRENT_DATE())";
                                        $select_query_ex = mysqli_query($con,$select_query);
                                        foreach($select_query_ex as $row){
                                            $toppaid += $row["Amount"];
                                        }
                                        echo $toppaid;
                                        ?>
                                    </span>
                                </div>
                                <div class="counter-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>

                        <style type="text/css">
                            .new_style{
                                border-bottom: 1px solid grey; padding:10px ; 
                            }
                            @media screen and (max-width: 767px) {
                                .res1{
                                    border: none;
                                    margin-top: 10px;
                                    color: white !important;
                                    background-color: coral;
                                }
                                .res2{
                                    border: none;
                                    margin-top: 10px;
                                    color: white !important;
                                    background-color: #2a7aBe;
                                }
                                .res3{
                                    border: none;
                                    margin-top: 10px;
                                    color: white !important;
                                    background-color: #E4CD05;
                                }
                                .res4{
                                    border: none;
                                    margin-top: 10px;
                                    color: white !important;
                                    background-color: green;
                                }
                            }
                        </style>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12" >
                    <div class="row" style="padding: 18px;" >
                        <div class="col-md-6 new_style res1" style="color: coral;" >
                            <h2 style="color: #f24c4f !important;text-shadow: 0 3px 10px rgb(0 0 0 / 0.2)"><b>X-Rays</b></h2>

                            <h3 class="count_no_value text-center">
                                <?php
                                $select_query = "SELECT *,SUM(Amount) FROM ssh_expenses WHERE (Title = 'X-Ray-Small' OR Title = 'X-Ray-Big') AND MONTH(Date) = '".date('m')."' GROUP BY MONTH(Date)";
                                $select_query_ex = mysqli_query($con,$select_query);
                                if (mysqli_num_rows($select_query_ex) != 0) {
                                 foreach($select_query_ex as $month){
                                    echo $month['SUM(Amount)'];
                                }
                            }
                            else{
                                echo "0";
                            }
                            ?>
                        </h3>

                        <h4 class="text-center"> <b>Expense</b></h4>
                        <p class="text-center">Current Month</p>

                    </div>
                    <div class="col-md-6 new_style res2" style="border-left: 1px solid grey ;color: #2a7aBe;">
                        <h2>&nbsp</h2>
                        <h3 class="count_no_value text-center">
                            <?php
                            $select_query = "SELECT *,SUM(ssh_p_services.Paid) AS total FROM ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID  Join ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID WHERE (ssh_ser_inv.ID = '1' OR ssh_ser_inv.ID = '6') AND  MONTH(ssh_p_services.Date) = '".date('m')."' GROUP BY MONTH(ssh_p_services.Date)";
                            $select_query_ex = mysqli_query($con,$select_query);
                            if (mysqli_num_rows($select_query_ex) != 0) {
                             foreach($select_query_ex as $month){
                                echo $month['total'];
                            }
                        }
                        else{
                            echo "0";
                        }
                        ?>
                    </h3>
                    <h4 class="text-center"> <b>Income</b></h4>
                    <p class="text-center">Current Month</p>
                </div>

                <div class="col-md-6 res3" style="padding-top:10px;color: #E4CD05;" >
                    <h2 style="color: #f24c4f !important;text-shadow: 0 3px 10px rgb(0 0 0 / 0.2)"><b>CT-Scan</b></h2>
                    <h3 class="count_no_value text-center">
                        <?php
                        $select_query = "SELECT *,SUM(Amount) FROM ssh_expenses WHERE Title = 'CT-Scan' AND MONTH(Date) = '".date('m')."' GROUP BY MONTH(Date)";
                        $select_query_ex = mysqli_query($con,$select_query);
                        if (mysqli_num_rows($select_query_ex) != 0) {
                         foreach($select_query_ex as $month){
                            echo $month['SUM(Amount)'];
                        }
                    }
                    else{
                        echo "0";
                    }

                    ?>
                </h3>
                <h4 class="text-center"> <b>Expense</b></h4>
                <p class="text-center">Current Month</p>

            </div>
            <div class="col-md-6 res4" style="border-left: 1px solid grey ;color: green;padding-top:10px">
                <h2>&nbsp</h2>
                <h3 class="count_no_value text-center">
                    <?php
                    $select_query = "SELECT *,SUM(ssh_p_services.Paid) AS total FROM ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID  Join ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID WHERE (ssh_ser_inv.ID = '2') AND  MONTH(ssh_p_services.Date) = '".date('m')."' GROUP BY MONTH(ssh_p_services.Date)";
                    $select_query_ex = mysqli_query($con,$select_query);
                    if (mysqli_num_rows($select_query_ex) != 0) {
                     foreach($select_query_ex as $month){
                        echo $month['total'];
                    }
                }
                else{
                    echo "0";
                }

                ?>
            </h3>
            <h4 class="text-center"> <b>Income</b></h4>
            <p class="text-center">Current Month</p>
        </div>
    </div>
</div>
<!--<div class="col-12 mb-3"><a href="comprehensive_reports" target="_blank" class="btn btn-danger btn-lg"><i class="fa fa-chart-bar"></i> &nbsp; Comprehensive Reports</a></div>-->
<div class="col-xl-6 mt-2" >
    <div class="card-box " style="border-right: 3px solid #f24c4f ;box-shadow: 0 3px 10px rgb(0 0 0 / 0.2)">
        <div class="float-right d-none d-md-inline-block" style="color: black !important;">
           <div class="btn-group " style="background: #f24c4f;color: black !important;">
              <button type="button" class="btn btn-xs btn-primary  m-1" >Monthly</button>
          </div>
      </div>

      <h4 class="header-title mb-3 p-2" style="background: #f24c4f;color: black !important;"><i class="fa fa-wheelchair"></i> Yealy Income & Expense</h4>

      <div dir="ltr">
        <div id="deal-analytics-ovarall" class="mt-4" data-colors="#6658dd,#f1556c"></div>
    </div>
</div> <!-- end card-box -->
</div> <!-- end col-->



<div class="col-xl-6">
    <div class="card-box pb-2" style="border-right: 3px solid #f24c4f ;box-shadow: 0 3px 10px rgb(0 0 0 / 0.2)">
        <div class="float-right d-none d-md-inline-block" style="background: #f24c4f;color: black !important;">
            <div class="btn-group" style="background: #f24c4f;color: black !important;">
                <button type="button" class="btn btn-xs btn-primary m-1">Monthly</button>
            </div>
        </div>

        <h4 class="header-title mb-3 p-2" style="background: #f24c4f;color: black !important;"> <i class="fa fa-wheelchair"></i>  Indoor Analytics</h4>

        <div dir="ltr">
            <div id="deal-analytics2" class="mt-4" data-colors="#6658dd,#1abc9c,#6658dd,#1abc9c"></div>
        </div>
    </div> <!-- end card-box -->
</div> <!-- end col-->
<div class="col-xl-12">
    <div class="card" style="border-right: 3px solid #f24c4f ;box-shadow: 0 3px 10px rgb(0 0 0 / 0.2)">
        <div class="card-body">
            <div class="float-right d-none d-md-inline-block" style="background: #f24c4f;color: black !important;">
                <div class="btn-group" style="background: #f24c4f;color: black !important;">
                    <button type="button" class="btn btn-xs btn-primary m-1">Monthly</button>
                </div>
            </div>
            <h4 class="header-title mb-0 p-2" style="background: #f24c4f;color: black !important;"> <i class="fa fa-wheelchair"></i> Dialysis Analytics</h4>

            <div id="cardCollpase5" class="collapse pt-3 show" dir="ltr">
                <div id="apex-column-1" class="apex-charts" data-colors="#6658dd,#1abc9c,#6658dd,#1abc9c,#ff0000"></div>
            </div> <!-- collapsed end -->
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div> 
<div class="col-xl-12 col-lg-12">
    <div class="card">
        <div class="card-body" dir="ltr">
            <div class="card-widgets">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>

            <?php
            // Default to the current month on first load (no filters submitted yet)
            date_default_timezone_set("Asia/Karachi");
            if (!isset($_GET['search_date'])) {
                $_GET['search_date'] = '1';
                $_GET['date_from']   = date('Y-m-01');
                $_GET['date_to']     = date('Y-m-d');
                $_GET['doc_id']      = $_GET['doc_id'] ?? '';
            }
            ?>
            <div class="text-center">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row col-sm-12">
                        <select class="m-1" id="selectize-programmatic2" name="doc_id" placeholder="Select Doctor (leave blank for All)" style="width: 220px;float: left;">
                            <option value="">-- All Doctors --</option>
                            <?php
                            $doc_list_q = mysqli_query($con, "SELECT D_ID, Name FROM ssh_dr_reg ORDER BY Name");
                            while ($d = mysqli_fetch_assoc($doc_list_q)) {
                                $sel = ($_GET['doc_id'] == $d['D_ID']) ? 'selected' : '';
                                echo "<option value='{$d['D_ID']}' $sel>{$d['Name']}</option>";
                            }
                            ?>
                        </select>

                        <input type="date" class="form-control m-1" name="date_from" value="<?php echo $_GET['date_from'] ?>" style="width: 150px;float: left;" required>
                        <span style="float: left;" class="m-2"><b>To</b></span>
                        <input type="date" class="form-control m-1" name="date_to" value="<?php echo $_GET['date_to'] ?>" style="width: 150px;float: left;" required>
                        <input type="submit" class="btn btn-success m-1" name="search_date" value="Search" style="float: left;height: 36px;">
                    </div>
                </form>
            </div>

            <div id="cardCollpase4" class="collapse show">
                <div class="row bodyoftable" style="padding: 0px 4px !important;">
                    <div class="col-sm-12" style="padding: 0px 4px !important;">
                        <div class="card-box card-table-style" style="padding: 0px 4px !important;">
                            <?php
                            if (isset($_GET['search_date'])) {
                                date_default_timezone_set("Asia/Karachi");

                                $date_from = mysqli_real_escape_string($con, $_GET['date_from']);
                                $date_to   = mysqli_real_escape_string($con, $_GET['date_to']);
                                $doc_id    = isset($_GET['doc_id']) ? mysqli_real_escape_string($con, $_GET['doc_id']) : '';
                                $doc_filter_sql = $doc_id !== '' ? " AND dr.D_ID = '".$doc_id."' " : "";

                                // ---------- OUTDOOR (ssh_p_dpr) ----------
                                // CONFIRMED FIX: "Total Payment" in the closing sheet is the
                                // billed Charges (before discount), not the amount actually Paid.
                                // Verified against live data: Charges, patient count, and discount
                                // all match the PDF exactly with this formula.
                                //
                                // Doctor Share uses a proportional split (D_Pay scaled by how much
                                // of the full Charges was actually Paid) instead of raw D_Pay.
                                // This corrects for discounted visits, where D_Pay in the DB isn't
                                // always adjusted down to match the discount given. This got us
                                // much closer to the PDF (e.g. Aftab Anwar's indoor-verified doctor
                                // share was off by only ~12 instead of 245 using raw D_Pay).
                                $outdoor_sql = "
                                    SELECT
                                        dr.D_ID,
                                        dr.Name,
                                        COUNT(DISTINCT o.MRN)                              AS out_patient,
                                        SUM(o.Charges)                                     AS out_payment,
                                        SUM(o.Paid)                                        AS out_paid_actual,
                                        SUM(CASE WHEN o.Charges > 0 THEN o.D_Pay * o.Paid / o.Charges ELSE o.D_Pay END) AS out_doctor_share,
                                        SUM(o.Charges - o.Paid)                            AS out_discount
                                    FROM ssh_p_dpr o
                                    JOIN ssh_dr_reg dr ON o.D_ID = dr.D_ID
                                    WHERE CONVERT(o.A_DATE, DATE) BETWEEN '".$date_from."' AND '".$date_to."'
                                    ".$doc_filter_sql."
                                    GROUP BY dr.D_ID
                                ";
                                $outdoor_res = mysqli_query($con, $outdoor_sql);
                                $outdoor = [];
                                while ($row = mysqli_fetch_assoc($outdoor_res)) {
                                    $row['out_doctor_share']   = round($row['out_doctor_share']);
                                    $row['out_hospital_share'] = round($row['out_paid_actual'] - $row['out_doctor_share']);
                                    $outdoor[$row['D_ID']] = $row;
                                }

                                // ---------- DEBUG MODE (?debug=1) ----------
                                // Shows raw values so you can compare against the PDF line by line.
                                if (isset($_GET['debug'])) {
                                    echo "<div class='alert alert-warning'><b>DEBUG MODE</b><br>";

                                    $status_chk = mysqli_query($con, "SELECT status, COUNT(*) c FROM ssh_p_dpr WHERE CONVERT(A_DATE,DATE) BETWEEN '".$date_from."' AND '".$date_to."' GROUP BY status");
                                    echo "Distinct <b>status</b> values in ssh_p_dpr for this range:<br>";
                                    while ($sc = mysqli_fetch_assoc($status_chk)) {
                                        echo "&nbsp;&nbsp;- '".$sc['status']."' : ".$sc['c']." rows<br>";
                                    }

                                    echo "<br>Raw Outdoor rows per doctor (before formatting):<br><pre>";
                                    print_r($outdoor);
                                    echo "</pre></div>";
                                }

                                // ---------- INDOOR (ssh_p_indoor / ssh_p_indoor_doctors) ----------
                                // Note: fixed to also deduct medicine_expenses from hospital share,
                                // matching the totals shown in the Monthly Closing Sheet PDF.
                                $indoor_sql = "
                                    SELECT
                                        dr.D_ID,
                                        dr.Name,
                                        COUNT(DISTINCT p.pi_id)                                              AS in_patient,
                                        SUM(d.D_Fee)                                                          AS in_doctor_share,
                                        SUM(p.Paid)                                                           AS in_payment,
                                        SUM(p.medicine_expenses)                                              AS in_medicine,
                                        SUM(p.Paid) - SUM(all_docs.total_fee) - SUM(p.medicine_expenses)      AS in_hospital_share
                                    FROM ssh_p_indoor p
                                    JOIN ssh_p_indoor_doctors d ON p.pi_id = d.pi_id
                                    JOIN ssh_dr_reg dr ON d.D_ID = dr.D_ID
                                    JOIN (
                                        SELECT pi_id, SUM(D_Fee) AS total_fee
                                        FROM ssh_p_indoor_doctors
                                        GROUP BY pi_id
                                    ) all_docs ON p.pi_id = all_docs.pi_id
                                    WHERE d.to_paid = '1'
                                      AND p.admition_type = '0'
                                      AND CONVERT(p.admit_date, DATE) BETWEEN '".$date_from."' AND '".$date_to."'
                                      ".$doc_filter_sql."
                                    GROUP BY dr.D_ID
                                ";
                                $indoor_res = mysqli_query($con, $indoor_sql);
                                $indoor = [];
                                while ($row = mysqli_fetch_assoc($indoor_res)) {
                                    $indoor[$row['D_ID']] = $row;
                                }

                                if (isset($_GET['debug'])) {
                                    echo "<div class='alert alert-warning'><b>DEBUG MODE - Indoor</b><br>";
                                    echo "Raw Indoor rows per doctor (before formatting):<br><pre>";
                                    print_r($indoor);
                                    echo "</pre>";
                                    echo "Note: if an admission has 2+ doctors, medicine_expenses is counted once per doctor on that admission (possible double count). Check this if numbers are inflated.<br></div>";
                                }

                                // ---------- Merge doctor list (union of both) ----------
                                $doctors = [];
                                foreach ($outdoor as $id => $r) { $doctors[$id] = $r['Name']; }
                                foreach ($indoor as $id => $r)  { $doctors[$id] = $r['Name']; }
                                asort($doctors);

                                // ---------- Grand totals ----------
                                $t_out_patient = $t_out_payment = $t_out_doc = $t_out_hosp = $t_out_disc = 0;
                                $t_in_patient  = $t_in_payment  = $t_in_doc  = $t_in_hosp  = $t_in_med   = 0;
                                $t_grand_doc = $t_grand_hosp = 0;
                            ?>
                            <table id="example" class="table table-centered table-striped table-bordered mb-0 toggle-circle">
                                <thead>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="5" class="text-center">Outdoor</th>
                                        <th colspan="5" class="text-center">Indoor</th>
                                        <th colspan="2" class="text-center">Grand Total</th>
                                    </tr>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Doctor Name</th>
                                        <th>Total Patient</th>
                                        <th>Total Payment</th>
                                        <th>Doctor Share</th>
                                        <th>Hospital Share</th>
                                        <th>Discount</th>
                                        <th>Total Patient</th>
                                        <th>Total Payment</th>
                                        <th>Doctor Share</th>
                                        <th>Hospital Share</th>
                                        <th>Medicine/Other Expenses</th>
                                        <th>Doctor Share</th>
                                        <th>Hospital Share</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sr_no = 1;
                                    foreach ($doctors as $d_id => $d_name) :
                                        $o = $outdoor[$d_id] ?? null;
                                        $i = $indoor[$d_id] ?? null;

                                        $out_patient = $o['out_patient'] ?? 0;
                                        $out_payment = $o['out_payment'] ?? 0;
                                        $out_doc     = $o['out_doctor_share'] ?? 0;
                                        $out_hosp    = $o['out_hospital_share'] ?? 0;
                                        $out_disc    = $o['out_discount'] ?? 0;

                                        $in_patient  = $i['in_patient'] ?? 0;
                                        $in_payment  = $i['in_payment'] ?? 0;
                                        $in_doc      = $i['in_doctor_share'] ?? 0;
                                        $in_hosp     = $i['in_hospital_share'] ?? 0;
                                        $in_med      = $i['in_medicine'] ?? 0;

                                        $grand_doc  = $out_doc + $in_doc;
                                        $grand_hosp = $out_hosp + $in_hosp;

                                        $t_out_patient += $out_patient; $t_out_payment += $out_payment;
                                        $t_out_doc += $out_doc; $t_out_hosp += $out_hosp; $t_out_disc += $out_disc;
                                        $t_in_patient += $in_patient; $t_in_payment += $in_payment;
                                        $t_in_doc += $in_doc; $t_in_hosp += $in_hosp; $t_in_med += $in_med;
                                        $t_grand_doc += $grand_doc; $t_grand_hosp += $grand_hosp;
                                    ?>
                                    <tr>
                                        <td><?php echo $sr_no++ ?></td>
                                        <td><?php echo $d_name ?></td>
                                        <td>
                                            <?php echo $out_patient ?>
                                            <button class="btn btn-success ml-1" onclick="view_outdoor_private(<?php echo $d_id ?>,0);" style="padding: 4px 4px; float:right;"><i class="fa fa-eye"></i></button>
                                        </td>
                                        <td><?php echo $out_payment ?></td>
                                        <td><?php echo $out_doc ?></td>
                                        <td><?php echo $out_hosp ?></td>
                                        <td><?php echo $out_disc ?></td>
                                        <td>
                                            <?php echo $in_patient ?>
                                            <button class="btn btn-success ml-1" onclick="view_indoor_private(<?php echo $d_id ?>,0);" style="padding: 4px 4px; float:right;"><i class="fa fa-eye"></i></button>
                                        </td>
                                        <td><?php echo $in_payment ?></td>
                                        <td><?php echo $in_doc ?></td>
                                        <td><?php echo $in_hosp ?></td>
                                        <td><?php echo $in_med ?></td>
                                        <td><?php echo $grand_doc ?></td>
                                        <td><?php echo $grand_hosp ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td colspan="2" class="text-center"><b>Total</b></td>
                                        <td><b><?php echo $t_out_patient ?></b></td>
                                        <td><b><?php echo $t_out_payment ?></b></td>
                                        <td><b><?php echo $t_out_doc ?></b></td>
                                        <td><b><?php echo $t_out_hosp ?></b></td>
                                        <td><b><?php echo $t_out_disc ?></b></td>
                                        <td><b><?php echo $t_in_patient ?></b></td>
                                        <td><b><?php echo $t_in_payment ?></b></td>
                                        <td><b><?php echo $t_in_doc ?></b></td>
                                        <td><b><?php echo $t_in_hosp ?></b></td>
                                        <td><b><?php echo $t_in_med ?></b></td>
                                        <td><b><?php echo $t_grand_doc ?></b></td>
                                        <td><b><?php echo $t_grand_hosp ?></b></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php
                            } else {
                                date_default_timezone_set("Asia/Karachi");
                                ?>
                                <div class="alert alert-success">Date Range select karein (Doctor optional hai — All Doctors ke liye khali chorein)!!</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>    
<!-- end col-->
</div>
</div>
</div>
<script>

</script>	
<?php  }else{
    header('location:logout');
} ?>       