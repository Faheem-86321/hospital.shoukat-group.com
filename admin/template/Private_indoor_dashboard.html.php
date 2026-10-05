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
                        <th>Private Indoor</th>
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
      <table class="table table-bordered">
         <thead>
                            <tr>
                        <th></th>
                        <th colspan="4">Doctor Case List</th>
                        <th></th>
                    </tr>
   
        <tr>
            <th>Sr No.</th>
            <th>Doctor</th>
            <th>Case</th>
            <th>Total Payment</th>
            <th>Doctor Payment</th>
            <th>Hospital Share</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $serial_no = 1;
        $grand_total_case_charges   = 0;
        $grand_total_doctor_paid    = 0;
        $grand_total_hospital_share = 0;

   $sql_report = "
    SELECT 
        d.Name AS doctor_name,
        c.Title AS case_name,
        p.pi_id,
        p.Paid AS total_payment,                          -- actual patient payment
        IFNULL(SUM(pd.D_Fee), 0) AS doctor_payment        -- total doctor fees
    FROM ssh_p_indoor p
    JOIN ssh_p_indoor_doctors pd ON p.pi_id = pd.pi_id
    LEFT JOIN ssh_dr_reg d ON pd.D_ID = d.D_ID
    LEFT JOIN ssh_cases_indoor c ON p.S_ID = c.S_ID
    WHERE DATE(p.admit_date) = '".$_GET['search_date']."'
      AND p.admition_type = '0'
    GROUP BY d.D_ID, p.pi_id, c.Title, p.Paid
";


        
        $query_report = mysqli_query($con, $sql_report);

       $serial_no = 1;
$grand_total_case_charges   = 0;
$grand_total_doctor_paid    = 0;
$grand_total_hospital_share = 0;

$query_report = mysqli_query($con, $sql_report);
while($row = mysqli_fetch_assoc($query_report)) {
    $hospital_share = $row['total_payment'] - $row['doctor_payment'];
    ?>
    <tr>
        <td><?php echo $serial_no++; ?></td>
        <td><?php echo $row['doctor_name']; ?></td>
        <td><?php echo $row['case_name']; ?></td>
        <td><?php echo $row['total_payment']; ?></td>
        <td><?php echo $row['doctor_payment']; ?></td>
        <td><?php echo $hospital_share; ?></td>
    </tr>
    <?php
    $grand_total_case_charges   += $row['total_payment'];
    $grand_total_doctor_paid    += $row['doctor_payment'];
    $grand_total_hospital_share += $hospital_share;
}

        ?>
    </tbody>
 <tfoot style="background: black !important;">
<tr style="background: White !important;">
    <td></td>
    <td></td>
    <td><b>Total</b></td>
    <td><b><?php echo $grand_total_case_charges; ?></b></td>
    <td><b><?php echo $grand_total_doctor_paid; ?></b></td>
    <td><b><?php echo $grand_total_hospital_share; ?></b></td>
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