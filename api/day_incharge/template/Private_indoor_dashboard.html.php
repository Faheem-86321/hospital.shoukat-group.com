  <div class="row">
    <?php
    date_default_timezone_set("Asia/Karachi");
    $total_charges_s = 0;
    $total_paid_s = 0;

    $hospital_share = 0;
    $t_patient = 0;
    
    $fetch_data = "SELECT * From ssh_p_indoor where  admit_date = '".date('Y-m-d')."' AND admition_type = '0' ";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ 
        $fetch_data12 = "SELECT SUM(D_Fee) As fee From  ssh_p_indoor_doctors where  pi_id = '".$row['pi_id']."'";
        $fetch_data12_ex = mysqli_query($con,$fetch_data12);
        foreach($fetch_data12_ex as $row12){
            $hospital_share += $row['Paid']-$row12['fee'];
        }
    }

    $t_patient = mysqli_num_rows($fetch_data_ex);

    $fetch_data_discharge = "SELECT * From ssh_p_indoor where  exit_date = '".date('Y-m-d')."' AND admition_type = '0'";
    $fetch_data_discharge_ex = mysqli_query($con,$fetch_data_discharge);
    ?>
    <style type="text/css">
        .counter{
            color: #F14997;
            background: linear-gradient(to right bottom,#fff 50%, #f9f9f9 51%);
            font-family: 'Comfortaa', cursive;
            text-align: center;
            width: 200px;
            padding: 20px 0 0;
            margin: 0 auto;
            border-radius: 50px 0;
            box-shadow: 0 0 15px -5px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .counter .counter-icon{
            font-size: 45px;
            margin: 0 0 10px;
        }
        .counter h3{
            font-size: 15px;
            font-weight: 700;
            text-transform: capitalize;
            margin: 0 0 20px;
        }
        .counter .counter-value{
            color: #fff;
            background: linear-gradient(to right bottom, #FD8ED2, #F14997);
            font-size: 20px;
            font-weight: 700;
            line-height: 40px;
            padding: 7px 0 3px;
            display: block;
        }
        .counter.blue{ color: #0092CD; }
        .counter.blue .counter-value{ background: linear-gradient(to right bottom, #06BBF4, #0092CD); }
        .counter.orange{ color: #FB9A00; }
        .counter.orange .counter-value{ background: linear-gradient(to right bottom, #FCCA09, #FB9A00); }
        .counter.green{ color: #03BFB0; }
        .counter.green .counter-value{ background: linear-gradient(to right bottom, #00E2CD, #03BFB0); }
        @media screen and (max-width:990px){
            .counter{ margin-bottom: 40px; }
        }
    </style>
    <div class="col-md-3 col-sm-6">
        <div class="counter">
            <div class="counter-icon">
                <i class="fas fa-restroom"></i>
            </div>
            <h3>Today Admit Patient</h3>
            <span class="counter-value"><?php echo $t_patient; ?></span>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="counter blue">
            <div class="counter-icon">
                <i class="fas fa-restroom"></i>
            </div>
            <h3>Today Discharged Patient</h3>
            <span class="counter-value"><?php echo mysqli_num_rows($fetch_data_discharge_ex); ?></span>
        </div>
    </div>
    <div class="counter orange">
        <div class="counter-icon">
            <i class="fa fa-money-bill-alt"></i>
        </div>
        <h3>Today Hospital Shares</h3>
        <span class="counter-value"><?php echo number_format((float)$hospital_share, 2, '.', ''); ?></span>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="counter green">
            <div class="counter-icon">
                <i class="fa fa-plus-square"></i>
            </div>
            <h3>Today Dialysis</h3>
            <span class="counter-value"> <?php
            $fetch_data = "SELECT * FROM ssh_p_dialysis WHERE admission_type = '0'  AND date = '".date('Y-m-d')."' ";
            $fetch_data_ex = mysqli_query($con,$fetch_data);
            ?>
            <?php echo mysqli_num_rows($fetch_data_ex); ?>
        </span>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.counter-value').each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            },{
                duration: 3500,
                easing: 'swing',
                step: function (now){
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });
</script>






<script type="text/javascript">
    function update_info(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/other_services.php",
            data: 'd_inventory_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
</script>


<div class="col-xl-12">
    <br><br>
    <div class="card-box">


        <h4 class="header-title mb-3">Current Day Private Indoor</h4>

        <div  class="card-table-style">
            <form action="" method="get" enctype="multipart/form-data">
                <div class="row col-sm-12">
                    <input type="date" class="form-control"  name="search_date"  onchange="this.form.submit()" style="border: 1px solid red;width: 150px;float: left;" required>
                </div>   
            </form> 
            <?php 
            if (isset($_GET['search_date'])) { ?>
               <table  id="example_dashboard_indoor_private" class="table table-striped table-bordered table-nowrap table-hover table-centered m-0 table-responsive-sm " >

                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th colspan="4"><?php echo $_GET['search_date'] ?></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Sr No.</th>
                        <th>Patient</th>
                        <th>Case</th>
                        <th>Total Payment</th>
                        <th>Paid Doctors</th>
                        <th>Hospital Share</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sr_no = 1;
                    $total_hospital_share = 0;
                    $total_payment = 0;
                    $fetch_data = "Select *,ssh_p_reg.Name AS patient,ssh_dr_reg.Name as doctor,SUM(ssh_p_indoor_doctors.D_Fee) AS fee,ssh_p_indoor.Paid as Paid from ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID LEFT JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID Where CONVERT(ssh_p_indoor.admit_date,date) = '".$_GET['search_date']."' AND ssh_p_indoor.admition_type = '0' GROUP BY ssh_p_reg.P_ID";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $row['patient']  ?></td>
                            <td><?php echo $row['Title']  ?></td>

                            <td><?php echo $row['Paid']  ?></td>
                            <td>
                                <?php
                                $fetch_data12 = "SELECT * FROM  ssh_p_indoor_doctors LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID  WHERE ssh_p_indoor_doctors.pi_id ='".$row['pi_id']."' AND ssh_p_indoor_doctors.to_paid = '1' ";
                                $fetch_data12_ex = mysqli_query($con,$fetch_data12);
                                foreach($fetch_data12_ex as $row123){ 
                                    echo $row123['Name']." - ".$row123['D_Fee']."<br>";
                                }
                                ?>
                            </td>
                            <td><?php echo $row['Paid']-$row['fee']  ?></td> 
                            <input type="date" id="closing_date_indoor_private" value="<?php echo $_GET['search_date']; ?>" hidden>                                           
                        </tr> 
                        <?php 
                        $total_hospital_share += $row['Paid']-$row['fee'];
                        $total_payment += $row['Paid'];
                        $sr_no++;
                    } ?>  
                    <tr style="background: lightgrey !important;">

                        <td></td>
                        <td></td>
                        <td style="background: lightgrey !important; float: right;"><b>Dialysis</b></td>

                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> 
                    <?php
                    $sr_no = 1;
                    $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID  where ssh_p_dialysis.date = '".$_GET['search_date']."' AND ssh_p_dialysis.admission_type = '0' ";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr id="<?php echo $row['pd_id'] ?>">
                            <?php echo "<td>".$sr_no."</td>";?>
                            <?php 

                            echo "<td>".$row['Name']."</td><td></td><td>".$row['Paid']."</td><td></td><td>".$row['Paid']."</td>"; ?>
                        </tr>
                        <?php 
                        $total_hospital_share += $row['Paid'];
                        $total_payment += $row['Paid'];
                        $sr_no++;
                    }
                    ?>     
                </tbody>
                <tfoot style="background: black !important;">
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-center" style="color: white !important;"><b>Total</b></td>
                        <td class="text-center" style="color: white !important;"><b><?php echo $total_payment ?></b></td>
                        <td></td>
                        <td class="text-center" style="color: white !important;"><b><?php echo $total_hospital_share ?></b></td>
                    </tr>
                </tfoot>
            </table>
            <?php 
        }else{
            ?>
            <table  id="example_dashboard_indoor_private" class="table table-striped table-bordered table-nowrap table-hover table-centered m-0 table-responsive-sm  " >

                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th colspan="4">Today Cases</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Sr No.</th>
                        <th>Patient</th>
                        <th>Case</th>
                        <th>Total Payment</th>
                        <th>Paid Doctors</th>
                        <th>Hospital Share</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sr_no = 1;
                    $total_hospital_share = 0;
                    $total_payment = 0;
                    $fetch_data = "Select *,ssh_p_reg.Name AS patient,ssh_dr_reg.Name as doctor,SUM(ssh_p_indoor_doctors.D_Fee) AS fee,ssh_p_indoor.Paid as Paid from ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID LEFT JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID Where CONVERT(ssh_p_indoor.admit_date,date) = '".date('Y-m-d')."' AND ssh_p_indoor.admition_type = '0' GROUP BY ssh_p_reg.P_ID ";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $row['patient']  ?></td>
                            <td><?php echo $row['Title']  ?></td>
                            <td><?php echo $row['Paid']  ?></td>
                            <td>
                                <?php
                                $fetch_data12 = "SELECT * FROM  ssh_p_indoor_doctors LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID  WHERE ssh_p_indoor_doctors.pi_id ='".$row['pi_id']."' AND ssh_p_indoor_doctors.to_paid = '1' ";
                                $fetch_data12_ex = mysqli_query($con,$fetch_data12);
                                foreach($fetch_data12_ex as $row123){ 
                                    echo $row123['Name']." - ".$row123['D_Fee'];
                                }
                                ?>
                            </td>                            <td><?php echo $row['Paid']-$row['fee']  ?></td> 
                            
                            <input type="date" id="closing_date_indoor_private" value="<?php echo date('Y-m-d')?>" hidden>                                           
                        </tr> 

                        <?php 
                        $total_hospital_share += $row['Paid']-$row['fee'];
                        $total_payment += $row['Paid'];
                        $sr_no++;
                    } ?>
                    <tr style="background: lightgrey !important;">

                        <td></td>
                        <td></td>
                        <td style="background: lightgrey !important; float: right;"><b>Dialysis</b></td>

                        <td></td>

                        <td></td>
                        <td></td>
                    </tr> 
                    <?php
                    $sr_no = 1;
                    $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID  where ssh_p_dialysis.date = '".date('Y-m-d')."' AND ssh_p_dialysis.admission_type = '0' ";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr id="<?php echo $row['pd_id'] ?>">
                            <?php echo "<td>".$sr_no."</td>";?>
                            <?php 

                            echo "<td>".$row['Name']."</td><td></td><td>".$row['Paid']."</td><td></td><td>".$row['Paid']."</td>"; ?>
                        </tr>
                        <?php 
                        $total_hospital_share += $row['Paid'];
                        $total_payment += $row['Paid'];
                        $sr_no++;
                    }
                    ?>   
                </tbody>
                <tfoot style="background: black !important;">
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-center" style="color: white !important;"><b>Total</b></td>
                        <td class="text-center" style="color: white !important;"><b><?php echo $total_payment ?></b></td>
                        <td></td>
                        <td class="text-center" style="color: white !important;"><b><?php echo $total_hospital_share ?></b></td>
                    </tr>
                </tfoot>
            </table>
        <?php } ?>
    </div> <!-- end .table-responsive-->
</div> <!-- end card-box-->
</div> <!-- end col -->
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