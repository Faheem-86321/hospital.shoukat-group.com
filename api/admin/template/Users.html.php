<button id="modalbuttonopen" hidden class="btn " data-toggle="modal" data-target="#updateportal" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Credentials </button>
<div class="modal fade" id="updateportal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Credentials</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbuttonopen1">
            </div>    
        </div>
    </div>
</div>                    
<!-- Modal -->
<div class="modal fade" id="add-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
               <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-lg-6">
                        <label for="lastname">Profile Picture</label>
                        <input type="file" data-plugins="dropify"  data-max-file-size="1M" name="profile_pic" placeholder="Enter" />

                    </div>
                    <div class="col-md-3"></div>
                    <div class="form-group col-md-6">
                        <label for="name">First Name <span style="color: red;"> *</span></label>
                        <input type="text" class="form-control" name="fname" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Last Name</label>
                        <input type="text" class="form-control" name="lname">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Email address <span style="color: red;"> *</span></label>
                        <input type="email" class="form-control" onkeyup="checkvalidemail();" name="email" id="fetchemail" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="position">Phone</label>
                        <input type="number" class="form-control" id="position" name="phone">
                    </div>
                    <div id="warnmsg1" class="col-md-12"></div>
                    <div class="form-group col-md-12">
                        <label>Role <span style="color: red;"> *</span></label>
                        <select class="form-control" id="fetchrolename" onchange="selectusernamepassword();" name="role" required>
                            <option value="" disabled selected style="text-align: center;">--- Select Role ---</option>
                            <option value="employee">Other Employee</option>
                            <option value="receptionist">Receptionist</option>

                        </select>
                    </div>

                    <div id="fetch_regionselectbox" class="col-md-12" ></div>
                    <div class="form-group col-md-12">
                        <label for="position">Monthly Salary<span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" id="position" name="salary" required>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label>About</label>
                        <textarea type="text" class="form-control" id="category" name="about"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Address</label>
                        <textarea type="text" class="form-control" id="category" name="address"></textarea>
                    </div>
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
            <button id="" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;" ><i class="mdi mdi-plus-circle mr-2"></i> Add Employee</button>
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
                                        <th class="noExport">Sr No.</th>
                                        <th>Employee ID</th>
                                        <th  class="noExport">Option</th>
                                        <th>Name</th>
                                        <th class="noExport">Email</th>
                                        <th class="noExport">Phone</th>
                                        <th>Salary</th>
                                        <th class="noExport">About</th>
                                        <th class="noExport">Joining Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sr = 1;
                                    $db->Select("*");
                                    $db->From("wt_users");
                                    $db->Where("close = '1' AND status = '1' AND type != 'admin' ");
                                    $user_view= $db->result();
                                    foreach($user_view as $row){
                                        ?>
                                        <tr id="<?php echo $row['id'] ?>">
                                            <?php 
                                            echo "<td>".$sr."</td><td>".$row['id']."</td><td>";
                                            if ($row['type'] == 'receptionist' || $row['type'] == 'indoor_receptionist' ) {
                                            ?>
                                            <a class='btn btn-success btn-view' onclick="changeportalinfo(<?php echo $row['id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px;color: black; '><i class='fa fa-key ' aria-hidden='true'></i></a>
                                            <?php
                                            }
                                            $customer_id = $row['id'];
                                            echo "<a href='user_profile?profile=$customer_id' class='btn btn-primary '  style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>";
                                            ?>
                                            <a class='btn btn-danger ' onclick="del(delC,<?php echo $row['id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-trash ' aria-hidden='true'></i></a>
                                            <?php
                                            $img_p = '';
                                            if($row['profile_pic'] != ''){
                                                $img_p = "<img src='../images/".$row['profile_pic']."' alt='table-user' class='mr-2 rounded-circle'>";
                                            }else{}
                                            echo "</td><td class='table-user'>".$img_p.ucwords($row['fname'])." ".ucwords($row['lname'])."</td><td>".$row['email']."</td><td>".$row['phone']."</td><td>".$row['salary']."</td><td style='width:25px !important;overflow-x: auto;'>".ucwords($row['aboutme'])."</td><td>".$row['joining_date']."</td>";
                                            ?>
                                        </tr>
                                        <?php
                                        $sr++;
                                    } ?>
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
function selectusernamepassword(){
    var fetchrolename =  $("#fetchrolename").val();
    if(fetchrolename == 'receptionist'){
        $("#fetch_regionselectbox").html("<div class='row'><div class='form-group col-md-6'><label for='exampleInputEmail1'>Username <span style='color: red;'> *</span></label><input type='text' class='form-control' onkeyup='checkvalidusername();' name='username' id='fetchuser' required></div><div class='form-group col-md-6'><label for='exampleInputEmail1'>Password <span style='color: red;'> *</span></label><div class='input-group input-group-merge'><input type='password' name='password' id='password' class='form-control'><div class='input-group-append' data-password='false'><div class='input-group-text'><span class='password-eye'></span></div></div></div></div><div id='warnmsg2' class='col-md-12'></div></div>");
    }else{
        $("#fetch_regionselectbox").empty();
    }
}
function checkvalidusername(idcus) {
    var idcus = $("#fetchuser").val();
    $.ajax({
        type:"POST",
        url:"getState.php",
        data: 'checkvalidusername='+idcus,
        success:function(data) {
           if(data == 'false'){
            $("#warnmsg2").html("<div class='alert alert-danger' style='text-align:center'><strong>Sorry This Username Already Exist!!</strong></div>");
            $("#errorbutton").attr('disabled',true);
        }else{
            $("#warnmsg2").empty();
            $("#errorbutton").attr('disabled',false);
        }
    }
});
};
function checkvalidemail(idcus) {
    var idcus = $("#fetchemail").val();
    $.ajax({
        type:"POST",
        url:"getState.php",
        data: 'checkvalidemail='+idcus,
        success:function(data) {
           if(data == 'false'){
            $("#warnmsg1").html("<div class='alert alert-danger' style='text-align:center'><strong>Sorry This Email Already Exist!!</strong></div>");
            $("#errorbutton").attr('disabled',true);
        }else{
            $("#warnmsg1").empty();
            $("#errorbutton").attr('disabled',false);
        }
    }
});
};
function changeportalinfo(idcus) {
    var idcus = idcus;
    $.ajax({
        type:"POST",
        url:"getState.php",
        data: 'user_portal='+idcus,
        success:function(data) {
            $(".modalbuttonopen1").html(data);
            $('#modalbuttonopen').trigger('click');
        }
    });
};
function delC(idcus) {
    var idcus = idcus;
    $.ajax({
        type:"POST",
        url:"getState.php",
        data: 'user_del='+idcus,
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

</script>   