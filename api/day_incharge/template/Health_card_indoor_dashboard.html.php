  <div class="row">
    <?php
    date_default_timezone_set("Asia/Karachi");
    $total_charges_s = 0;
    $total_paid_s = 0;

    $hospital_share = 0;
    $t_patient = 0;
    
    $fetch_data = "SELECT * From ssh_p_indoor where  admit_date = '".date('Y-m-d')."' AND admition_type = '1'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ 
        $fetch_data12 = "SELECT SUM(D_Fee) As fee From  ssh_p_indoor_doctors where  pi_id = '".$row['pi_id']."' ";
        $fetch_data12_ex = mysqli_query($con,$fetch_data12);
        foreach($fetch_data12_ex as $row12){
            $hospital_share += $row['Paid']-$row12['fee'];
        }
    }

    $t_patient = mysqli_num_rows($fetch_data_ex);

    $fetch_data_discharge = "SELECT * From ssh_p_indoor where  exit_date = '".date('Y-m-d')."' AND admition_type = '1'";
    $fetch_data_discharge_ex = mysqli_query($con,$fetch_data_discharge);
    ?>
    <style>
        .counter{
            color: #ffa502;
            font-family: 'Baloo Tamma 2', cursive;
            text-align: center;
            width: 200px;
            height: 210px;
            padding: 103px 15px 30px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .counter:before,
        .counter:after{
            content: '';
            background: #ffa502;
            height: calc(100% - 7px);
            width: 100%;
            position: absolute;
            left: 0;
            top: 7px;
            z-index: -1;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }
        .counter:after{
            background: linear-gradient(-151deg,#ffa502,#ffa502 80px,#fff 82px,#fff 100%);
            transform: scale(0.96,0.94);
        }
        .counter .counter-icon{
            color: #fff;
            background-color: #ffa502;
            font-size: 40px;
            line-height: 85px;
            height: 70px;
            width: 70px;
            box-shadow:  0 0 15px -3px rgba(0,0,0,0.3);
            transform: rotate(30deg);
            position: absolute;
            top: 14px;
            right: 22px;
        }
        .counter .counter-icon i{ transform: rotate(-30deg); }
        .counter .counter-value{
            font-size: 33px;
            font-weight: 700;
            line-height: 30px;
            margin: 0 0 5px;
            display: block;
        }
        .counter h3{
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            margin: 0;
        }
        .counter.purple{ color: #7b4c90; }
        .counter.purple:before,
        .counter.purple .counter-icon{ background: #7b4c90; }
        .counter.purple:after{ background: linear-gradient(-151deg,#7b4c90,#7b4c90 80px,#fff 82px,#fff 100%); }
        .counter.blue{ color: #4c5882; }
        .counter.blue:before,
        .counter.blue .counter-icon{ background: #4c5882; }
        .counter.blue:after{ background: linear-gradient(-151deg,#4c5882,#4c5882 80px,#fff 82px,#fff 100%); }
        .counter.red{ color: #ee5835; }
        .counter.red:before,
        .counter.red .counter-icon{ background: #ee5835; }
        .counter.red:after{ background: linear-gradient(-151deg,#ee5835,#ee5835 80px,#fff 82px,#fff 100%); }
        @media screen and (max-width:990px){
            .counter{ margin-bottom: 40px; }
        }
    </style>
    <div class="col-md-3 col-sm-6">
        <div class="counter">
            <div class="counter-icon">
                <i class="fas fa-restroom"></i>
            </div>
            <span class="counter-value"><?php echo $t_patient; ?></span>
            <h3>Today Admit Patient</h3>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="counter purple">
            <div class="counter-icon">
                <i class="fa fa-restroom"></i>
            </div>
            <span class="counter-value"><?php echo mysqli_num_rows($fetch_data_discharge_ex); ?></span>
            <h3>Today Discharged Patient</h3>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="counter red">
            <div class="counter-icon">
                <i class="fas fa-money-bill-alt"></i>
            </div>
            <span class="counter-value"><?php echo number_format((float)$hospital_share, 2, '.', ''); ?></span>
            <h3>Today Hospital Shares</h3>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="counter blue">
            <div class="counter-icon">
                <i class="fa fa-plus-square"></i>
            </div>
            <?php
            date_default_timezone_set("Asia/Karachi");
            $fetch_data_dialysis = "SELECT * FROM ssh_p_dialysis WHERE admission_type = '1'  AND date = '".date('Y-m-d')."'";
            $fetch_data_dialysis_ex = mysqli_query($con,$fetch_data_dialysis);
            ?>
            <span class="counter-value"><?php echo mysqli_num_rows($fetch_data_dialysis_ex); ?></span>
            <h3>Today Dialysis</h3>


        </div>
    </div>
    <script>
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


</div> <!-- end card-box-->
</div> <!-- end col -->



<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update  Inventory </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update  Inventory</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div>  




<div class="col-xl-12">
    <br><br>
    <div class="card-box">


        <h4 class="header-title mb-3">Current Day Health Card Indoor</h4>

        <div  class="card-table-style">
            <form action="" method="get" enctype="multipart/form-data">
                <div class="row col-sm-12">
                    <input type="date" class="form-control"  name="search_date"  onchange="this.form.submit()" style="border: 1px solid red;width: 150px;float: left;" required>
                </div>   
            </form> 
            <?php 
            if (isset($_GET['search_date'])) { ?>
             <table  id="example_dashboard_indoor" class="table table-striped table-bordered table-nowrap table-hover table-centered m-0 table-responsive-sm " >

                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th colspan="3"><?php echo $_GET['search_date'] ?></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Sr No.</th>
                        <th>Patient</th>
                        <th>Case</th>
                        <th>Total Payment</th>
                        <th>Hospital Share</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sr_no = 1;
                    $total_hospital_share = 0;
                    $total_payment = 0;
                    $fetch_data = "Select *,ssh_p_reg.Name AS patient,ssh_dr_reg.Name as doctor,SUM(ssh_p_indoor_doctors.D_Fee) AS fee,ssh_p_indoor.Paid as Paid from ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID LEFT JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID Where CONVERT(ssh_p_indoor.admit_date,date) = '".$_GET['search_date']."' AND ssh_p_indoor.admition_type = '1' GROUP BY ssh_p_reg.P_ID";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $row['patient']  ?></td>
                            <td><?php echo $row['Title']  ?></td>
                            <td><?php echo $row['Paid']  ?></td>
                            <td><?php echo $row['Paid']-$row['fee']  ?></td> 
                            <input type="date" id="closing_date_indoor" value="<?php echo $_GET['search_date']; ?>" hidden>                                           
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
                    </tr> 
                    <?php
                    $sr_no = 1;
                    $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID  where ssh_p_dialysis.date = '".$_GET['search_date']."' AND ssh_p_dialysis.admission_type = '1' ";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr id="<?php echo $row['pd_id'] ?>">
                            <?php echo "<td>".$sr_no."</td>";?>
                            <?php 

                            echo "<td>".$row['Name']."</td><td></td><td>".$row['Paid']."</td><td>".$row['Paid']."</td>"; ?>
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
                        <td class="text-center" style="color: white !important;"><b><?php echo $total_hospital_share ?></b></td>
                    </tr>
                </tfoot>
            </table>
            <?php 
        }else{
            ?>
            <table  id="example_dashboard_indoor" class="table table-striped table-bordered table-nowrap table-hover table-centered m-0 table-responsive-sm  " >

                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th colspan="3">Today Cases</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Sr No.</th>
                        <th>Patient</th>
                        <th>Case</th>
                        <th>Total Payment</th>
                        <th>Hospital Share</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sr_no = 1;
                    $total_hospital_share = 0;
                    $total_payment = 0;
                    $fetch_data = "Select *,ssh_p_reg.Name AS patient,ssh_dr_reg.Name as doctor,SUM(ssh_p_indoor_doctors.D_Fee) AS fee,ssh_p_indoor.Paid as Paid from ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID LEFT JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID Where CONVERT(ssh_p_indoor.admit_date,date) = '".date('Y-m-d')."' AND ssh_p_indoor.admition_type = '1' GROUP BY ssh_p_reg.P_ID ";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $row['patient']  ?></td>
                            <td><?php echo $row['Title']  ?></td>
                            <td><?php echo $row['Paid']  ?></td>
                            <td><?php echo $row['Paid']-$row['fee']  ?></td> 
                            <input type="date" id="closing_date_indoor" value="<?php echo date('Y-m-d')?>" hidden>                                           
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
                    </tr> 
                    <?php
                    $sr_no = 1;
                    $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID  where ssh_p_dialysis.date = '".date('Y-m-d')."' AND ssh_p_dialysis.admission_type = '1' ";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ 
                        ?>
                        <tr id="<?php echo $row['pd_id'] ?>">
                            <?php echo "<td>".$sr_no."</td>";?>
                            <?php 

                            echo "<td>".$row['Name']."</td><td></td><td>".$row['Paid']."</td><td>".$row['Paid']."</td>"; ?>
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
                        <td class="text-center" style="color: white !important;"><b><?php echo $total_hospital_share ?></b></td>
                    </tr>
                </tfoot>
            </table>
        <?php } ?>
    </div> <!-- end .table-responsive-->
</div> <!-- end card-box-->
</div> <!-- end col -->
