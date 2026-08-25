<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
/////////////////////Update X-Type//////////////////
///////////////////////////////////////////////
if (isset($_POST['d_inventory_update'])) {
    $s_ID = $_POST['d_inventory_update'];
    $view_data = "Select * from dialysis_item where di_id = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ser_id_update_d" value="<?php echo $row['di_id'] ?>">
                <div class="row">
                    <div class="form-group col-md-12">
                            <label for="name">Last Updated <sub style="color: green;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                            <input type="date" class="form-control" value="<?php echo $row['last_update'] ?>" name="" required readonly>
                        </div>
                         <div class="form-group col-md-12">
                            <label for="name">Expense <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" value="" name="expense_d" required>
                        </div>
                     <div class="form-group col-md-12">
                            <label for="name">Available <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" value="<?php echo $row['stock'] ?>" name="available_sheet_d" required>
                        </div>
                     
                <div class="col-md-12 text-right">
                    <button type="submit" name="d_pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
            </div>
        </form>
    <?php }
}
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
if (isset($_POST['ct_inventory_update'])) {
    $s_ID = $_POST['ct_inventory_update'];
    $view_data = "Select * from ssh_ser_inv where ID = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ser_id_update_ct" value="<?php echo $row['ID'] ?>">
                <div class="row">
                    <div class="form-group col-md-12">
                            <label for="name">Last Updated <sub style="color: green;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                            <input type="date" class="form-control" value="<?php echo $row['last_date'] ?>" name="" required readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name">Expense <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" value="" name="expense_ct" required>
                        </div>
                     <div class="form-group col-md-12">
                            <label for="name">Available <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" value="<?php echo $row['Stock'] ?>" name="available_sheet_ct" required>
                        </div>
                     
                <div class="col-md-12 text-right">
                    <button type="submit" name="ct_pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
            </div>
        </form>
    <?php }
}
/////////////////////Update X-Type//////////////////
///////////////////////////////////////////////
if (isset($_POST['x_inventory_update'])) {
    $s_ID = $_POST['x_inventory_update'];
    $view_data = "Select * from ssh_ser_inv where ID = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ser_id_update" value="<?php echo $row['ID'] ?>">
                <div class="row">
                    <div class="form-group col-md-12">
                            <label for="name">Last Updated <sub style="color: green;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                            <input type="date" class="form-control" value="<?php echo $row['last_date'] ?>" name="" required readonly>
                        </div>
                         <div class="form-group col-md-12">
                            <label for="name">Expense <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" value="" name="expense_x" required>
                        </div>
                     <div class="form-group col-md-12">
                            <label for="name">Available <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" value="<?php echo $row['Stock'] ?>" name="available_sheet" required>
                        </div>
                     
                <div class="col-md-12 text-right">
                    <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
            </div>
        </form>
    <?php }
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