<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
//////////////////////////////////////////////////
/////////////////*Pay Roll*//////////////////////
////////////////////////////////////////////////
if (isset($_POST['payment_cash'])) {
    $payment_cash = $_POST['payment_cash'];
    $fetch_data = "SELECT (IF(SUM(ssh_p_dpr.Paid) IS NULL, 0, SUM(ssh_p_dpr.Paid))+(SELECT IF(SUM(ssh_p_services.Paid) IS NULL, 0, SUM(ssh_p_services.Paid)) FROM ssh_p_services)+(SELECT IF(SUM(ssh_p_indoor.Paid) IS NULL, 0, SUM(ssh_p_indoor.Paid)) FROM ssh_p_indoor WHERE ssh_p_indoor.S_ID!=0))-((SELECT IF(SUM(ssh_dr_payment.Payment) IS NULL, 0, SUM(ssh_dr_payment.Payment)) FROM ssh_dr_payment)+(SELECT IF(SUM(payments.p_credit) IS NULL, 0, SUM(payments.p_credit)) FROM payments) + (SELECT IF(SUM(ssh_expenses.Amount) IS NULL, 0, SUM(ssh_expenses.Amount)) FROM ssh_expenses)) AS total FROM ssh_p_dpr LEFT JOIN ssh_dr_reg ON ssh_p_dpr.D_ID = ssh_dr_reg.D_ID";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $rowcash){
        $cashinhand = number_format((float)$rowcash['total'], 2, '.', '');  
    }
    if ($cashinhand < $payment_cash) {
        echo 'false';
    }else{
        echo 'true';
    }
}
if (isset($_POST['payroll_edit'])) {
    $payroll_id = $_POST['payroll_edit'];
    $employee_id = $_POST['employee_id'];
    $update_query = "SELECT * FROM payments WHERE p_id = '".$payroll_id."'";
    $update_query_ex = mysqli_query($con,$update_query);
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <?php 
                foreach ($update_query_ex as $row) {

                ?>
                    <div class="form-group col-md-6">
                        <label >Date </label>
                        <input value="<?php echo $row['p_date'] ?>" type="date" class="form-control" disabled = "disabled">
                    </div>
                    <div class="form-group col-md-6">
                        <label >Purpose </label>
                        <input value="<?php echo $row['p_purpose'] ?>" type="text" class="form-control" disabled = "disabled">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="hidden" name="payroll_id" value="<?php echo $payroll_id ?>">
                        <input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">
                        <label >Debit </label>
                        <input id="c_mess" value="<?php echo $row['p_debit'] ?>" type="number" class="form-control" name="p_debit">
                    </div>
                    <div class="form-group col-md-6">
                        <label >Credit </label>
                        <input id="c_extra" value="<?php echo $row['p_credit'] ?>" type="number" class="form-control" name="p_credit">
                    </div>
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <input id="submitUp" type="submit" name="updatep" class="btn btn-success form-group" style="float: right; margin-right:5%; border-radius: 10px; padding: 12px 30px;" value="Update">
                        </div>    
                    </div>

                <?php
                }
                ?>
        </div>
    </form>
<?php   
}

   if (isset($_POST['employee_payment_delete'])) {
      $payment_id = $_POST['employee_payment_delete'];
      /*$id = $_POST['employee_id'];*/
      $close = 0;
      $delete_query = "UPDATE payments set close = '".$close."' WHERE p_id = '".$payment_id."'";
     $delete_query_ex = mysqli_query($con,$delete_query);
  }

?>