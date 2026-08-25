<?php
ob_start();
session_start();
include_once("../../env/main_config.php");

/////////////////////Update charges//////////////////
///////////////////////////////////////////////
if (isset($_POST['charges_update'])) {
    $charges_update = $_POST['charges_update'];
    $view_data = "Select ssh_p_reg.Name AS p_name, ssh_p_dpr.MRN,ssh_p_dpr.Charges,ssh_p_dpr.Paid, ssh_dr_reg.Name AS d_name,ssh_dr_reg.Shares,ssh_dr_reg.Wages From ssh_p_dpr
    LEFT JOIN ssh_p_reg
    ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID 
    LEFT JOIN ssh_dr_reg
    ON ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
    Where ssh_p_dpr.MRN = '".$charges_update."' ";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ 
        $total_value = $row['Wages'] + $row['Shares']; 
        $p_value = $row['Charges'] - $row['Shares']; 
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="alert alert-success col-md-6 " style="border-right: 4px solid white;">
                    <?php echo "<b>MRN</b> : ".$row['MRN']."<br><b>Patient</b> : ".$row['p_name']; ?>
                    <input type="hidden" name="p_r_id" id="p_r_id" value="<?php echo $row['MRN']; ?>">
                </div>
                <div class="alert alert-success col-md-6  ">
                    <?php echo "<b>Doctor</b> : <br>".$row['d_name']; ?>
                </div>
                
                <div class="form-group col-md-12">
                    <label for="name"> Discount <span style="color: red;"> *</span></label>
                    <input type="number" class="form-control" onkeyup="pat_discount();" value="<?php echo $row['Charges']-$row['Paid']; ?>" name='pat_paid' id='new_discount'  required min="0">
                </div>
                <div class="form-group col-md-12">
                    <label for="name"> Total Paid <sub style="color: green !important;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                    <input type="number" class="form-control" value="<?php echo $row['Paid']; ?>" name='paid_u' id='paid'  required readonly>
                    <input type="hidden" class="form-control" value="<?php echo $row['Charges'] ; ?>" name='' id='total_paid'  required readonly>
                </div>
                <script type="text/javascript">
                    function pat_discount() {
                    var shares = $("#total_paid").val();
                    var new_discount = $("#new_discount").val();
                    var getdis = parseInt(shares) - parseInt(new_discount) ;
                    $("#paid").val(getdis);
                }
            </script>
            </div>
            <div class="col-md-12 text-right">
                    <button type="submit" name="priceupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
        </form>    
    <?php } 
}
/////////////////////Get Patient Info //////////////////
///////////////////////////////////////////////
if (isset($_POST['get_doctor_info'])) {
    $get_doctor_info = $_POST['get_doctor_info'];
    $view_data = "Select * from ssh_p_reg where P_ID = '".$get_doctor_info."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ 
        ?>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="name">Name <span style="color: red;"> *</span></label>
                <input type="text" class="form-control" value="<?php echo $row['Name'] ?>" name="pat_Name_update" required>
            </div>
           <!--  <div class="form-group col-md-6">
                <label for="name">CNIC <span style="color: red;"> *</span></label>
                <input type="text" class="form-control" value="<?php echo $row['CNIC'] ?>" name="pat_CNIC_upate" required>
            </div> -->
            <div class="form-group col-md-6">
                <label for="name">Age <span style="color: red;"> *</span></label>
                <input type="number" class="form-control" value="<?php echo $row['age'] ?>" name="pat_Age_update" required>
            </div>
            <div class="form-group col-md-6">
                <label for="name">Phone <span style="color: red;"> *</span></label>
                <input type="number" class="form-control" value="<?php echo $row['phone'] ?>" name="pat_Phone_update" required>
            </div>
            <div class="form-group col-md-6">
                <label>Gender <span style="color: red;"> *</span></label>
                <select class="form-control"  name="pat_gender_update" required>
                    <option value="<?php echo $row['gender'] ?>"  selected style="text-align: center;"><?php echo ucwords($row['gender']) ;?></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

    <?php }
}
/////////////////////Get Doctor Info //////////////////
///////////////////////////////////////////////
if (isset($_POST['get_doctor_fee'])) {
    $get_doctor_fee = $_POST['get_doctor_fee'];
    $view_data = "Select * from ssh_dr_reg where D_ID = '".$get_doctor_fee."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ 
        $total_value = $row['Wages'] + $row['Shares']; 
        ?>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="name"> Hospital Share <sub style="color: green !important;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                <input type="hidden" name="charges" id="charges" value="<?php echo $total_value; ?>">
                <input type="number" id="shares" class="form-control" value="<?php echo $row['Shares']; ?>"  name='pat_charges' required readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="name"> Doctor Share <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" class="form-control" onkeyup="" value="<?php echo $row['Wages']; ?>" name='d_pay' id='pat_paid'  required min="0" readonly >
            </div>
            <div class="form-group col-md-12">
                <label for="name"> Total Payable <sub style="color: green !important;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                <input type="number" class="form-control" value="<?php echo $total_value; ?>" name='paid' id='paid'  required readonly>
            </div>
            <script type="text/javascript">
                function pat_discount() {
                    var pat_paid = $("#pat_paid").val();
                    var shares = $("#shares").val();
                    var getdis = parseInt(shares) + parseInt(pat_paid);
                    $("#paid").val(getdis);
                }
            </script>
        </div>   

    <?php }
}
?>