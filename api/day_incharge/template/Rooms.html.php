<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Case </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Case</h4>
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
                <h4 class="modal-title" id="myCenterModalLabel">Add Room</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
               <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <input  type="file" name="excel_file" required class="form-control" 
                                    accept=".csv"  />
                    <div class="form-group col-md-12">
                        <label for="name">Room No <span style="color: red;"> *</span></label>
                        <input type="text" class="form-control" name="room_no" required>
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
            <button id="" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;" ><i class="mdi mdi-plus-circle mr-2"></i> Add Room</button>
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
                                        <th>Room</th>

                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sr = 1;
                                    $fetch_data = "SELECT * from indoor_room";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                    ?>
                                        <tr>
                                                <?php echo "<td>".$sr."</td>"; ?>
                                                <td>
                                                    
                                                    
                                                </td>
                                                <?php echo "<td>".$row['room_no']."</td>"; ?>
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
function update_info(idcus) {
    var idcus = idcus;
    $.ajax({
        type:"POST",
        url:"models/indoor_services.php",
        data: 'services_update='+idcus,
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
        url:"models/indoor_services.php",
        data: 'services_del='+idcus,
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