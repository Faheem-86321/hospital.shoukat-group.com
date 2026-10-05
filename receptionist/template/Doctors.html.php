<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Doctor </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Doctor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div> 
<button id="viewinfobutton" hidden class="btn " data-toggle="modal" data-target="#viewinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> View Doctor </button>
<div class="modal fade" id="viewinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> View Doctor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody2">
            </div>    
        </div>
    </div>
</div>                    
<!-- Modal -->
<div class="modal fade" id="add-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Register Doctor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
               <form action="" method="post" enctype="multipart/form-data">
               <?php  $_SESSION["token"] = bin2hex(random_bytes(32)); ?>
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-lg-12">
                                    <label for="lastname">Profile Picture</label>
                                    <input type="file" data-plugins="dropify"  data-max-file-size="1M" name="userImage" placeholder="Enter" />

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name <span style="color: red;"> *</span></label>
                                        <input type="text" class="form-control" name="doc_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name">DOB <span style="color: red;"> *</span></label>
                                        <input type="date" class="form-control" name="doc_dob" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Address <span style="color: red;"> *</span></label>
                                        <textarea type="text" class="form-control" name="doc_address" required style="height: 115px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group col-md-6">
                        <label for="name">Phone <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" name="doc_phone" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Gender <span style="color: red;"> *</span></label>
                        <select class="form-control"  name="doc_gender" required>
                            <option value="" disabled selected style="text-align: center;">--- Select Gender ---</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Joining Date <span style="color: red;"> *</span></label>
                        <input type="date" class="form-control" name="doc_joiningdate" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Date of Relieving</label>
                        <input type="date" class="form-control" name="doc_relievingdate" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">CNIC<sub style="color: green;">(Without Dashes)</sub> <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" onkeyup="validatecnic();" id="get_cnic" name="doc_cnic" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">Time of Duty-From<span style="color: red;"> *</span></label>
                        <input type="time" class="form-control" name="doc_timeofduty_from" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">Time of Duty-To<span style="color: red;"> *</span></label>
                        <input type="time" class="form-control" name="doc_timeofduty_to" required>
                    </div>
                     <div id="warnmsg1" class="col-md-12"></div>

                     <div class="form-group col-md-12">
                        <label for="name">Duty Days<span style="color: red;"> *</span></label>
                        <textarea class="form-control" name="doc_dutydays" required></textarea>
                        <!-- <input type="time" class="form-control" name="doc_dutydays" required> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label>Qualification</label>
                        <textarea type="text" class="form-control" name="doc_qualification"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Expertise</label>
                        <textarea type="text" class="form-control" name="doc_expertise"></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Outdoor Doctor Shares<span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" onkeyup="sumthis()" id="outdoor_share" value="0" name="doc_wages" required>
                    </div>
                    <!-- <div class="form-group col-md-4">
                        <label>Indoor Shares</label>
                        <input type="number" class="form-control" value="0" name="doc_indoor_shares">
                    </div> -->
                    <div class="form-group col-md-4">
                        <label>Outdoor Hospital Shares<span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" onkeyup="sumthis()" id="hospital_share" value="0" name="doc_shares" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total Fee <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" value="0" id="total_val" readonly  name="" required>
                    </div>
                    <script>
                        function sumthis() {
                            var idcus = $("#outdoor_share").val();
                            var idcus_op = $("#hospital_share").val();
                            $("#total_val").val(parseInt(idcus)+parseInt(idcus_op));


                        }
                    </script>
                </div>   
                <div class="col-md-12 text-right">
                    <button type="submit" name="psubmit" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
            </div>
        </form>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="col-xl-12  col-lg-12">
    <div class="card">
        <div class="card-body" dir="ltr">
            <button id="" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;" ><i class="mdi mdi-plus-circle mr-2"></i> Register Doctor</button>
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div id="cardCollpase4" class="collapse show"  >
                <div class="row bodyoftable" style="padding: 0px 4px !important;">
                    <div class="col-sm-12" style="padding: 0px 4px !important;">
                        <div class="card-box card-table-style" style="padding: 0px 4px !important;">
                            <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th  class="noExport">Option</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Expertise</th>
                                        <th>Date of Joining</th>
                                        <th>Duty Days</th>
                                        <th>Time of Duty</th>

                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $fetch_data = "SELECT ROW_NUMBER() OVER(ORDER BY (SELECT 1)) AS Sr,D_ID,CNIC,Name,Phone,DOJ,DOR,TOD,Expertise,duty_days FROM ssh_dr_reg Where status = '1' ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ ?>
                                            <tr id="<?php echo $row['D_ID']; ?>">
                                                <?php echo "<td>".$row['Sr']."</td>"; ?>
                                                <td>
                                                    <a class='btn btn-success btn-view' onclick="view_info(<?php echo $row['D_ID']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px;color: black; '><i class='fa fa-eye ' aria-hidden='true'></i></a>
                                                   
                                                    
                                                </td>
                                                <?php echo "<td>".$row['Name']."</td><td>".$row['Phone']."</td><td style='width:10px'>".$row['Expertise']."</td><td>".$row['DOJ']."</td><td style='width:10px'>".$row['duty_days']."</td><td>".$row['TOD']."</td>"; ?>
                                            </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div> <!-- end card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>    
        </div>
    </div> 
</div>       
<script type="text/javascript">
function update_info(idcus) {
    var idcus = idcus;
    $.ajax({
        type:"POST",
        url:"models/doctors.php",
        data: 'doctor_update='+idcus,
        success:function(data) {
            $('.modalbody1').html(data);
           $('#updateinfobutton').trigger('click');
        }
    });
};
function view_info(idcus) {
    var idcus = idcus;
    $.ajax({
        type:"POST",
        url:"models/doctors.php",
        data: 'doctor_view='+idcus,
        success:function(data) {
            $('.modalbody2').html(data);
           $('#viewinfobutton').trigger('click');
        }
    });
};
function delC(idcus) {
    var idcus = idcus;
    $.ajax({
        type:"POST",
        url:"models/doctors.php",
        data: 'doctor_del='+idcus,
        success:function(data) {
            var rowh = "#"+idcus;
            $(rowh).remove();
            Swal.fire(
              'Deleted!',
              'Record has been deleted.',
              'success'
              )
        }
    });
};
function validatecnic() {
    var no_c = $("#get_cnic").val();
    $.ajax({
        type:"POST",
        url:"models/doctors.php",
        data: 'doctor_validate='+no_c,
        success:function(data) {
            if(data == 'true'){
                $("#warnmsg1").html("<div class='alert alert-danger' style='text-align:center'><strong>Sorry This CNIC Already Exist!!</strong></div>");
                $("#errorbutton").attr('disabled',true);
            }else{
                $("#warnmsg1").empty();
                $("#errorbutton").attr('disabled',false);
            }
        }
    });
}
</script>   