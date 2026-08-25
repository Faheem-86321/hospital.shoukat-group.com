<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
/////////////////////View Indoor Record//////////////////
///////////////////////////////////////////////
if (isset($_POST['view_indoor_private_records_doc_pay'])) {
    $view_indoor_records = $_POST['view_indoor_private_records_doc_pay'];
    $whichone = $_POST['whichone'];
    $total = 0;
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="doc_id_update" value="<?php echo $row['view_indoor_records'] ?>">
        <div class="col-md-12 card-table-style">
            <link href="../assets/datatable/buttons.dataTables.min.css" rel="stylesheet"/>
            <link href="../assets/datatable/jquery.dataTables.min.css" rel="stylesheet"/>
            <table id="example_model" class="table table-striped table-bordered w-100">
                <thead>
                    <tr style="background: lightgrey;">
                        <th colspan="8" class="text-center">Indoor Private</th>
                    </tr>
                    <tr>
                        <th>Sr No.</th>
                        <th>Patient</th>
                        <th>Admit/Discharge</th>
                        <th>Case</th>
                        <th>Total Paid</th>
                        <th>Paid Doctors</th>
                        <th>Doctor Fee</th>
                        <th class="noExport">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Doctor:</b></td>
                        <td>
                            <b>
                                <?php
                                $fetch_data2 = "SELECT * FROM ssh_dr_reg  WHERE D_ID ='".$view_indoor_records."' ";
                                $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                                foreach($fetch_data2_ex as $row1){
                                    echo $row1['Name'];
                                }
                                ?>
                            </b>
                        </td>

                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                    <?php
                    $sr_no = 1;
                    $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_cases_indoor ON ssh_cases_indoor.S_ID = ssh_p_indoor.S_ID  LEFT JOIN ssh_p_reg ON ssh_p_reg.P_ID = ssh_p_indoor.P_ID  WHERE ssh_p_indoor_doctors.D_ID ='".$view_indoor_records."' AND ssh_p_indoor.admition_type = '".$whichone."' AND ssh_p_indoor_doctors.to_paid = '0' ";
                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                    foreach($fetch_data_ex as $row){ ?>
                        <tr id="removethispay_private<?php echo $row['pi_id'] ?>">
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>
                            <td><?php echo $row['Title'] ?></td>
                            <td><?php echo $row['Paid'] ?></td>
                            <td>
                                <?php
                                $fetch_data12 = "SELECT * FROM  ssh_p_indoor_doctors LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID  WHERE ssh_p_indoor_doctors.pi_id ='".$row['pi_id']."' AND ssh_p_indoor_doctors.to_paid = '1' ";
                                $fetch_data12_ex = mysqli_query($con,$fetch_data12);
                                foreach($fetch_data12_ex as $row123){ 
                                    echo $row123['Name']." - ".$row123['D_Fee'];
                                }
                                ?>
                            </td>


                            <td><input type="number" name='doc_pay_id[]' value="<?php echo $row['indoc_id'] ?>" hidden><input type="number" class="form-control totalcost" id="total_payment_p_ind<?php echo $row['pi_id'] ?>" name="doctor_payment_updation[]" value="<?php echo $row['D_Fee'] ?>"><?php echo $row['D_Fee'] ?></td>

                            <td class="text-center">
                                <a class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc_indivi,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</a></td> 
                            </tr>

                            <?php
                            $sr_no++;
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Datatable -->
                <script src="../assets/datatable/vfs_fonts.js"></script>
                <script src="../assets/datatable/jszip.min.js"></script>
                <script src="../assets/datatable/jquery-3.5.1.js"></script>
                <script src="../assets/datatable/jquery.dataTables.min.js"></script>
                <script src="../assets/datatable/dataTables.buttons.min.js"></script>
                <script src="../assets/datatable/buttons.print.min.js"></script>
                <script src="../assets/datatable/buttons.html5.min.js"></script>
                <script src="../assets/datatable/pdfmaker.js"></script>
                <script src="../assets/datatable/pdfvfont.js"></script>
                <script>
                   $('#example_model').DataTable({
                    "pageLength": 15,
                    dom: 'Bfrtip',
                    buttons:  [ {
                        extend: 'print',

                        exportOptions: {
                            columns: "thead th:not(.noExport)"
                        }
                    }
                    ]
                });
            </script>
            <div class="col-md-12 text-right">
                <button type="submit" name="pupdate_for_doc" id="" class="btn btn-success waves-effect waves-light">Save</button>
            </div>
        </div>
    </form>

    <?php 
}
/////////////////////Insert Doctor Payment Health card//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_paid_indoor_private'])) {
    $doctor_paid_indoor = $_POST['doctor_paid_indoor_private'];
    $get_total_payment = $_POST['get_total_payment'];
    $case_id = $_POST['case_id'];
    $view_data = " Insert into ssh_dr_payment_indoor(payment,Date,D_ID) values('".$get_total_payment."','".Date('Y-m-d')."','".$doctor_paid_indoor."')";
    $view_data_ex = mysqli_query($con,$view_data);
    if ($view_data_ex) {
        $del_data = "UPDATE ssh_p_indoor_doctors SET to_paid='1',D_Fee = '".$get_total_payment."' WHERE D_ID ='".$doctor_paid_indoor."' AND pi_id = '".$case_id."' ";
        $del_data_ex = mysqli_query($con,$del_data);
        
    }
}

/////////////////////Insert Doctor Payment Health card//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_paid_indoor_healthcard'])) {
    $doctor_paid_indoor = $_POST['doctor_paid_indoor_healthcard'];
    $get_total_payment = $_POST['get_total_payment'];
    $case_id = $_POST['case_id'];
    $view_data = " Insert into ssh_dr_payment_indoor(payment,Date,D_ID) values('".$get_total_payment."','".Date('Y-m-d')."','".$doctor_paid_indoor."')";
    $view_data_ex = mysqli_query($con,$view_data);
    if ($view_data_ex) {
        $del_data = "UPDATE ssh_p_indoor_doctors SET to_paid='1' WHERE D_ID ='".$doctor_paid_indoor."' AND pi_id = '".$case_id."' ";
        $del_data_ex = mysqli_query($con,$del_data);
        
    }
}
/////////////////////Insert Doctor Payment private//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_paid_indoor'])) {
    $doctor_paid_indoor = $_POST['doctor_paid_indoor'];
    $get_total_payment = $_POST['get_total_payment'];
    $whichone = $_POST['whichone'];
    $checkno = $_POST['checkno'];
    $view_data = " Insert into ssh_dr_payment_indoor(payment,Date,D_ID,checkno,type) values('".$get_total_payment."','".Date('Y-m-d')."','".$doctor_paid_indoor."','".$checkno."','1')";
    $view_data_ex = mysqli_query($con,$view_data);
    if ($view_data_ex) {
        $fetch_data2 = "Select * from ssh_p_indoor where admition_type = '".$whichone."'  ";
        $fetch_data2_ex = mysqli_query($con,$fetch_data2);
        foreach($fetch_data2_ex as $row){
            $del_data = "UPDATE ssh_p_indoor_doctors SET to_paid='1' WHERE D_ID ='".$doctor_paid_indoor."' AND pi_id = '".$row['pi_id']."' ";
            $del_data_ex = mysqli_query($con,$del_data);
        }
    }
}
/////////////////////Insert Doctor Payment private//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_paid_indoor_filtered'])) {
    $doctor_paid_indoor_filtered = $_POST['doctor_paid_indoor_filtered'];
    $get_total_payment = $_POST['get_total_payment'];
    $whichone = $_POST['whichone'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
    $checkno_filter = $_POST['checkno_filter'];
    $view_data = " Insert into ssh_dr_payment_indoor(payment,Date,D_ID,checkno,type) values('".$get_total_payment."','".Date('Y-m-d')."','".$doctor_paid_indoor_filtered."','".$checkno_filter."','1')";
    $view_data_ex = mysqli_query($con,$view_data);
    if ($view_data_ex) {
        $fetch_data2 = "Select * from ssh_p_indoor where admition_type = '".$whichone."' AND admit_date BETWEEN '".$date_from."' AND '".$date_to."'   ";
        $fetch_data2_ex = mysqli_query($con,$fetch_data2);
        foreach($fetch_data2_ex as $row){
            $del_data = "UPDATE ssh_p_indoor_doctors SET to_paid='1' WHERE D_ID ='".$doctor_paid_indoor_filtered."' AND pi_id = '".$row['pi_id']."' ";
            $del_data_ex = mysqli_query($con,$del_data);
        }
    }
}

/////////////////////View Outdoor Record//////////////////
///////////////////////////////////////////////
if (isset($_POST['view_outdoor_records'])) {
    $view_outdoor_records = $_POST['view_outdoor_records'];
    $doc_name = $_POST['doc_name'];
    $payment_date = $_POST['payment_date'];
    $total = 0;
    $discount = 0;
    ?>

    
    <div class="col-md-12 text-center card-table-style " id="cardCollpase4"> 
       <link href="../assets/datatable/buttons.dataTables.min.css" rel="stylesheet"/>
       <link href="../assets/datatable/jquery.dataTables.min.css" rel="stylesheet"/>
       <table id="example_model_ex" class=" table table-striped table-bordered table-responsive-sm" style="width: 100% !important;">
        <thead>
         <tr style="background: lightgrey;">
            <th colspan="5" class="text-center">Outdoor</th>
        </tr>
        
        <tr>
            <th>Token</th>
            <th>Patient</th>
            <th>Paid</th>

            <th>Discount</th>
            <th>Doctor Share</th>
        </tr>
    </thead>
    <tbody>
        <tr style="">
            <td></td>
            <td></td>
            <td><?php echo $doc_name ?></td>
            <td></td>
            <td><?php echo $payment_date ?></td>
        </tr>
        <?php
        $sr = 1;
        $fetch_data = "SELECT ssh_p_reg.Name As patient,ssh_p_dpr.MRN, (ssh_p_dpr.D_Pay - ((ssh_p_dpr.D_Pay*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100) AS fees,ssh_p_dpr.Paid AS total,((ssh_p_dpr.Charges-ssh_p_dpr.Paid)) AS Discount FROM ssh_p_dpr,ssh_dr_reg,ssh_p_reg WHERE ssh_p_dpr.D_ID=ssh_dr_reg.D_ID AND ssh_p_dpr.P_ID=ssh_p_reg.P_ID AND CONVERT(ssh_p_dpr.A_DATE,Date)='".$payment_date."' AND ssh_p_dpr.D_ID ='".$view_outdoor_records."'";
        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ ?>
            <tr>
                <td><?php echo $sr."</td><td>".$row['patient'] ?></td>
                <td><?php echo number_format((float)$row['total'], 2, '.', '') ?></td>
                <td><?php echo number_format((float)$row['Discount'], 2, '.', '') ?></td>
                <td><?php echo number_format((float)$row['fees'], 2, '.', '') ?></td>
                
            </tr>
            
            <?php
            $total += $row['fees'];
            $discount += $row['Discount'];
            $sr++;
        }
        ?>

    </tbody>
    <tfoot>
        <tr style="text-align: center !important;">
            <td style="text-align: center !important;"><b>Signature: </b></td>
            <td></td>
            <td style="text-align: center !important;"><b>Total Payment: </b> </td>
            <td style="text-align: center !important;"><?php echo number_format((float)$discount, 2, '.', '') ?></td>
            <td style="text-align: center !important;"><?php echo number_format((float)$total, 2, '.', '') ?></td>
            
        </tr>
    </tfoot>
</table>
<!-- Datatable -->
<script src="../assets/datatable/vfs_fonts.js"></script>
<script src="../assets/datatable/jszip.min.js"></script>
<script src="../assets/datatable/jquery-3.5.1.js"></script>
<script src="../assets/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/datatable/buttons.print.min.js"></script>
<script src="../assets/datatable/buttons.html5.min.js"></script>
<script src="../assets/datatable/pdfmaker.js"></script>
<script src="../assets/datatable/pdfvfont.js"></script>
<script>
   $('#example_model_ex').DataTable({
    "pageLength": 15,
    "ordering": false,
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'print', footer: true 
        
    }
    ]
});
</script>
</div>
<?php 
}
/////////////////////View Indoor Record//////////////////
///////////////////////////////////////////////
if (isset($_POST['view_indoor_private_records'])) {
    $view_indoor_records = $_POST['view_indoor_private_records'];
    $whichone = $_POST['whichone'];
    $total = 0;
    ?>
    <link href="../assets/datatable/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../assets/datatable/jquery.dataTables.min.css" rel="stylesheet"/>
    <table id="example_model" class="table table-striped table-bordered w-100">
        <thead><tr style="background: lightgrey;">
            <th colspan="5" class="text-center">Indoor Health Card</th>
        </tr>
        <tr>
            <td>Sr No.</td>
            <th>Patient</th>
            <th class="defaultSort" >Admit/Discharge</th>
            <th>Case</th>
            <th>Doctor Fee</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td><b>Doctor:</b></td>
            <td>
                <b>
                    <?php
                    $fetch_data2 = "SELECT * FROM ssh_dr_reg  WHERE D_ID ='".$view_indoor_records."' ";
                    $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                    foreach($fetch_data2_ex as $row1){
                        echo $row1['Name'];
                    }
                    ?>
                </b>
            </td>

            <td></td>
            <td></td>

        </tr>
        <?php

        $sr_no =1;
        $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_cases_indoor ON ssh_cases_indoor.S_ID = ssh_p_indoor.S_ID  LEFT JOIN ssh_p_reg ON ssh_p_reg.P_ID = ssh_p_indoor.P_ID  WHERE ssh_p_indoor_doctors.D_ID ='".$view_indoor_records."' AND ssh_p_indoor.admition_type = '".$whichone."' AND ssh_p_indoor_doctors.to_paid = '0' Order By ssh_p_indoor.admit_date DESC";
        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ 
            $date1 = $row['file_date'];
            $date2 = date('Y-m-d');
            $days_new = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24)."<br>";

            if ($row['file_status'] == 1 && intval($days_new) <=  30 ) { ?>

                <tr id="removethispay<?php echo $row['pi_id'] ?>" style="background: yellow !important;">
                    <td><?php echo $sr_no ?></td>
                    <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                    <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                    <td><?php echo $row['Title'] ?></td>
                    <td><?php echo $row['D_Fee'] ?></td>


                    <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                    <!-- <td class="text-center">
                        <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td> -->

                    </tr> 
                <?php } elseif($row['file_status'] == 2){ ?>      
                    <tr id="removethispay<?php echo $row['pi_id'] ?>" style="background: green !important;">
                        <td><?php echo $sr_no ?></td>
                        <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                        <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                        <td><?php echo $row['Title'] ?></td>
                        <td><?php echo $row['D_Fee'] ?></td>


                        <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                        <!-- <td class="text-center">
                            <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>  -->

                        </tr>
                        <?php
                    }
                    elseif($row['file_status'] == 1 && intval($days_new) > 30){ ?>
                        <tr id="removethispay<?php echo $row['pi_id'] ?>" style="background: red !important;">
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                            <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                            <td><?php echo $row['Title'] ?></td>
                            <td><?php echo $row['D_Fee'] ?></td>


                            <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                            <!-- <td class="text-center">
                                <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>  -->

                            </tr>
                            <?php
                        }elseif($row['file_status'] == 0){ ?>
                            <tr id="removethispay<?php echo $row['pi_id'] ?>">
                                <td><?php echo $sr_no ?></td>
                                <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                                <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                                <td><?php echo $row['Title'] ?></td>
                                <td><?php echo $row['D_Fee'] ?></td>


                                <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                               <!--  <td class="text-center">
                                <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>  -->

                            </tr>
                            <?php
                        }
                        else{}
                            ?>
                        <?php
                        $sr_no++;
                        $total += $row['D_Fee'];
                    }
                    ?>
                </tbody>
                <tfoot>
                    <!---->
                    <tr style="background: lightgrey;text-align: center;">


                        <td colspan="4"><input type="hidden" value="<?php echo number_format((float)$total, 2, '.', '') ;?>" id="total_payment_all<?php echo $row['D_ID'] ?>"><textarea class="form-control" id="checkno<?php echo $row['D_ID'] ?>" placeholder="Payment Details"></textarea></td>
                        <td><button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc_all,<?php echo $row['D_ID']; ?>,1);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>
                        
                    </tr> <tr style="background: lightgrey;text-align: center;">
                        <td></td>
                        <td></td>
                        <td></td>

                        <td><b>Total Indoor Payment: </b> </td>
                        <td><?php echo $total ?></td>
                        
                    </tr> 
                </tfoot>
            </table>
            <!-- Datatable -->
            <script src="../assets/datatable/vfs_fonts.js"></script>
            <script src="../assets/datatable/jszip.min.js"></script>
            <script src="../assets/datatable/jquery-3.5.1.js"></script>
            <script src="../assets/datatable/jquery.dataTables.min.js"></script>
            <script src="../assets/datatable/dataTables.buttons.min.js"></script>
            <script src="../assets/datatable/buttons.print.min.js"></script>
            <script src="../assets/datatable/buttons.html5.min.js"></script>
            <script src="../assets/datatable/pdfmaker.js"></script>
            <script src="../assets/datatable/pdfvfont.js"></script>
            <script>
               $('#example_model').DataTable({
                "pageLength": 15,
                dom: 'Bfrtip',
                buttons:  [{
                    extend: 'copy',

                },{
                    extend: 'excel',

                },{
                    extend: 'pdf',
                    footer: true

                }, {
                    extend: 'print',
                    footer: true

                }
                ]
            });

        </script>
        <?php 
    }
/////////////////////View Indoor Record//////////////////
///////////////////////////////////////////////
    if (isset($_POST['view_indoor_private_records_filtered'])) {
        $view_indoor_records = $_POST['view_indoor_private_records_filtered'];
        $whichone = $_POST['whichone'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $total = 0;
        ?>
        <link href="../assets/datatable/buttons.dataTables.min.css" rel="stylesheet"/>
        <link href="../assets/datatable/jquery.dataTables.min.css" rel="stylesheet"/>
        <table id="example_model" class="table table-striped table-bordered w-100">
            <thead><tr style="background: lightgrey;">
                <th colspan="5" class="text-center">Indoor Health Card<br><?php echo $date_from." to ".$date_to ?></th>
            </tr>
            <tr>
                <td>Sr No.</td>
                <th>Patient</th>
                <th class="defaultSort" >Admit/Discharge</th>
                <th>Case</th>
                <th>Doctor Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sr_no =1;
            $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_cases_indoor ON ssh_cases_indoor.S_ID = ssh_p_indoor.S_ID  LEFT JOIN ssh_p_reg ON ssh_p_reg.P_ID = ssh_p_indoor.P_ID  WHERE ssh_p_indoor_doctors.D_ID ='".$view_indoor_records."' AND ssh_p_indoor.admition_type = '".$whichone."' AND ssh_p_indoor_doctors.to_paid = '0' AND ssh_p_indoor.admit_date BETWEEN '".$date_from."' AND '".$date_to."' Order By ssh_p_indoor.admit_date DESC";
            $fetch_data_ex = mysqli_query($con,$fetch_data);
            foreach($fetch_data_ex as $row){ 
                $date1 = $row['file_date'];
                $date2 = date('Y-m-d');
                $days_new = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24)."<br>";

                if ($row['file_status'] == 1 && intval($days_new) <=  30 ) { ?>

                    <tr id="removethispay<?php echo $row['pi_id'] ?>" style="background: yellow !important;">
                        <td><?php echo $sr_no ?></td>
                        <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                        <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                        <td><?php echo $row['Title'] ?></td>
                        <td><?php echo $row['D_Fee'] ?></td>


                        <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                       <!--  <td class="text-center">
                            <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td> 
                        -->
                    </tr>
                <?php } elseif($row['file_status'] == 2){ ?>      
                    <tr id="removethispay<?php echo $row['pi_id'] ?>" style="background: green !important;">
                        <td><?php echo $sr_no ?></td>
                        <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                        <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                        <td><?php echo $row['Title'] ?></td>
                        <td><?php echo $row['D_Fee'] ?></td>


                        <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                            <!-- <td class="text-center">
                                <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td> --> 

                            </tr>
                            <?php
                        }
                        elseif($row['file_status'] == 1 && intval($days_new) > 30){ ?>
                            <tr id="removethispay<?php echo $row['pi_id'] ?>" style="background: red !important;">
                                <td><?php echo $sr_no ?></td>
                                <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                                <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                                <td><?php echo $row['Title'] ?></td>
                                <td><?php echo $row['D_Fee'] ?></td>


                                <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                                <!-- <td class="text-center">
                                    <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>  -->

                                </tr>
                                <?php
                            }elseif($row['file_status'] == 0){ ?>
                                <tr id="removethispay<?php echo $row['pi_id'] ?>">
                                    <td><?php echo $sr_no ?></td>
                                    <td><?php echo $row['Name']."<br>".$row['visitor_id'] ?></td>
                                    <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>

                                    <td><?php echo $row['Title'] ?></td>
                                    <td><?php echo $row['D_Fee'] ?></td>


                                    <input type="hidden" value="<?php echo number_format((float)$row['D_Fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['pi_id'] ?>">

                                    <!-- <td class="text-center">
                                        <button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,<?php echo $row['pi_id'] ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>  -->

                                    </tr>
                                    <?php
                                }
                                else{}
                                    ?>
                                <?php
                                $sr_no++;
                                $total += $row['D_Fee'];
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr style="background: lightgrey;text-align: center;">
                                <td></td>
                                <td></td>
                                <td></td>

                                <td><b>Total Indoor Payment: </b> </td>
                                <td><?php echo $total ?></td>
                            </tr>
                            <tr style="background: lightgrey;text-align: center;">


                                <td colspan="4">
                                    <input type="hidden" value="<?php echo number_format((float)$total, 2, '.', '') ;?>" id="total_payment_all_filtered<?php echo $row['D_ID'] ?>">
                                    <textarea class="form-control" id="checkno_filter<?php echo $row['D_ID'] ?>"  placeholder="Payment Details"></textarea>
                                </td>
                                <td><button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc_all_filtered,<?php echo $row['D_ID']; ?>,1);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>

                            </tr>
                        </tfoot>
                    </table>
                    <!-- Datatable -->
                    <script src="../assets/datatable/vfs_fonts.js"></script>
                    <script src="../assets/datatable/jszip.min.js"></script>
                    <script src="../assets/datatable/jquery-3.5.1.js"></script>
                    <script src="../assets/datatable/jquery.dataTables.min.js"></script>
                    <script src="../assets/datatable/dataTables.buttons.min.js"></script>
                    <script src="../assets/datatable/buttons.print.min.js"></script>
                    <script src="../assets/datatable/buttons.html5.min.js"></script>
                    <script src="../assets/datatable/pdfmaker.js"></script>
                    <script src="../assets/datatable/pdfvfont.js"></script>
                    <script>
                       $('#example_model').DataTable({
                        "pageLength": 15,
                        dom: 'Bfrtip',
                        buttons:  [{
                            extend: 'copy',

                        },{
                            extend: 'excel',

                        },{
                            extend: 'pdf',

                        }, {
                            extend: 'print',

                        }
                        ]
                    });

                </script>
                <?php 
            }
/////////////////////View Indoor Record//////////////////
///////////////////////////////////////////////
        if (isset($_POST['view_indoor_private_records_reports'])) {
    $view_indoor_records = $_POST['view_indoor_private_records_reports'];
    $whichone            = $_POST['whichone'];
    $date_from           = $_POST['date_from'];
    $date_to             = $_POST['date_to'];
    $sr_no               = 1;
    ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr style="background: lightgrey;">
                <th colspan="8" class="text-center">Indoor</th>
            </tr>
            <tr>
                <th>Sr No</th>
                <th>Patient</th>
                <th>Case</th>
                <th>Admission Date</th>
                <th>Discharge Date</th>
                <th>Total Payment</th>
                <th>Doctor Fee</th>
                <th>Hospital Share</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fetch_data = "
                SELECT 
                    p.pi_id,
                    pr.Name,
                    ci.Title,
                    p.Paid,
                    p.admit_date,
                    p.exit_date,
                    d.D_Fee,
                    p.Paid - all_docs.total_fee AS hospital_share
                FROM ssh_p_indoor p
                JOIN ssh_p_indoor_doctors d ON p.pi_id = d.pi_id
                LEFT JOIN ssh_cases_indoor ci ON ci.S_ID = p.S_ID
                LEFT JOIN ssh_p_reg pr ON pr.P_ID = p.P_ID
                JOIN (
                    SELECT pi_id, SUM(D_Fee) AS total_fee
                    FROM ssh_p_indoor_doctors
                    GROUP BY pi_id
                ) all_docs ON p.pi_id = all_docs.pi_id
                WHERE d.to_paid = '1'
                  AND p.admition_type = '" . $whichone . "'
                  AND CONVERT(p.admit_date, DATE) BETWEEN '" . $date_from . "' AND '" . $date_to . "'
                  AND d.D_ID = '" . $view_indoor_records . "'
            ";

            $fetch_data_ex = mysqli_query($con, $fetch_data);

            $total_paid           = 0;
            $total_doctor_fee     = 0;
            $total_hospital_share = 0;

            foreach ($fetch_data_ex as $row) { ?>
                <tr>
                    <td><?php echo $sr_no ?></td>
                    <td><?php echo $row['Name'] ?></td>
                    <td><?php echo $row['Title'] ?></td>
                    <td><?php echo !empty($row['admit_date']) ? date('d-M-Y', strtotime($row['admit_date'])) : '-' ?></td>
                    <td><?php echo !empty($row['exit_date'])  ? date('d-M-Y', strtotime($row['exit_date']))  : 'Not Discharged' ?></td>
                    <td><?php echo $row['Paid'] ?></td>
                    <td><?php echo $row['D_Fee'] ?></td>
                    <td><?php echo $row['hospital_share'] ?></td>
                </tr>
                <?php
                $sr_no++;
                $total_paid           += $row['Paid'];
                $total_doctor_fee     += $row['D_Fee'];
                $total_hospital_share += $row['hospital_share'];
            }
            ?>
        </tbody>
        <tfoot>
            <tr style="background: lightgrey; text-align: center; font-weight: bold;">
                <td colspan="5">Totals</td>
                <td><?php echo $total_paid ?></td>
                <td><?php echo $total_doctor_fee ?></td>
                <td><?php echo $total_hospital_share ?></td>
            </tr>
        </tfoot>
    </table>
    <?php
}
/////////////////////Insert Doctor Payment//////////////////
///////////////////////////////////////////////
        if (isset($_POST['doctor_paid_oudoor'])) {
            $doctor_paid_oudoor = $_POST['doctor_paid_oudoor'];
            $get_total_payment = $_POST['get_total_payment'];
            $hospitalshare = $_POST['hospitalshare'];
            $payment_date = $_POST['payment_date'];
            $view_data = " Insert into ssh_dr_payment(payment,Date,Status,notification,D_ID) values('".$get_total_payment."','".$payment_date."','0','1','".$doctor_paid_oudoor."')";
            $view_data_ex = mysqli_query($con,$view_data);
            $insert_data_h_s = "INSERT INTO ssh_dr_payment(Date,D_ID,Payment) VALUES('".date('Y-m-d')."','0','".$hospitalshare."')";
                $insert_data_h_s_ex = mysqli_query($con,$insert_data_h_s);
            }
        ?>