
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Asset </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Asset</h4>
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
                <h4 class="modal-title" id="myCenterModalLabel">Add Asset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
            	<form action="" method="post" enctype="multipart/form-data">
            		<div class="row">

                        <div class="form-group col-md-12">
                            <label for="name">Title <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" name="as_title" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Product <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" name="as_product[]" required>
                        </div>
            			<div class="form-group col-md-6">
            				<label for="name">Value<span style="color: red;"> *</span></label>
            				<input type="number" class="form-control" name="as_price[]" required>
            			</div>
                         <div class="col-md-12" id="more_product"></div> 
                         <div class="col-md-12">
                             <a onclick='addmoreproduct()' class='btn btn-success' title='' ><i class='fa fa-plus'></i></a>
                         </div>
                         <script type="text/javascript">
                             function addmoreproduct() {
                                 $("#more_product").append("<div class='row'><div class='form-group col-md-6'><label for='name'>Product <span style='color: red;'> *</span></label><input type='text' class='form-control' name='as_product[]' required></div><div class='form-group col-md-6'><label for='name'>Value<span style='color: red;'> *</span></label><input type='number' class='form-control' name='as_price[]' required></div></div>")
                             }
                         </script>
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
            <button id="onloadclick" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Asset</button>
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div style="float: left;"> <p>&nbsp&nbsp</p> </div>
            <div class="text-center">
               <p>&nbsp&nbsp</p> 
            </div> 
            <div id="cardCollpase4" class="collapse show" >
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
                                        <th>Title</th>
                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sr_no = 1;
                                    $fetch_data = "SELECT * FROM `ssh_assets` ";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ ?>
                                        <tr id="<?php echo $row['A_ID'] ?>">
                                            <?php echo "<td>".$sr_no."</td>";?>
                                            <td>
                                                 <button class='btn btn-danger ' onclick="del(delC,<?php echo $row['A_ID']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-trash ' aria-hidden='true'></i></button>
                                                 <a class='btn btn-primary ' onclick="update_info(<?php echo $row['A_ID']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>

                                            </td>
                                            <?php echo "<td>".$row['A_Name']."</td>"; ?>
                                        </tr>
                                        <?php 
                                        $sr_no++;
                                        }
                                    ?>
                                </tbody>
                                </tfoot>
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
            url:"models/expense.php",
            data: 'assets_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
    function delC(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/expense.php",
            data: 'assets_del='+idcus,
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