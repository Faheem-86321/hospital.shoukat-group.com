  <div class="row">
    <style type="text/css">
        .counter{
            color: #222;
            font-family: 'Rubik', sans-serif;
            text-align: center;
            width: 210px;
            height: 210px;
            padding: 46px 30px;
            margin: 0 auto;
            border: 3px solid #ff2828;
            border-top-color: transparent;
            border-right-color: transparent;
            border-left-color: transparent;
            border-radius: 50%;
            position: relative;
            z-index: 1;
        }
        .counter:before,
        .counter:after{
            content: '';
            background: #ff2828;
            border-radius: 50%;
            box-shadow: 0 4px rgba(0,0,0,0.2);
            position: absolute;
            left: 10px;
            top: 10px;
            bottom: 10px;
            right: 10px;
            z-index: -1;
        }
        .counter:after{
            background: #fff;
            left: 25px;
            top: 25px;
            bottom: 25px;
            right: 25px;
        }
        .counter .counter-icon{
            color: #d1d1d1;
            font-size: 35px;
            line-height: 35px;
            margin: 0 0 13px;
        }
        .counter h3{
            color: #ff2828;
            font-size: 15px;
            font-weight: 500;
            text-transform: capitalize;
            margin: 0 0 8px;
        }
        .counter .counter-value{
            color: #555;
            font-size: 30px;
            font-weight: 600;
            display: block;
        }
        .counter.blue{ border-bottom-color: #00a8e0; }
        .counter.blue:before{ background: #00a8e0; }
        .counter.blue h3{ color: #00a8e0; }
        .counter.green{ border-bottom-color: #7ebc2d; }
        .counter.green:before{ background: #7ebc2d; }
        .counter.green h3{ color: #7ebc2d; }
        .counter.purple{ border-bottom-color: #4f31aa; }
        .counter.purple:before{ background: #4f31aa; }
        .counter.purple h3{ color: #4f31aa; }
        @media screen and (max-width:990px){
            .counter{ margin-bottom: 40px; }
        }
    </style>
    <?php
    date_default_timezone_set("Asia/Karachi");
    $total_charges_s = 0;
    $total_paid_s = 0;
    $total_hospital_Share_for_div = 0;
    $fetch_data = "SELECT COUNT(ssh_p_dpr.MRN) AS total_patient,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN))  AS hosiptal FROM ssh_p_dpr,ssh_dr_reg
    WHERE ssh_p_dpr.D_ID = ssh_dr_reg.D_ID AND convert(ssh_p_dpr.A_Date,Date) = '".date('Y-m-d')."'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ 
        $total_hospital_Share_for_div += number_format((float)$row['hosiptal'], 2, '.', '');
    } 
    $select_query = "SELECT *,SUM(paid)  AS paid FROM ssh_p_services
    WHERE convert(Date,Date) = '".date('Y-m-d')."'";
    $select_query_ex = mysqli_query($con,$select_query);
    foreach($select_query_ex as $row){
        $total_hospital_Share_for_div += $row["paid"];
    } ?>
    <div class="col-md-2 col-sm-6">
        <div class="counter green">
            <div class="counter-icon">
                <i class="fa fa-money-bill-alt"></i>
            </div>
            <h3>Today Hospital Shares</h3>
            <span class="counter-value"><?php echo $total_hospital_Share_for_div; ?></span>
        </div>
    </div>
    
    <?php
    date_default_timezone_set("Asia/Karachi");
    $fetch_data_expense_pay = "SELECT SUM(Amount) AS total_ex FROM ssh_expenses  WHERE Date = '".date('Y-m-d')."' AND services = 0 ";
    $fetch_data_expense_pay_ex = mysqli_query($con,$fetch_data_expense_pay);
    foreach($fetch_data_expense_pay_ex as $row){ ?>
       <div class="col-md-2 col-sm-6">
        <div class="counter">
            <div class="counter-icon">
                <i class="fa fa-money-bill-alt"></i>
            </div>
            <h3>Today Expense</h3>
            <span class="counter-value"><?php echo $row['total_ex']; ?></span>
        </div>
    </div>
<?php } ?>
<?php
$fetch_data_xray_count = "SELECT * FROM ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id  = ssh_ser_inv.ID WHERE convert(ssh_p_services.Date,Date) = '".date('Y-m-d')."' AND (ssh_ser_inv.ID = '1' OR ssh_ser_inv.ID = '6') ";
$fetch_data_xray_count_ex = mysqli_query($con,$fetch_data_xray_count);
$fetch_data_ctscan_count = "SELECT * FROM ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id  = ssh_ser_inv.ID WHERE convert(ssh_p_services.Date,Date) = '".date('Y-m-d')."' AND ssh_ser_inv.ID = '2' ";
$fetch_data_ctscan_count_ex = mysqli_query($con,$fetch_data_ctscan_count);
?>       
<div class="col-md-2 col-sm-6">
    <div class="counter blue">
        <div class="counter-icon">
            <i class="fa fa-plus-square"></i>
        </div>
        <h3>Today X-Rays</h3>
        <span class="counter-value"><?php echo mysqli_num_rows($fetch_data_xray_count_ex); ?></span>

    </div>
</div>
<div class="col-md-2 col-sm-6">
    <div class="counter blue">
        <div class="counter-icon">
            <i class="fa fa-plus-square"></i>
        </div>
        <h3>Today Ct-Scan</h3>
        <span class="counter-value"><?php echo mysqli_num_rows($fetch_data_ctscan_count_ex); ?></span>
    </div>
</div>
<?php
$fetch_data_xray_pay = "SELECT SUM(ssh_p_services.Paid) AS today_payment FROM ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id  = ssh_ser_inv.ID WHERE convert(ssh_p_services.Date,Date) = '".date('Y-m-d')."' AND (ssh_ser_inv.ID = '1' OR ssh_ser_inv.ID = '6') ";
$fetch_data_xray_pay_ex = mysqli_query($con,$fetch_data_xray_pay);
foreach($fetch_data_xray_pay_ex as $row){ ?>
    <div class="col-md-2 col-sm-6">
        <div class="counter green">
            <div class="counter-icon">
                <i class="fa fa-money-bill-alt"></i>
            </div>
            <h3>X-Rays Payment</h3>
            <span class="counter-value"><?php echo $row['today_payment']; ?></span>
        </div>
    </div>
<?php } ?>

<?php
$fetch_data_ctscan_pay = "SELECT SUM(ssh_p_services.Paid) AS today_payment FROM ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id  = ssh_ser_inv.ID WHERE convert(ssh_p_services.Date,Date) = '".date('Y-m-d')."' AND ssh_ser_inv.ID = '2' ";
$fetch_data_ctscan_pay_ex = mysqli_query($con,$fetch_data_ctscan_pay);
foreach($fetch_data_ctscan_pay_ex as $row){ ?>
   <div class="col-md-2 col-sm-6">
    <div class="counter green">
        <div class="counter-icon">
            <i class="fa fa-money-bill-alt"></i>
        </div>
        <h3>Ct-Scan Payment</h3>
        <span class="counter-value"><?php echo $row['today_payment']; ?></span>
    </div>
</div>
<?php } ?>
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




<script type="text/javascript">
    function update_info1(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/other_services.php",
            data: 'ct_inventory_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
</script>
<div class="col-xl-12 mt-2" >
    <div class="card-box " style="border-right: 3px solid #f24c4f ;box-shadow: 0 3px 10px rgb(0 0 0 / 0.2)">
        <div class="float-right d-none d-md-inline-block" style="color: black !important;">
         <div class="btn-group " style="background: #f24c4f;color: black !important;">
          <button type="button" class="btn btn-xs btn-primary  m-1" >Monthly</button>
      </div>
  </div>

  <h4 class="header-title mb-3 p-2" style="background: #f24c4f;color: black !important;"><i class="fa fa-wheelchair"></i> Outdoor Analytics</h4>

  <div dir="ltr">
     <div id="deal-analytics" class="mt-4" data-colors="#6658dd,#f1556c,#1abc9c"></div>
 </div>
</div> <!-- end card-box -->
</div> <!-- end col-->
<div class="col-xl-12">
    <div class="card-box bodyoftable">


        <h4 class="header-title mb-3">Current Day Outdoor</h4>

        <div  class="card-table-style " >
            <form action="" method="get" enctype="multipart/form-data">
                <div class="row col-sm-12">
                    <input type="date" class="form-control mt-1"  name="date_from"  style="border: 1px solid red;width: 150px;float: left;" required>
                    <span style="float: left;" class="m-2"><b>To</b></span>
                    <input type="date" class="form-control m-1"  name="date_to"  style="width: 150px;float: left;" required>
                    <input type="submit" class="btn btn-success m-1"  name="search_date" value="Search"  style="float: left;height: 36px;">
                </div>   
            </form>
            <?php 
            if (isset($_GET['search_date'])) { ?>
                <input type="text" value="<?php echo $_GET['date_from']." to ".$_GET['date_to'] ;?>" hidden id='closing_date' >
                <table  id="example_dashboard_service" class="table table-centered table-striped table-bordered mb-0 toggle-circle" >

                    <thead class="thead-light">
                        <tr>
                            <th colspan="7"><?php echo $_GET['date_from']." to ".$_GET['date_to'] ;?></th>
                        </tr>
                        <tr>
                            <th>Sr No.</th>
                            <th>Doctor Name</th>
                            <th>Total Patient</th>
                            <th>Total</th>
                            <th>Doctor Payment</th>
                            <th>Hospital Share(HS)</th>
                            <th>Discount</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_patients1 = 0;
                        $total_payment1 = 0;
                        $doc_payment1 = 0;
                        $total_hospital1 = 0;
                        $total_discout1 = 0;
                        $sr_no = 1;
                        $fetch_data = "SELECT ssh_dr_reg.D_ID,ssh_dr_reg.CNIC,ssh_dr_reg.Name,COUNT(ssh_p_dpr.MRN) AS Patients,SUM(ssh_p_dpr.D_Pay - ((ssh_p_dpr.D_Pay*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100) AS outdoor,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN))  AS hospitalshare,SUM(ssh_p_dpr.Charges-ssh_p_dpr.Paid) AS Discount,SUM((ssh_p_dpr.Charges-ssh_p_dpr.Paid)/2) AS doctor_discount FROM ssh_dr_reg, ssh_p_dpr
                        WHERE ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
                        AND CONVERT(ssh_p_dpr.A_DATE,Date) BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."' 
                        GROUP BY ssh_p_dpr.D_ID";
                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                        foreach($fetch_data_ex as $row){ 

                            ?>
                            <tr>
                                <td><?php echo $sr_no ?></td>
                                <td><?php echo $row['Name']  ?>
                                <input type="hidden" id="doc_name<?php echo $row['D_ID'] ?>" value="<?php echo $row['Name']  ?>">
                                <input type="date" id="payment_date" hidden value="<?php  echo $_GET['search_date'] ?>"></td>
                                <td><?php echo $row['Patients']  ?></td>
                                <td><?php echo  number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '')  ?></td>

                                <td><?php echo number_format((float)$row['outdoor'], 2, '.', '');  ?> </td></td>
                                <td><?php echo  number_format((float)$row['hospitalshare'], 2, '.', '')  ?></td>
                                <td><?php echo number_format((float)$row['Discount'], 2, '.', '')  ?></td>

                                <input type="hidden" value="<?php echo number_format((float)$row['outdoor'], 2, '.', '') - number_format((float)$row['Discount'], 2, '.', '') ;?>" id="total_payment<?php echo $row['D_ID'] ?>">
                            </tr>


                            <?php
                            $total_patients1 += $row['Patients'];
                            $total_payment1 += number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '');
                            $doc_payment1 += number_format((float)$row['outdoor'], 2, '.', '');
                            $total_hospital1 += number_format((float)$row['hospitalshare'], 2, '.', '');
                            $total_discout1 += number_format((float)$row['Discount'], 2, '.', '');
                            $sr_no++;
                        } ?>



                        <tr style="background: lightgrey;">
                            <td></td>
                            <td><b> Total: </b></td>
                            <td><b><?php echo $total_patients1; ?></b></td>
                            <td><b><?php echo $total_payment1; ?></b></td>
                            <td><b><?php echo $doc_payment1; ?></b></td>
                            <td><b><?php echo $total_hospital1; ?></b></td>
                            <td><b><?php echo $total_discout1; ?></b></td>

                        </tr>

                        <tr style="background: lightgrey !important;">

                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td style="background: lightgrey !important; float: right;"><b>Services</b></td>

                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php 
                        $total_patients2 = 0;
                        $total_payment2 = 0;
                        $doc_payment2 = 0;
                        $total_hospital2 = 0;
                        $total_discout2 = 0;
                        $fetch_data = "SELECT *,count(ssh_p_services.ser_p_id) as pat,SUM(Paid) as Paid,SUM(Charges)-SUM(Paid) AS Discount From ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID WHERE CONVERT(ssh_p_services.Date,Date)  BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."'  GROUP BY ssh_ser_inv.ID ";
                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                        foreach($fetch_data_ex as $row){
                            ?>
                            <tr>
                                <td><?php echo $sr_no ?></td>
                                <td><?php echo $row['Title'];  ?></td>
                                <td><?php echo $row['pat'] ?></td>
                                <td><?php echo $row['Discount']+number_format((float)$row['Paid'], 2, '.', '')  ?></td>

                                <td></td>
                                <td><?php echo number_format((float)$row['Paid'], 2, '.', '');  ?> </td></td>
                                <td><?php echo $row['Discount'];  ?></td>
                            </tr>


                            <?php
                            $total_patients2 += $row['pat'];
                            $total_payment2 += $row['Discount']+number_format((float)$row['Paid'], 2, '.', '');
                            $total_hospital2 += number_format((float)$row['Paid'], 2, '.', '');
                            $total_discout2 += number_format((float)$row['Discount'], 2, '.', '');
                            $sr_no++;
                        } ?>


                        <tr style="background: lightgrey;">
                            <td></td>
                            <td><b> Total: </b></td>
                            <td><b><?php echo $total_patients2; ?></b></td>
                            <td><b><?php echo $total_payment2; ?></b></td>
                            <td><b><?php echo $doc_payment2; ?></b></td>
                            <td><b><?php echo $total_hospital2; ?></b></td>
                            <td><b><?php echo $total_discout2; ?></b></td>

                        </tr>
                        <tr style="background: black;color: white !important;">
                            <td></td>
                            <td style="color: white !important ;"><b> Total: </b></td>
                            <td style="color: white !important ;"><b><?php echo $total_patients1 + $total_patients2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $total_payment1 + $total_payment2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $doc_payment1 + $doc_payment2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $total_hospital1 + $total_hospital2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $total_discout1 + $total_discout2; ?></b></td>

                        </tr>
                    </tbody>
                    <tfoot style="background: black;color: white !important;">
                        <?php
                        $today_expense = 0;
                        $today_hospital_only = $total_hospital1 + $total_hospital2;
                        $fetch_data_expense = "SELECT * FROM `ssh_expenses` where date BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."' AND services = '0'   ";
                        $fetch_data_expense_ex = mysqli_query($con,$fetch_data_expense);
                        foreach($fetch_data_expense_ex as $row){ 
                            $today_hospital_only -= $row['Amount'];  
                            $today_expense +=  $row['Amount'];
                        }
                        ?>
                        <tr >

                            <td></td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>

                            <td  style="color: white !important;"> Outdoor Cash In Hand: </td>
                            <td  style="color: white !important;">(HS - Expense): </td>
                            <td  style="color: white !important;">(<?php echo $total_hospital1 + $total_hospital2  ?> - <?php echo $today_expense;  ?>) = <?php echo $total_hospital1 + $total_hospital2-$today_expense; ?></td>

                            <td>&nbsp</td>
                        </tr>
                    </tfoot>

                </table>


                <?php     
            }else{
                ?>
                <table  id="example_dashboard_service" class="table table-centered table-striped table-bordered mb-0 toggle-circle" >

                    <input type="date" value="<?php echo date('Y-m-d') ?>" hidden id='closing_date' >
                    <thead class="thead-light">
                        <tr>
                            <th colspan="7"><?php echo date('Y-m-d') ;?></th>
                        </tr>
                        <tr>
                            <th>Sr No.</th>
                            <th>Doctor Name</th>
                            <th>Total Patient</th>
                            <th>Total</th>
                            <th>Doctor Payment</th>
                            <th>Hospital Share(HS)</th>
                            <th>Discount</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_patients1 = 0;
                        $total_payment1 = 0;
                        $doc_payment1 = 0;
                        $total_hospital1 = 0;
                        $total_discout1 = 0;
                        $sr_no = 1;
                        $fetch_data = "SELECT ssh_dr_reg.D_ID,ssh_dr_reg.CNIC,ssh_dr_reg.Name,COUNT(ssh_p_dpr.MRN) AS Patients,SUM(ssh_p_dpr.D_Pay - ((ssh_p_dpr.D_Pay*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100) AS outdoor,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN))  AS hospitalshare,SUM(ssh_p_dpr.Charges-ssh_p_dpr.Paid) AS Discount,SUM((ssh_p_dpr.Charges-ssh_p_dpr.Paid)/2) AS doctor_discount FROM ssh_dr_reg, ssh_p_dpr
                        WHERE ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
                        AND CONVERT(ssh_p_dpr.A_DATE,Date) = '".date('Y-m-d')."' 
                        GROUP BY ssh_p_dpr.D_ID";
                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                        foreach($fetch_data_ex as $row){ 

                            ?>
                            <tr>
                                <td><?php echo $sr_no ?></td>
                                <td><?php echo $row['Name']  ?>
                                <input type="hidden" id="doc_name<?php echo $row['D_ID'] ?>" value="<?php echo $row['Name']  ?>">
                                <input type="date" id="payment_date" hidden value="<?php  echo date('Y-m-d') ?>"></td>
                                <td><?php echo $row['Patients']  ?></td>
                                <td><?php echo  number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '')  ?></td>

                                <td><?php echo number_format((float)$row['outdoor'], 2, '.', '');  ?> </td></td>
                                <td><?php echo  number_format((float)$row['hospitalshare'], 2, '.', '')  ?></td>
                                <td><?php echo number_format((float)$row['Discount'], 2, '.', '')  ?></td>

                                <input type="hidden" value="<?php echo number_format((float)$row['outdoor'], 2, '.', '') - number_format((float)$row['Discount'], 2, '.', '') ;?>" id="total_payment<?php echo $row['D_ID'] ?>">
                            </tr>


                            <?php
                            $total_patients1 += $row['Patients'];
                            $total_payment1 += number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '');
                            $doc_payment1 += number_format((float)$row['outdoor'], 2, '.', '');
                            $total_hospital1 += number_format((float)$row['hospitalshare'], 2, '.', '');
                            $total_discout1 += number_format((float)$row['Discount'], 2, '.', '');
                            $sr_no++;
                        } ?>



                        <tr style="background: lightgrey;">
                            <td></td>
                            <td><b> Total: </b></td>
                            <td><b><?php echo $total_patients1; ?></b></td>
                            <td><b><?php echo $total_payment1; ?></b></td>
                            <td><b><?php echo $doc_payment1; ?></b></td>
                            <td><b><?php echo $total_hospital1; ?></b></td>
                            <td><b><?php echo $total_discout1; ?></b></td>

                        </tr>

                        <tr style="background: lightgrey !important;">

                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td style="background: lightgrey !important; float: right;"><b>Services</b></td>

                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php 
                        $total_patients2 = 0;
                        $total_payment2 = 0;
                        $doc_payment2 = 0;
                        $total_hospital2 = 0;
                        $total_discout2 = 0;
                        $fetch_data = "SELECT *,count(ssh_p_services.ser_p_id) as pat,SUM(Paid) as Paid,SUM(Charges)-SUM(Paid) AS Discount From ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID WHERE CONVERT(ssh_p_services.Date,Date) = '".date('Y-m-d')."'  GROUP BY ssh_ser_inv.ID ";
                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                        foreach($fetch_data_ex as $row){
                            ?>
                            <tr>
                                <td><?php echo $sr_no ?></td>
                                <td><?php echo $row['Title'];  ?></td>
                                <td><?php echo $row['pat'] ?></td>
                                <td><?php echo $row['Discount']+number_format((float)$row['Paid'], 2, '.', '')  ?></td>

                                <td></td>
                                <td><?php echo number_format((float)$row['Paid'], 2, '.', '');  ?> </td></td>
                                <td><?php echo $row['Discount'];  ?></td>
                            </tr>


                            <?php
                            $total_patients2 += $row['pat'];
                            $total_payment2 += $row['Discount']+number_format((float)$row['Paid'], 2, '.', '');
                            $total_hospital2 += number_format((float)$row['Paid'], 2, '.', '');
                            $total_discout2 += number_format((float)$row['Discount'], 2, '.', '');
                            $sr_no++;
                        } ?>


                        <tr style="background: lightgrey;">
                            <td></td>
                            <td><b> Total: </b></td>
                            <td><b><?php echo $total_patients2; ?></b></td>
                            <td><b><?php echo $total_payment2; ?></b></td>
                            <td><b><?php echo $doc_payment2; ?></b></td>
                            <td><b><?php echo $total_hospital2; ?></b></td>
                            <td><b><?php echo $total_discout2; ?></b></td>

                        </tr>

                        <tr style="background: black;color: white !important;">
                            <td></td>
                            <td style="color: white !important ;"><b> Total: </b></td>
                            <td style="color: white !important ;"><b><?php echo $total_patients1 + $total_patients2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $total_payment1 + $total_payment2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $doc_payment1 + $doc_payment2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $total_hospital1 + $total_hospital2; ?></b></td>
                            <td style="color: white !important ;"><b><?php echo $total_discout1 + $total_discout2; ?></b></td>

                        </tr>

                    </tbody>
                    <tfoot style="background: black;color: white !important;">
                        <?php
                        $today_expense = 0;
                        $today_hospital_only = $total_hospital1 + $total_hospital2;
                        $fetch_data_expense = "SELECT * FROM `ssh_expenses` where date = '".date('Y-m-d')."' AND services = '0'  ";
                        $fetch_data_expense_ex = mysqli_query($con,$fetch_data_expense);
                        foreach($fetch_data_expense_ex as $row){ 
                            $today_hospital_only -= $row['Amount'];  
                            $today_expense +=  $row['Amount'];
                        }
                        ?>
                        <tr >

                            <td></td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>

                            <td  style="color: white !important;"> Outdoor Cash In Hand: </td>
                            <td  style="color: white !important;">(HS - Expense): </td>
                            <td  style="color: white !important;">(<?php echo $total_hospital1 + $total_hospital2  ?> - <?php echo $today_expense;  ?>) = <?php echo $total_hospital1 + $total_hospital2-$today_expense; ?></td>

                            <td>&nbsp</td>
                        </tr>
                    </tfoot>
                </table>
            <?php } ?>
        </div> <!-- end .table-responsive-->
    </div> <!-- end card-box-->



</div> <!-- end col -->