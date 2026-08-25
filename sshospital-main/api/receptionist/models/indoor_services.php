<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
/////////////////////Del Doctor Fee //////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_fee_del'])) {
    $ser_ID = $_POST['doctor_fee_del'];
    $del_data = "UPDATE ssh_docsetting_indoor SET close='0' WHERE ds_id='".$ser_ID."' ";
    $del_data_ex = mysqli_query($con,$del_data);
    if ($del_data_ex) {
       echo 'true';
   }else{
       echo 'false';
   }
}
/////////////////////Validate Services//////////////////
///////////////////////////////////////////////
if (isset($_POST['case_id'])) {
    $case_id = $_POST['case_id'];
    $doc_id = $_POST['doc_id'];
    $val_data = "Select * from ssh_docsetting_indoor where S_ID = '".$case_id."' AND D_ID = '".$doc_id."' AND close = '1'";
    $val_data_ex = mysqli_query($con,$val_data);
    if (mysqli_num_rows($val_data_ex) > 0) {
       echo 'false';
    }else{
       echo 'true';
    }
}
/////////////////////Update Service//////////////////
///////////////////////////////////////////////
if (isset($_POST['services_update'])) {
    $s_ID = $_POST['services_update'];
    $view_data = "Select * from ssh_cases_indoor where S_ID = '".$s_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ser_id_update" value="<?php echo $row['S_ID'] ?>">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Case Title <span style="color: red;"> *</span></label>
                        <input type="text" class="form-control" name="ser_title_u" value="<?php echo $row['Title']; ?>" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">Hospital Share <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" name="ser_charges_u" value="<?php echo $row['Charges']; ?>" required>
                    </div>
                    
                </div>   
                <div class="col-md-12 text-right">
                    <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
            </div>
        </form>
    <?php }
}
/////////////////////Del Services//////////////////
///////////////////////////////////////////////
if (isset($_POST['services_del'])) {
	$ser_ID = $_POST['services_del'];
	$del_data = "UPDATE ssh_cases_indoor SET close='0' WHERE S_ID='".$ser_ID."' ";
    $del_data_ex = mysqli_query($con,$del_data);
    if ($del_data_ex) {
       echo 'true';
   }else{
       echo 'false';
   }
}
?>