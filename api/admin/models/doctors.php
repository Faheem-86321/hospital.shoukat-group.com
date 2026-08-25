<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
/////////////////////Update Doctor//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_update'])) {
    $D_ID = $_POST['doctor_update'];
    $view_data = "Select * from ssh_dr_reg where D_ID = '".$D_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="doc_id_update" value="<?php echo $row['D_ID'] ?>">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Name <span style="color: red;"> *</span></label>
                        <input type="text" class="form-control" value="<?php echo $row['Name']; ?>"  name='doc_name_u' required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">DOB <span style="color: red;"> *</span></label>
                        <input type="date" class="form-control" value="<?php echo $row['DOB']; ?>" name='doc_dob_u'  required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Address <span style="color: red;"> *</span></label>
                        <textarea type="text" class="form-control"  name='doc_address_u'  required><?php echo $row['Address']; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Phone <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" name='doc_phone_u' value="<?php echo $row['Phone']; ?>"   required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Gender <span style="color: red;"> *</span></label>
                        <select class="form-control"  name="doc_gender_u"   required>
                            <option value="<?php echo $row['Gender']; ?>"  selected style="text-align: center;"><?php echo $row['Gender']; ?></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Joining Date <span style="color: red;"> *</span></label>
                        <input type="date" class="form-control" name='doc_doj_u' value="<?php echo $row['DOJ']; ?>"  required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Date of Relieving</label>
                        <input type="date" class="form-control" name='doc_dor_u' value="<?php echo $row['DOR']; ?>"  >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">CNIC<sub style="color: green;">(Without Dashes)</sub> <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" readonly required value="<?php echo $row['CNIC']; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">Time of Duty-From<span style="color: red;"> *</span></label>
                        <input type="time" class="form-control" name='doc_tod_u' value="<?php echo $row['TOD']; ?>"  required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">Time of Duty-To<span style="color: red;"> *</span></label>
                        <input type="time" class="form-control" name="doc_tod_to_u" value="<?php echo $row['TOD_TO']; ?>" required>
                    </div>
                     <div class="form-group col-md-12">
                        <label for="name">Duty Days<span style="color: red;"> *</span></label>
                        <textarea class="form-control" name="doc_dutydays_u" required><?php echo $row['duty_days']; ?></textarea>
                        <!-- <input type="time" class="form-control" name="doc_dutydays" required> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label>Qualification</label>
                        <textarea type="text" class="form-control" name='doc_qualification_u' ><?php echo $row['Qualification']; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Expertise</label>
                        <textarea type="text" class="form-control" name='doc_expertise_u' ><?php echo $row['Expertise']; ?></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Outdoor Doctor Shares</label>
                        <input type="number" class="form-control" name='doc_wages_u'  value="<?php echo $row['Wages']; ?>" >
                    </div>
                    <div class="form-group col-md-4">
                        <label>Outdoor Hospital Shares</label>
                        <input type="number" class="form-control" name='doc_shares_u' value="<?php echo $row['Shares']; ?>" >
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total Fee <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" value="<?php echo $row['Shares']+$row['Wages'] ; ?>" id="" readonly  name="" required>
                    </div>
                </div>   
                <div class="col-md-12 text-right">
                    <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
            </div>
        </form>
    <?php }
}
/////////////////////View Doctor//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_view'])) {
    $D_ID = $_POST['doctor_view'];
    $view_data = "Select * from ssh_dr_reg where D_ID = '".$D_ID."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
        <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-lg-12">
                                    <label for="lastname">Profile Picture <span style="color: red;"> *</span></label>
                                    <?php if(empty($row['Picture'])){ ?>
                                        <img src="../images/avatar.png" height='200px' width='200px'>
                                    <?php }else{ ?>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['Picture']); ?>" height='200px' width='200px'>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name <span style="color: red;"> *</span></label>
                                        <input type="text" class="form-control" value="<?php echo $row['Name']; ?>" readonly required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name">DOB <span style="color: red;"> *</span></label>
                                        <input type="date" class="form-control" value="<?php echo $row['DOB']; ?>" readonly  required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Address <span style="color: red;"> *</span></label>
                                        <textarea type="text" class="form-control"  readonly  required style="height: 115px;"><?php echo $row['Address']; ?></textarea>
                                    </div>
                                </div>    
                            </div>    
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Phone <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" value="<?php echo $row['Phone']; ?>" readonly  required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Gender <span style="color: red;"> *</span></label>
                        <select class="form-control"  name="doc_gender"  readonly required>
                            <option value="" disabled selected style="text-align: center;"><?php echo $row['Gender']; ?></option>
                            
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Joining Date <span style="color: red;"> *</span></label>
                        <input type="date" class="form-control" value="<?php echo $row['DOJ']; ?>" readonly required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Date of Relieving </label>
                        <input type="date" class="form-control" value="<?php echo $row['DOR']; ?>" readonly >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">CNIC<sub style="color: green;">(Without Dashes)</sub> <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" readonly required value="<?php echo $row['CNIC']; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">Time of Duty-From<span style="color: red;"> *</span></label>
                        <input type="time" class="form-control" name='' readonly value="<?php echo $row['TOD']; ?>"  required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">Time of Duty-To<span style="color: red;"> *</span></label>
                        <input type="time" class="form-control" name="" readonly value="<?php echo $row['TOD_TO']; ?>" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">Duty Days<span style="color: red;"> *</span></label>
                        <textarea class="form-control" name="" required><?php echo $row['duty_days']; ?></textarea>
                        <!-- <input type="time" class="form-control" name="doc_dutydays" required> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label>Qualification</label>
                        <textarea type="text" class="form-control" readonly><?php echo $row['Qualification']; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Expertise</label>
                        <textarea type="text" class="form-control"  readonly><?php echo $row['Expertise']; ?></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Outdoor Doctor Shares</label>
                        <input type="number" class="form-control" name='' readonly value="<?php echo $row['Wages']; ?>" >
                    </div>
                    <div class="form-group col-md-4">
                        <label>Outdoor Hospital Shares</label>
                        <input type="number" class="form-control" name='' readonly value="<?php echo $row['Shares']; ?>" >
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total Fee <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" readonly value="<?php echo $row['Shares']+$row['Wages'] ; ?>" id="" readonly  name="" required>
                    </div>
                </div>   
            </div>
        </form>
    <?php }
}
/////////////////////Del Doctor//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_del'])) {
	$D_ID = $_POST['doctor_del'];
    $update_data = "UPDATE ssh_dr_reg SET status = '0'  WHERE D_ID='".$D_ID."' ";
    $update_data_ex = mysqli_query($con,$update_data);
    if ($update_data_ex) {
       echo 'true';
   }else{
       echo 'false';
   }
}
/////////////////////Validate Doctor//////////////////
///////////////////////////////////////////////
if (isset($_POST['doctor_validate'])) {
    $CNIC = $_POST['doctor_validate'];
    $val_data = "Select CNIC from ssh_dr_reg where CNIC = '".$CNIC."'";
    $val_data_ex = mysqli_query($con,$val_data);
    if (mysqli_num_rows($val_data_ex) > 0 ) {
       echo 'true';
   }else{
       echo 'false';
   }
}
?>