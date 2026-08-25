
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> View Health Card Patient </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> View Health Card Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div>  
<button id="updateinfobutton0" hidden class="btn " data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#updateinfo0" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Health Card Patient </button>
<div class="modal fade" id="updateinfo0" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Health Card Patient</h4>
                <button type="button" class="close" onclick="location.reload();" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody10">
            </div>    
        </div>
    </div>
</div>                    
<!-- Modal -->
<div class="modal fade" id="add-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Health Card Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
               <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Visitor ID <span style="color: red;"> *</span></label>
                        <input type="text" class="form-control" name="visitor_id"  value="" required>   
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">Patient</label>
                        <select  id="selectize-programmatic" name="pat_id" onchange="getpatinfo();" placeholder="... Select Patient ..." >
                        </select>    
                    </div>
                    <div class="col-md-12" id="getpatientinput">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name <span style="color: red;"> *</span></label>
                                <input type="text" class="form-control" name="pat_Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Age <span style="color: red;"> *</span></label>
                                <input type="number" class="form-control" name="pat_Age" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Phone <span style="color: red;"> *</span></label>
                                <input type="number" class="form-control" name="pat_Phone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Gender <span style="color: red;"> *</span></label>
                                <select class="form-control"  name="pat_gender" required>
                                    <option selected value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">Room <span style="color: red;"> *</span></label>
                        <select  class="form-control" name="room_id" id="room_id" required onchange="validate_room();">
                            <option disabled selected value=""> --- Select Room --- </option>
                            <?php
                            $fetch_data_ep = "SELECT * FROM indoor_room  ";
                            $fetch_data_ep_ex = mysqli_query($con,$fetch_data_ep);
                            foreach($fetch_data_ep_ex as $row1){ 
                                echo "<option value='".$row1['ir_id']."'>".ucwords($row1['room_no'])."</option>";
                            }
                            ?>

                        </select>  
                    </div>
                    <div id="warnmsg2" class="col-md-12"></div>
                    <div class="form-group col-md-12">
                        <label for="name">Case <span style="color: red;"> *</span></label>
                        <select  class="form-control" name="case_id" id="case_id1" onchange="get_doctor();"   required>
                            <option disabled selected value=""> --- Select Case --- </option>
                            <?php
                            $fetch_data_ep = "SELECT * FROM ssh_cases_indoor WHERE type = '1' AND close = '1'";
                            $fetch_data_ep_ex = mysqli_query($con,$fetch_data_ep);
                            foreach($fetch_data_ep_ex as $row1){ 
                                echo "<option value='".$row1['S_ID']."'>".ucwords($row1['Title'])."</option>";
                            }
                            ?>

                        </select>  
                    </div>
                    <div class="col-md-12" id="case_doctor">
                       <div class="row">
                        <div class="form-group col-md-12" id="buttonshow1">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Doctor <span style="color: red;"> *</span></label>
                            <select  class="form-control" name="doc_id[]" id="doc_option1"  onchange="get_doctor_price(1);"  required>
                                <option disabled selected value=""> --- Select Doctor --- </option>


                            </select>   
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                            <input type="number" class="form-control totalcost" readonly id="doc_fee1" name="doctor_payment[]" value="0"> 
                        </div>
                        <div class="col-md-12" id="more_doctor"></div> 
                        
                        <div class="form-group col-md-12" id="buttonshow">

                        </div></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name"> Total Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" name="Paid" value="0" required readonly id="totalbill_new">
                        <input type="number" hidden class="form-control" name="" value="0" required readonly id="totalbill_new_hide">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">Hospital Share <sub style="color: green !important;">(Readonly)</sub></label>
                        <input type="number" class="form-control" readonly value="0" name=" " onkeyup="" id="hospital_share_ok" required>
                    </div> 
                </div>    
                <div class="col-md-12 text-right">
                    <button type="submit" name="psubmit" id="errorbutton" disabled class="btn btn-success waves-effect waves-light">Save</button>
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
            <a href="health_card_patient?view_admit=1" id="" class="btn mr-1 "  style="background: #f24c4f; color: black;float: left;" ><i class="fa fa-eye "></i> View Admited Patients </a>

            <button id="onloadclick" class="btn " data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Health Card Patient </button>
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div style="float: left;"> <p>&nbsp&nbsp</p> </div>
            <div class="text-center">
                <form action="" method="get" enctype="multipart/form-data">
                    <input type="date" class="form-control"  name="search_date" onchange="this.form.submit()" style="border: 1px solid red;width: 150px;">
                </form>
            </div> 
            <div id="cardCollpase4" class="collapse show"  >
                <div class="row bodyoftable" style="padding: 0px 4px !important;">
                    <div class="col-sm-12" style="padding: 0px 4px !important;">
                        <div class="card-box card-table-style" style="padding: 0px 4px !important;">
                            <?php 
                            if (isset($_GET['search_date'])) { 
                                date_default_timezone_set("Asia/Karachi");
                                ?>
                                <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="7"><?php echo $_GET['search_date']."<br>".date('l',strtotime($_GET['search_date'])) ?></th>

                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Visitor ID</th>
                                            <th  class="noExport">Option</th>
                                            <th>Patient</th>
                                            <th>Room</th>
                                            <th>Case</th>
                                            <th>Paid</th>
                                            <th>Admit/Discharge</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sr_no = 1;
                                        $total_paid = 0;
                                        $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id where ssh_p_indoor.admit_date = '".$_GET['search_date']."' AND ssh_p_indoor.admition_type = '1' ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ 
                                            ?>
                                            <tr id="<?php echo $row['pi_id'] ?>">
                                                <td><?php  echo $sr_no ;?></td>
                                                <?php echo "<td>".$row['visitor_id']."</td>";?>
                                                <td>

                                                    <a class='btn btn-primary' onclick="view_info(<?php echo $row['pi_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                    <?php 
                                                    $status = '';
                                                    if ($row['exit_date'] == '0000-00-00') { 
                                                        $status = "<div class='alert alert-success' style='font-size:12px;height:17px !important; width:70px; padding: 0px 0px'>Admit</div>";
                                                        ?>
                                                        <a class='btn btn-primary' title="Discharge" onclick="discharged_pat_alert(<?php echo $row['pi_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-check ' aria-hidden='true'></i> </a>

                                                        <script type="text/javascript">
                                                            // For Delete alert error
                                                            function discharged_pat_alert(x) {
                                                                Swal.fire({
                                                                    title: 'Are you sure?',
                                                                    text: "You won't be able to revert this!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#d33',
                                                                    cancelButtonColor: '#bab8b8',
                                                                    confirmButtonText: 'Yes, Discharged!'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        window.open('https://'+window.location.hostname+'/<?php echo $_SESSION['user_type'] ?>/print_discharge_slip.php?slip='+x);
                                                                        location.reload();
                                                                    }
                                                                })
                                                            }
                                                        </script>
                                                        
                                                        
                                                    <?php }else{
                                                        $status = "<div class='alert alert-danger' style='font-size:12px;height:17px !important; width:70px; padding: 0px 0px'>Discharged</div>";
                                                    } ?>
                                                </td>
                                                <?php echo "<td>".$row['Name']."</td><td>".$row['room_no']."</td><td>".$row['Title']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$status."</td>"; ?>
                                            </tr>
                                            <?php 
                                            $total_paid +=  $row['Paid'];
                                            $sr_no++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot style="background: lightgrey !important;">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td class="text-center"><b>Total</b></td>
                                            <td class="text-center"><b><?php echo $total_paid ?></b></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php }elseif (isset($_GET['view_admit'])) { 
                                date_default_timezone_set("Asia/Karachi");
                                ?>
                                <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="7"><?php echo "Admitted Patients" ?></th>

                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Visitor ID</th>
                                            <th  class="noExport">Option</th>
                                            <th>Patient</th>
                                            <th>Room</th>
                                            <th>Case</th>
                                            <th>Paid</th>
                                            <th>Admit/Discharge</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sr_no = 1;
                                        $total_paid = 0;
                                        $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id where ssh_p_indoor.exit_date = '0000-00-00' AND ssh_p_indoor.admition_type = '1' ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ 
                                            ?>
                                            <tr id="<?php echo $row['pi_id'] ?>">
                                                <td><?php  echo $sr_no ;?></td>
                                                <?php echo "<td>".$row['visitor_id']."</td>";?>
                                                <td>

                                                    <a class='btn btn-primary' onclick="view_info(<?php echo $row['pi_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                    <?php 
                                                    $status = '';
                                                    if ($row['exit_date'] == '0000-00-00') { 
                                                        $status = "<div class='alert alert-success' style='font-size:12px;height:17px !important; width:70px; padding: 0px 0px'>Admit</div>";
                                                        ?>
                                                        <a class='btn btn-primary' title="Discharge" onclick="discharged_pat_alert(<?php echo $row['pi_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-check ' aria-hidden='true'></i> </a>

                                                        <script type="text/javascript">
                                                            // For Delete alert error
                                                            function discharged_pat_alert(x) {
                                                                Swal.fire({
                                                                    title: 'Are you sure?',
                                                                    text: "You won't be able to revert this!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#d33',
                                                                    cancelButtonColor: '#bab8b8',
                                                                    confirmButtonText: 'Yes, Discharged!'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        window.open('https://'+window.location.hostname+'/<?php echo $_SESSION['user_type'] ?>/print_discharge_slip.php?slip='+x);
                                                                        location.reload();
                                                                    }
                                                                })
                                                            }
                                                        </script>
                                                        
                                                        
                                                    <?php }else{
                                                        $status = "<div class='alert alert-danger' style='font-size:12px;height:17px !important; width:70px; padding: 0px 0px'>Discharged</div>";
                                                    } ?>
                                                </td>
                                                <?php echo "<td>".$row['Name']."</td><td>".$row['room_no']."</td><td>".$row['Title']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$status."</td>"; ?>
                                            </tr>
                                            <?php 
                                            $total_paid +=  $row['Paid'];
                                            $sr_no++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot style="background: lightgrey !important;">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><b>Total</b></td>
                                            <td class="text-center"><b><?php echo $total_paid ?></b></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php }else{
                                date_default_timezone_set("Asia/Karachi");
                                ?>
                                <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="7"><?php echo date('Y-m-d')."<br>".date('l') ?></th>

                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Visitor ID</th>
                                            <th  class="noExport">Option</th>
                                            <th>Patient</th>
                                            <th>Room</th>
                                            <th>Case</th>
                                            <th>Paid</th>
                                            <th>Admit/Discharge</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_paid = 0;
                                        $sr_no = 1;
                                        $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id where ssh_p_indoor.admit_date = '".date('Y-m-d')."' AND ssh_p_indoor.admition_type = '1' ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ 
                                            ?>
                                            <tr id="<?php echo $row['pi_id'] ?>">
                                                <td><?php echo $sr_no ?></td>
                                                <?php echo "<td>".$row['visitor_id']."</td>";?>
                                                <td>

                                                    <a class='btn btn-primary' onclick="view_info(<?php echo $row['pi_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                    <?php 
                                                    $status = '';
                                                    if ($row['exit_date'] == '0000-00-00') { 
                                                        $status = "<div class='alert alert-success' style='font-size:12px;height:17px !important; width:70px; padding: 0px 0px'>Admit</div>";
                                                        ?>
                                                        <a class='btn btn-primary' title="Discharge" onclick="discharged_pat_alert(<?php echo $row['pi_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-check ' aria-hidden='true'></i> </a>

                                                        <script type="text/javascript">
                                                            // For Delete alert error
                                                            function discharged_pat_alert(x) {
                                                                Swal.fire({
                                                                    title: 'Are you sure?',
                                                                    text: "You won't be able to revert this!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#d33',
                                                                    cancelButtonColor: '#bab8b8',
                                                                    confirmButtonText: 'Yes, Discharged!'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        window.open('https://'+window.location.hostname+'/<?php echo $_SESSION['user_type'] ?>/print_discharge_slip.php?slip='+x);
                                                                        location.reload();
                                                                    }
                                                                })
                                                            }
                                                        </script>
                                                        

                                                        
                                                    <?php }else{
                                                        $status = "<div class='alert alert-danger' style='font-size:12px;height:17px !important; width:70px; padding: 0px 0px'>Discharged</div>";
                                                    } ?>
                                                    
                                                    

                                                </td>
                                                <?php echo "<td>".$row['Name']."</td><td>".$row['room_no']."</td><td>".$row['Title']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$status."</td>"; ?>
                                            </tr>
                                            <?php 
                                            $total_paid +=  $row['Paid'];
                                            $sr_no++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot style="background: lightgrey !important;">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><b>Total</b></td>
                                            <td class="text-center"><b><?php echo $total_paid ?></b></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php } ?>
                        </div> <!-- end card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>    
        </div>
    </div> 
</div>       
<script type="text/javascript">
    function validate_room() {
        var room_id = $("#room_id").val(); 
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data:'room_id_validate='+room_id,
            success:function(data) {
                if(data == 'false'){
                    $("#warnmsg2").html("<div class='alert alert-danger' style='text-align:center'><strong>Sorry This Room Is Not Available!!</strong></div>");
                    $("#errorbutton").attr('disabled',true);
                }else{
                    $("#warnmsg2").empty();
                    $("#errorbutton").attr('disabled',false);
                }
            }
        });
    }
    function dischraged_confirm(idcus){
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'discharged_patient='+idcus,
            success:function(data) {
                location.reload();
            }
        });
    }
    function getpatinfo(){
        var getdoc = $("#selectize-programmatic").val();
        $.ajax({
            type:"POST",
            url:"models/outdoor.php",
            data: 'get_doctor_info='+getdoc,
            success:function(data) {
                if(data == ''){
                    $('#getpatientinput').html("<div class='row'><div class='form-group col-md-6'><label for='name'>Name <span style='color: red;'> *</span></label><input type='text' class='form-control' name='pat_Name' required></div><div class='form-group col-md-6'><label for='name'>Age <span style='color: red;'> *</span></label><input type='number' class='form-control' name='pat_Age' required></div><div class='form-group col-md-6'><label for='name'>Phone <span style='color: red;'> *</span></label><input type='number' class='form-control' name='pat_Phone' required></div><div class='form-group col-md-6'><label>Gender <span style='color: red;'> *</span></label><select class='form-control'  name='pat_gender' required><option selected value='male'>Male</option><option value='female'>Female</option><option value='other'>Other</option></select></div></div>"); 
                }else{
                    $('#getpatientinput').html(data);
                }
                
            }
        });
    }
    function get_doctor() {
        var idcus = $('#case_id1').val();
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'get_doctor='+idcus,
            success:function(data) {
                $("#doc_option1").html(data);
                $.ajax({
                    type:"POST",
                    url:"models/indoor.php",
                    data: 'get_taxmed='+idcus,
                    success:function(data) {
                        $("#buttonshow1").html(data);
                        $("#buttonshow").html("<a onclick='addmoredoctor()' class='btn btn-success' title='Add Doctor' ><i class='fa fa-plus'></i></a>");
                        cal_totalcost();
                    }
                });
            }
        });
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'get_hospital_share='+idcus,
            success:function(data12) {
                $("#totalbill_new").val(parseInt(data12));
                $("#totalbill_new_hide").val(parseInt(data12));
                

            }
        });
        
    }
    function get_doctor_price(newval) {
        var idcus = $('#case_id1').val();
        var doc_option1 = $('#doc_option'+newval).val();
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: {doc_option1:doc_option1,case:idcus},
            success:function(data) {
                $("#doc_fee"+newval).val(parseInt(data));
                cal_totalcost();
            }
        });
    }
    var newdoc = 2;
    function addmoredoctor() {
        var idcus = $('#case_id1').val();
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: {new_fee_id:newdoc,case_new:idcus},
            success:function(data) {
                $("#more_doctor").append(data);
                newdoc++;
            }
        });
        
    }
    function removethiseduc(id){
        $("#rows"+id).remove();
        cal_totalcost();
    }
    function cal_totalcost() {
        var sbill_new = 0;
        var sbill_new_u = parseInt($("#totalbill_new_hide").val());

        var priceval_new = new Array();
        $('.totalcost').each(function() {
            priceval_new.push($(this).val());
        });
        for (var i = 0; i < priceval_new.length; i++) {
            sbill_new += parseInt(priceval_new[i]); 
        };
        var sbill_total = sbill_new_u - sbill_new;
        //$("#totalbill_new").val(sbill_new);

        $("#hospital_share_ok").val(sbill_total);
         $("#errorbutton").attr("disabled",false);


    }

    function view_info(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'view_admit='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };

    function update_info(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'update_admit='+idcus,
            success:function(data) {
                $('.modalbody10').html(data);
                $('#updateinfobutton0').trigger('click');
            }
        });
    };

    function delC(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'admit_del='+idcus,
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