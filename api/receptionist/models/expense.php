<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
/////////////////////Update expense_update//////////////////
///////////////////////////////////////////////
if (isset($_POST['expense_update'])) {
    $s_ID = $_POST['expense_update'];
    $view_data = "Select * from ssh_expenses where Voucher = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
               
       <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                         <input type="hidden" name="ser_id_update" value="<?php echo $row['Voucher'] ?>">
                        <div class="form-group col-md-12">
                            <label for="name">Title <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" value="<?php echo $row['Title'] ?>" name="ex_title_u" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Amount<span style="color: red;"> *</span></label>
                            <input type="number" class="form-control" value="<?php echo $row['Amount'] ?>" name="ex_price_u" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Date <span style="color: red;"> *</span></label>
                            <input type="date" class="form-control" value="<?php echo $row['Date'] ?>" name="ex_date_u" required>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                        </div>  
                    </div>
                </form>
    <?php }
}
/////////////////////Del expense_del//////////////////
///////////////////////////////////////////////
if (isset($_POST['expense_del'])) {
	$ser_ID = $_POST['expense_del'];
	$del_data = "DELETE FROM ssh_expenses where Voucher='".$ser_ID."'";
    $del_data_ex = mysqli_query($con,$del_data);
    if ($del_data_ex) {
       echo 'true';
   }else{
       echo 'false';
   }
}
/////////////////////Del assets del//////////////////
///////////////////////////////////////////////
if (isset($_POST['assets_del'])) {
    $ser_ID = $_POST['assets_del'];
    $del_data = "DELETE FROM ssh_assets where A_ID='".$ser_ID."'";
    $del_data_ex = mysqli_query($con,$del_data);
    if ($del_data_ex) {
       echo 'true';
   }else{
       echo 'false';
   }
}

?>