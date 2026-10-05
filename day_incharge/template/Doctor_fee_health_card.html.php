<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Doctor Fee </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Doctor Fee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div>                    
<!-- Modal -->
<div class="modal fade" id="add-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Doctor Fee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
               <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Case <span style="color: red;"> *</span></label>
                        <select  class="form-control" name="case_id" id="case_id1" onchange="validate_doc_fee();"   required>
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
                    <div class="form-group col-md-12">
                        <label for="name">Doctor <span style="color: red;"> *</span></label>
                        <select  class="form-control" name="doc_id" id="doc_id"  onchange="validate_doc_fee();"  required>
                            <option disabled selected value=""> --- Select Doctor --- </option>
                            <?php
                            $fetch_data_ep = "SELECT * FROM ssh_dr_reg WHERE status = '1'";
                            $fetch_data_ep_ex = mysqli_query($con,$fetch_data_ep);
                            foreach($fetch_data_ep_ex as $row1){ 
                                echo "<option value='".$row1['D_ID']."'>".ucwords($row1['Name'])."</option>";
                            }
                            ?>

                        </select>  
                    </div>
                    <div id="warnmsg2" class="col-md-12"></div>
                    <div class="form-group col-md-12">
                        <label for="name">Doctor Charges <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" name="doc_charges" required>
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
            <button id="" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;" ><i class="mdi mdi-plus-circle mr-2"></i> Add Doctor Fee</button>
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
                                        <th>Doctor</th>
                                        <th>Case</th>
                                        <th>Doctor Charges</th>

                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sr = 1;
                                    $fetch_data = "SELECT * from ssh_docsetting_indoor JOIN ssh_cases_indoor ON ssh_docsetting_indoor.S_ID = ssh_cases_indoor.S_ID  LEFT JOIN ssh_dr_reg ON ssh_docsetting_indoor.D_ID = ssh_dr_reg.D_ID where ssh_docsetting_indoor.close = '1' AND ssh_cases_indoor.type = '1' ";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                        ?>
                                        <tr id="<?php echo $row['ds_id']; ?>">
                                            <?php echo "<td>".$sr."</td>"; ?>
                                            <td>

                                                
                                                <button class='btn btn-danger ' onclick="del(delC,<?php echo $row['ds_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-trash ' aria-hidden='true'></i></button>
                                            </td>
                                            <?php echo "<td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['doc_charges']."</td>"; ?>
                                        </tr>
                                        <?php
                                        $sr++;
                                    }        
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
    function validate_doc_fee() {
        var case_id = $("#case_id").val(); 
        var doc_id = $("#doc_id").val(); 
        $.ajax({
            type:"POST",
            url:"models/indoor_services.php",
            data:{case_id:case_id,doc_id:doc_id},
            success:function(data) {
                if(data == 'false'){
                    $("#warnmsg2").html("<div class='alert alert-danger' style='text-align:center'><strong>Sorry Doctor Fee Already Exist Against This Case!!</strong></div>");
                    $("#errorbutton").attr('disabled',true);
                }else{
                    $("#warnmsg2").empty();
                    $("#errorbutton").attr('disabled',false);
                }
            }
        });
    }
    function delC(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor_services.php",
            data: 'doctor_fee_del='+idcus,
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