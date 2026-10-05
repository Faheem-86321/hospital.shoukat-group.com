<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
/////////////////////Insert Doctor Payment//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_paid_indoor'])) {
    $doctor_paid_indoor = $_POST['doctor_paid_indoor'];
    $get_total_payment = $_POST['get_total_payment'];
    $whichone = $_POST['whichone'];
    $view_data = " Insert into ssh_dr_payment_indoor(payment,Date,D_ID) values('".$get_total_payment."','".Date('Y-m-d')."','".$doctor_paid_indoor."')";
    $view_data_ex = mysqli_query($con,$view_data);
    if ($view_data_ex) {
        $fetch_data2 = "Select * from ssh_p_indoor where admition_type = '".$whichone."' ";
        $fetch_data2_ex = mysqli_query($con,$fetch_data2);
        foreach($fetch_data2_ex as $row){
            $del_data = "UPDATE ssh_p_indoor_doctors SET to_paid='1' WHERE D_ID ='".$doctor_paid_indoor."' AND pi_id = '".$row['pi_id']."' ";
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
    <table class="table table-striped table-bordered">
        <thead><tr style="background: lightgrey;">
            <th colspan="3" class="text-center">Indoor Private</th>
             </tr>
        <tr>
            <th>Patient</th>
            <th>Case</th>
            <th>Doctor Fee</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_cases_indoor ON ssh_cases_indoor.S_ID = ssh_p_indoor.S_ID  LEFT JOIN ssh_p_reg ON ssh_p_reg.P_ID = ssh_p_indoor.P_ID  WHERE ssh_p_indoor_doctors.D_ID ='".$view_indoor_records."' AND ssh_p_indoor.admition_type = '".$whichone."' AND ssh_p_indoor_doctors.to_paid = '0' ";
        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ ?>
            <tr>
                <td><?php echo $row['Name'] ?></td>
                <td><?php echo $row['Title'] ?></td>
                <td><?php echo $row['D_Fee'] ?></td>
            </tr>
            
            <?php
            $total += $row['D_Fee'];
        }
        ?>
    </tbody>
    <tfoot>
        <tr style="background: lightgrey;text-align: center;">
            <td></td>
            <td><b>Total Indoor Payment: </b> </td>
            <td><?php echo $total ?></td>
        </tr>
    </tfoot>
</table>
    <?php 
}
/////////////////////View Indoor Record//////////////////
///////////////////////////////////////////////
if (isset($_POST['view_indoor_private_records_reports'])) {
    $view_indoor_records = $_POST['view_indoor_private_records_reports'];
    $whichone = $_POST['whichone'];
    $total = 0;
    ?>
    <table class="table table-striped table-bordered">
        <thead><tr style="background: lightgrey;">
            <th colspan="3" class="text-center">Indoor Private</th>
             </tr>
        <tr>
            <th>Patient</th>
            <th>Case</th>
            <th>Doctor Fee</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id LEFT JOIN ssh_cases_indoor ON ssh_cases_indoor.S_ID = ssh_p_indoor.S_ID  LEFT JOIN ssh_p_reg ON ssh_p_reg.P_ID = ssh_p_indoor.P_ID  WHERE ssh_p_indoor_doctors.D_ID ='".$view_indoor_records."' AND ssh_p_indoor.admition_type = '".$whichone."' AND ssh_p_indoor_doctors.to_paid = '1' ";
        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ ?>
            <tr>
                <td><?php echo $row['Name'] ?></td>
                <td><?php echo $row['Title'] ?></td>
                <td><?php echo $row['D_Fee'] ?></td>
            </tr>
            
            <?php
            $total += $row['D_Fee'];
        }
        ?>
    </tbody>
    <tfoot>
        <tr style="background: lightgrey;text-align: center;">
            <td></td>
            <td><b>Total Indoor Payment: </b> </td>
            <td><?php echo $total ?></td>
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
    $payment_date = $_POST['payment_date'];
    $view_data = " Insert into ssh_dr_payment(payment,Date,Status,notification,D_ID) values('".$get_total_payment."','".$payment_date."','0','1','".$doctor_paid_oudoor."')";
    $view_data_ex = mysqli_query($con,$view_data);
    $insert_data_h_s = "INSERT INTO ssh_dr_payment(Date,D_ID,Payment) VALUES('".date('Y-m-d')."','0','".$hospitalshare."')";
    $insert_data_h_s_ex = mysqli_query($con,$insert_data_h_s);
}
?>