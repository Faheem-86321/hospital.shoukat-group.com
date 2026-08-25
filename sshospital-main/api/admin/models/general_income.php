<?php
ob_start();
session_start();
include_once("../../env/main_config.php");

/////////////////////Update Payment//////////////////
///////////////////////////////////////////////
if (isset($_POST['expense_payment'])) {
    $s_ID = $_POST['expense_payment'];
    $view_data = "Select * from ssh_expenses where Voucher = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>

     <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
           <input type="hidden" name="ser_id_update" value="<?php echo $row['Voucher'] ?>">
           <div class="form-group col-md-12">
            <label for="name">Remaining Payment <span style="color: red;"> *</span></label>
            <input type="text" class="form-control" value="<?php echo $row['Amount']-$row['paid'] ?>" name="" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="name">Paid <span style="color: red;"> *</span></label>
            <input type="number" class="form-control" value="" name="paid" required>
        </div>
        <div class="form-group col-md-6">
            <label for="name">Update Payment Date<span style="color: red;"> *</span></label>
            <input type="date" class="form-control" value="" name="payment_date" required>
        </div> 
        <div class="col-md-12 text-right">
            <button type="submit" name="pupdate_payment" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
        </div>  
    </div>
</form>
<?php }
}
/////////////////////Update expense_update//////////////////
///////////////////////////////////////////////
if (isset($_POST['general_income_update'])) {
    $s_ID = $_POST['general_income_update'];
    $view_data = "Select * from ssh_general_income where i_id = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>

     <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
           <input type="hidden" name="ser_id_update" value="<?php echo $row['i_id'] ?>">
           <div class="form-group col-md-12">
            <label for="name">Title <span style="color: red;"> *</span></label>
            <input type="text" class="form-control" value="<?php echo $row['title'] ?>" name="ex_title_u" required>
        </div>
        <div class="form-group col-md-6">
            <label for="name">Amount<span style="color: red;"> *</span></label>
            <input type="number" class="form-control" value="<?php echo $row['income'] ?>" name="ex_price_u" required>
        </div>
        <div class="form-group col-md-6">
            <label for="name">Date <span style="color: red;"> *</span></label>
            <input type="date" class="form-control" value="<?php echo $row['created_at'] ?>" name="ex_date_u" required>
        </div>
        <div class="col-md-12 text-right">
            <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
        </div>  
    </div>
</form>
<?php }
}
/////////////////////Del general_income_del//////////////////
///////////////////////////////////////////////
if (isset($_POST['general_income_del'])) {
	$ser_ID = $_POST['general_income_del'];
	$del_data = "DELETE FROM ssh_general_income where i_id='".$ser_ID."'";
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
        $del_data1 = "DELETE FROM ssh_assets_types where A_id='".$ser_ID."'";
        $del_data1_ex = mysqli_query($con,$del_data1);
        echo 'true';
    }else{
     echo 'false';
 }
}
if (isset($_POST['assets_update'])) {
    $ser_ID = $_POST['assets_update'];
    $view_data = "Select * from ssh_assets where A_ID = '".$ser_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" value="<?php echo $row['A_ID'] ?>" name="as_a_id_u">
                <div class="form-group col-md-12">
                    <label for="name">Title <span style="color: red;"> *</span></label>
                    <input type="text" class="form-control" value="<?php echo $row['A_Name'] ?>" name="as_title_u" required>
                </div>
                <?php
                $view_data1 = "Select * from ssh_assets_types where A_id = '".$ser_ID."'";
                $view_data1_ex = mysqli_query($con,$view_data1);
                foreach($view_data1_ex as $row1){ 
                    ?>
                    <div class="form-group col-md-6">
                        <label for="name">Product <span style="color: red;"> *</span></label>
                        <input type="text" class="form-control" value="<?php echo $row1['name'] ?>" name="as_product_u[]" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Value<span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" value="<?php echo $row1['value'] ?>" name="as_price_u[]" required>
                    </div>
                <?php } ?>
                <div class="col-md-12" id="more_product_u"></div> 
                <div class="col-md-12">
                   <a onclick='addmoreproduct_u()' class='btn btn-success'  ><i class='fa fa-plus'></i></a>
               </div>
               <script type="text/javascript">
                   function addmoreproduct_u() {
                       $("#more_product_u").append("<div class='row'><div class='form-group col-md-6'><label for='name'>Product <span style='color: red;'> *</span></label><input type='text' class='form-control' name='as_product_u[]' required></div><div class='form-group col-md-6'><label for='name'>Value<span style='color: red;'> *</span></label><input type='number' class='form-control' name='as_price_u[]' required></div></div>")
                   }
               </script>
               <div class="col-md-12 text-right">
                <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
            </div>  
        </div>
    </form>

    <?php    
}
}

?>