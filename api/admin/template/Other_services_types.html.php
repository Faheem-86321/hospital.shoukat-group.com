<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Service Type </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Service Type</h4>
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
                <h4 class="modal-title" id="myCenterModalLabel">Add Service Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
            	<form action="" method="post" enctype="multipart/form-data">
            		<div class="row">
                        <div class="form-group col-md-12">
                            <label>Service <span style="color: red;"> *</span></label>
                            <select class="form-control"  name="ser_type" required>
                                <option selected value="" disabled>--- Select Service ---</option>
                                <option value="6">X-Ray-Big</option>
                                <option value="1">X-Ray-Small</option>
                                <option value="2">CT-Scan</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="name">Title <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" name="ser_title" required>
                        </div>
            			<div class="form-group col-md-6">
            				<label for="name">Price<span style="color: red;"> *</span></label>
            				<input type="number" class="form-control" name="ser_price" required>
            			</div>
            			<div class="form-group col-md-6">
            				<label for="name">Number of Films <span style="color: red;"> *</span></label>
            				<input type="number" class="form-control" name="ser_sheets" required>
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
            <button id="onloadclick" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Service Type</button>
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div style="float: left;"> <p>&nbsp&nbsp</p> </div>
            <div class="text-center">
                <p>&nbsp&nbsp</p> 
            </div> 
            <div id="cardCollpase4" class="collapse show"  >
                <div class="row bodyoftable" style="padding: 0px 4px !important;">
                    <div class="col-sm-12" style="padding: 0px 4px !important;">
                        <div class="card-box card-table-style" style="padding: 0px 4px !important;">
                            <?php 
                                date_default_timezone_set("Asia/Karachi");
                                ?>
                            <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th  class="noExport">Option</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Films</th>
                                        <th>Charges</th>
                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetch_data = "SELECT * FROM `ssh_ser_cat` JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID  ";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ ?>
                                        <tr>
                                            <?php echo "<td>".$row['C_ID']."</td>";?>
                                            <td>

                                                <a class='btn btn-primary' onclick="update_info(<?php echo $row['C_ID']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>

                                            </td>
                                            <?php echo "<td>".$row['Title']."</td><td>".$row['Name']."</td><td>".$row['sets']."</td><td>".$row['charges']."</td>"; ?>
                                        </tr>
                                        <?php 
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
    function update_info(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/other_services.php",
            data: 'x_type_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
</script>   