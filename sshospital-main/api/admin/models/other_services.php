<?php
ob_start();
session_start();
include_once("../../env/main_config.php");

/////////////////////View Patient Info for services//////////////////
///////////////////////////////////////////////
if (isset($_POST['view_services_records'])) {
    $s_ID = $_POST['view_services_records'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to']; ?>
    <table class="table table-striped table-bordered col-md-12">
        <thead><tr style="background: lightgrey;">
            <th colspan="7" class="text-center">Services Patients</th>
        </tr>
        <tr>
            <th>Sr No.</th>
            <th>Patient</th>
            <th>Date</th>
            <th>Case</th>
            <th>Total Paid</th>
            <th>Discount</th>
            <th>Added By</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sr_no = 1;
        $view_data = "SELECT *,ssh_p_reg.Name AS Name,ssh_ser_inv.Title AS Title,ssh_p_services.Paid As Paid,ssh_p_services.Discount As Discount,ssh_p_services.Date As Date From ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID LEFT JOIN ssh_p_reg ON ssh_p_services.P_ID = ssh_p_reg.P_ID LEFT JOIN wt_users ON wt_users.id = ssh_p_services.user_id WHERE CONVERT(ssh_p_services.Date,Date) BETWEEN '".$date_from."' AND '".$date_to."' AND  ssh_ser_inv.ID = '".$s_ID."'";
        $view_data_ex = mysqli_query($con,$view_data);
        foreach($view_data_ex as $row){ ?>

            <tr>
                <td><?php echo $sr_no ?></td>
                <td><?php echo $row['Name'] ?></td>
                <td><?php echo date('Y-m-d H:i:s',strtotime($row['Date'])) ?></td>
                <td><?php echo $row['Title'] ?></td>
                <td><?php echo $row['Paid'] ?></td>
                <td><?php echo $row['Discount'] ?></td>
                <td><?php echo $row['fname'] ?></td>
                
            </tr>
            
            <?php
            $sr_no++;
            
        }
        ?>

    </tbody>
</table>
<?php }
?>
<?php

/////////////////////Update Ser Fee//////////////////
///////////////////////////////////////////////
if (isset($_POST['get_ser_fee'])) {
    $s_ID = $_POST['get_ser_fee'];
    $view_data = "Select * from ssh_ser_cat where C_ID = '".$s_ID."' ";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ 
        echo $row['charges'];
    }
}


/////////////////////Update X-Type//////////////////
///////////////////////////////////////////////
if (isset($_POST['x_type_update'])) {
    $s_ID = $_POST['x_type_update'];
    $view_data = "Select * from ssh_ser_cat where C_ID = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ser_id_update" value="<?php echo $row['C_ID'] ?>">
            <div class="row">
               <div class="form-group col-md-12">
                <label for="name">Title <span style="color: red;"> *</span></label>
                <input type="text" class="form-control" value="<?php echo $row['Name'] ?>" name="ser_title_u" required>
            </div>
            <div class="form-group col-md-6">
                <label for="name">Price<span style="color: red;"> *</span></label>
                <input type="number" class="form-control" value="<?php echo $row['charges'] ?>" name="ser_price_u" required>
            </div>
            <div class="form-group col-md-6">
                <label for="name">Number of Films <span style="color: red;"> *</span></label>
                <input type="number" class="form-control" value="<?php echo $row['sets'] ?>" name="ser_sheets_u" required>
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
            </div>
        </div>
    </form>
<?php }
}

/////////////////////Del Patient Services//////////////////
///////////////////////////////////////////////
if (isset($_POST['service_del'])) {
    $ser_ID = $_POST['service_del'];
    $del_data = "DELETE FROM ssh_p_services where ser_p_id='".$ser_ID."'";
    $del_data_ex = mysqli_query($con,$del_data);
    if ($del_data_ex) {
     echo 'true';
 }else{
     echo 'false';
 }
}
?>