<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> View Dialysis Dialysis </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> View Private Dialysis</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div>                    
<!-- Modal -->
<div class="modal fade" id="add-custom-modal-d" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Private Dialysis</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
             <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Visitor ID <span style="color: red;"> *</span><sub style="color: green;">(Readonly)</sub></label>
                        <?php
                        $visitor_id = 1;
                        $fetch_data_in = "SELECT * FROM ssh_p_dialysis WHERE admission_type = '0' ORDER BY pd_id DESC LIMIT 1;";
                        $fetch_data_in_ex = mysqli_query($con,$fetch_data_in);
                        foreach($fetch_data_in_ex as $rowvis){
                         $visitor_id =  $rowvis['pd_id']+1;
                     }

                     ?>
                     <input type="text" class="form-control" name="visitor_id" readonly value="<?php echo $visitor_id ?>">   
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
                    <label>Injection <span style="color: red;"> *</span></label>
                    <select class="form-control"  name="injection" required>
                        <option selected value="" disabled> --- Select ---</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Discount <span style="color: red;"> *</span></label>
                    <input type="number" class="form-control" value="0" name="discount" onkeyup="discountthispat()" id="discount" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="name"> Total Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                    <input type="number" class="form-control" name="Paid" value="7000" required readonly id="charges">
                    <input type="number" class="form-control" value="7000" hidden  id="calcharges" required>
                </div>
            </div>    
            <script type="text/javascript">
                function discountthispat() {
                    var discount = $("#discount").val();
                    var total_charges = $("#calcharges").val();
                    $("#charges").val(parseInt(total_charges)-parseInt(discount));
                }
            </script>
            <div class="col-md-12 text-right">
                <button type="submit" name="psubmit" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
            </div>
        </div>
    </form></div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="col-xl-12  col-lg-12">
    <div class="card">
        <div class="card-body" dir="ltr">
            <button id="onloadclick" class="btn" data-toggle="modal" data-target="#add-custom-modal-d" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Private Dialysis </button>
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
                                            <th colspan="5"><?php echo $_GET['search_date']."<br>".date('l',strtotime($_GET['search_date'])) ?></th>

                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Sr no.</th>
                                            <th>Visitor ID</th>
                                            
                                            <th>Patient</th>
                                            <th>Injection</th>
                                            <th>Phone</th>
                                            <th>Discount</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_paid = 0;
                                        $t_discount = 0;
                                        $sr_no = 1;
                                        $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID  where ssh_p_dialysis.date = '".$_GET['search_date']."' AND ssh_p_dialysis.admission_type = '0' ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ 
                                            ?>
                                            <tr id="<?php echo $row['pd_id'] ?>">
                                                <?php echo "<td>".$sr_no."</td><td>".$row['visitor_id']."</td>";?>
                                                
                                                <?php 
                                                $dicount = 7000-$row['Paid'];
                                                
                                                if ($row['injection'] == '1') {
                                                     echo "<td>".$row['Name']."</td><td>Yes</td><td>".$row['phone']."</td><td>".intval($dicount)."</td><td>".$row['Paid']."</td>";
                                                }elseif($row['injection'] == '0'){
                                                    echo "<td>".$row['Name']."</td><td>No</td><td>".$row['phone']."</td><td>".intval($dicount)."</td><td>".$row['Paid']."</td>"; 
                                                }else{
                                                    echo "<td>".$row['Name']."</td><td>Unknown</td><td>".$row['phone']."</td><td>".intval($dicount)."</td><td>".$row['Paid']."</td>";
                                                }
                                                ?>
                                                
                                           </tr>
                                            <?php 
                                            $total_paid +=  $row['Paid'];
                                            $t_discount += $dicount;
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
                                            <td><b>Total</b></td>
                                            <td class="text-center"><b><?php echo $t_discount ?></b></td>
                                            <td class="text-center"><b><?php echo $total_paid ?></b></td>
                                            
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
                                            <th colspan="5"><?php echo date('Y-m-d')."<br>".date('l') ?></th>

                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Visitor ID</th>
                                            
                                            <th>Patient</th>
                                            <th>Injection</th>
                                            <th>Phone</th>
                                            <th>Discount</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_paid = 0;
                                        $t_discount = 0;
                                        $sr_no = 1;
                                        $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID  where ssh_p_dialysis.date = '".date('Y-m-d')."' AND ssh_p_dialysis.admission_type = '0' ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ 
                                            ?>
                                             <tr id="<?php echo $row['pd_id'] ?>">
                                                <?php echo "<td>".$sr_no."</td><td>".$row['visitor_id']."</td>";?>
                                                
                                                <?php 
                                                $dicount = 7000-$row['Paid'];
                                                
                                                if ($row['injection'] == '1') {
                                                     echo "<td>".$row['Name']."</td><td>Yes</td><td>".$row['phone']."</td><td>".intval($dicount)."</td><td>".$row['Paid']."</td>";
                                                }elseif($row['injection'] == '0'){
                                                    echo "<td>".$row['Name']."</td><td>No</td><td>".$row['phone']."</td><td>".intval($dicount)."</td><td>".$row['Paid']."</td>"; 
                                                }else{
                                                    echo "<td>".$row['Name']."</td><td>Unknown</td><td>".$row['phone']."</td><td>".intval($dicount)."</td><td>".$row['Paid']."</td>";
                                                }
                                                
                                                ?>
                                           </tr>
                                            <?php 
                                            $total_paid +=  $row['Paid'];
                                            $t_discount += $dicount;
                                            $sr_no++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot style="background: lightgrey !important;">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td> </td>
                                            <td></td>
                                            <td class="text-center"><b>Total</b></td>
                                            <td class="text-center"><b><?php echo $t_discount ?></b></td>
                                            <td class="text-center"><b><?php echo $total_paid ?></b></td>
                                            
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
    function delC(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'admit_del_dialysis='+idcus,
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