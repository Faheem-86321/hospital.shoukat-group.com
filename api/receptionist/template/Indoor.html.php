<?php
$fetch_data_ser = "SELECT S_ID,Title from ssh_services_indoor";
$fetch_data_ser_ex = mysqli_query($con,$fetch_data_ser);
?>
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Indoor </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Indoor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div>                    
<!-- Modal -->
<div class="modal fade" id="add-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Indoor Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
             <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Patient <span style="color: red;"> *</span></label>
                        <select  id="select_patient" name="mrn" placeholder="... Select Patient ..." required>
                        </select>    
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name">Doctor <span style="color: red;"> *</span></label>
                        <select  id="selectize-programmatic2" name="doc_id" onchange="getdocprice()" placeholder="... Select Doctor..." required>
                        </select>   
                    </div>
                    <div class="col-md-12" id="valuesinputs"></div>
                    <div class="form-group col-md-6">
                        <label for="name"> Service <span style="color: red;"> *</span></label>
                        <select id="service0" class="form-control" name="service_id[]" onchange="getsercharges(0)" placeholder="... Select Service..." required>
                            <option value="" disabled selected>--- Select Service ---</option>
                            <?php
                            foreach($fetch_data_ser_ex as $row){ 
                                ?>
                                <option value="<?php echo $row['S_ID'] ?>"><?php echo $row['Title'] ;?></option>
                            <?php }  ?>    
                        </select>   
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name"> Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                        <input  type="number" class="form-control totalcost" name="sercost[]" id="charges0" required readonly value='0'>
                    </div>
                    <div class="col-md-12" id="next_services"></div>
                    <div class="form-group col-md-12">
                        <a class="form-control btn btn-success" onclick="next_services_fun();" style="height: 35px;padding: 10px;width: 30px;"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name"> Services Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                        <input type="number" id="totalbill_new" class="form-control"  name=""  value="0" readonly required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name"> Doctor Shares <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" name="doc_ch"  value="0" required readonly id="doc_shares">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name"> Total Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" name="" value="0" required readonly id="total_charge_all">
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
            <button id="" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle"></i> Indoor Patient</button>
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
                                            <th colspan="2"><?php echo $_GET['search_date']."<br>".date('l', strtotime($_GET['search_date'])); ?></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>MRN</th>
                                            <th  class="noExport">Option</th>
                                            <th>Patient</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_for_MRN_s = 0;
                                    $fetch_data = "Select ssh_p_reg.Name AS Patient_Name, ssh_p_reg.Gender, ssh_p_reg.phone, ssh_p_indoor.MRN,SUM(ssh_p_indoor.Paid) AS paid, ssh_p_indoor.Date, ssh_dr_reg.Name AS Dr_Name From ssh_p_indoor
                                    LEFT JOIN ssh_p_dpr
                                    ON ssh_p_indoor.MRN = ssh_p_dpr.MRN
                                    LEFT JOIN ssh_p_reg
                                    ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID 
                                    LEFT JOIN ssh_dr_reg
                                    ON ssh_p_indoor.D_ID = ssh_dr_reg.D_ID
                                    Where CONVERT(ssh_p_dpr.A_Date,Date) = '".$_GET['search_date']."' GROUP BY MRN ";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ ?>
                                        <tr>
                                            <?php echo "<td>".$row['MRN']."</td>";?>
                                            <td>

                                                <a class='btn btn-success' title="Add Doctor" onclick="update_info_doc(<?php echo $row['MRN']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-plus' aria-hidden='true'></i></a>
                                                <a class='btn btn-primary' title="Update Service" onclick="update_info_ser(<?php echo $row['MRN']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>

                                            </td>
                                            <?php echo "<td>".$row['Patient_Name']."</td><td>".$row['paid']."</td>"; ?>
                                        </tr>
                                    <?php 
                                    $total_for_MRN_s += $row['paid'];
                                }
                                    ?>
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_for_MRN_s ;?></b></td>
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
                                        <th colspan="2"><?php echo date('Y-m-d')."<br>".date('l') ?></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>MRN</th>
                                        <th  class="noExport">Option</th>
                                        <th>Patient</th>
                                        <th>Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_for_MRN = 0;
                                    $fetch_data = "Select ssh_p_reg.Name AS Patient_Name, ssh_p_reg.Gender, ssh_p_reg.phone, ssh_p_indoor.MRN,SUM(ssh_p_indoor.Paid) AS paid, ssh_p_indoor.Date, ssh_dr_reg.Name AS Dr_Name From ssh_p_indoor
                                    LEFT JOIN ssh_p_dpr
                                    ON ssh_p_indoor.MRN = ssh_p_dpr.MRN
                                    LEFT JOIN ssh_p_reg
                                    ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID 
                                    LEFT JOIN ssh_dr_reg
                                    ON ssh_p_indoor.D_ID = ssh_dr_reg.D_ID
                                    Where CONVERT(ssh_p_dpr.A_Date,Date) = '".date('Y-m-d')."' GROUP BY MRN ";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ ?>
                                        <tr>
                                            <?php echo "<td>".$row['MRN']."</td>";?>
                                            <td>

                                                <a class='btn btn-success' title="Add Doctor" onclick="update_info_doc(<?php echo $row['MRN']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-plus' aria-hidden='true'></i></a>
                                                <a class='btn btn-primary' title="Update Service" onclick="update_info_ser(<?php echo $row['MRN']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>

                                            </td>
                                            <?php echo "<td>".$row['Patient_Name']."</td><td>".$row['paid']."</td>"; ?>
                                        </tr>
                                        
                                    <?php 
                                    $total_for_MRN += $row['paid'];
                                }
                                    ?>
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_for_MRN ;?></b></td>
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
    var for_del_ser = 1;
    function  next_services_fun(){
        $("#next_services").append("<div class='row' id='row"+for_del_ser+"'><div class='form-group col-md-6'><label for='name'> Service <span style='color: red;'> *</span></label><select id='service"+for_del_ser+"' class='form-control' name='service_id[]' onchange='getsercharges("+for_del_ser+")' placeholder='... Select Service...' required><option value='' disabled selected>--- Select Service ---</option><?php foreach($fetch_data_ser_ex as $row){ ?><option value='<?php echo $row['S_ID'] ?>'><?php echo $row['Title'] ;?></option><?php }  ?> </select></div><div class='form-group col-md-5'><label for='name'> Charges <sub style='color: green !important;'>(Readonly)</sub><span style='color: red;'> *</span></label><input  type='number' class='form-control totalcost' name='sercost[]' id='charges"+for_del_ser+"' value='0' required readonly></div><div class='col-md-1'><label for='name'> &nbsp </label><a class='' onclick='remove_ser("+for_del_ser+");' style='font-size:22px'><i class='fa fa-trash'></i></a></div></div>");
        for_del_ser++;
    }
    function remove_ser(id) {
        $("#row"+id).remove();
        cal_totalcost();
    }
    function getsercharges(id) {
        var getserid = $("#service"+id).val();
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'get_ser_charges='+getserid,
            success:function(data) {
                $("#charges"+id).val(parseInt(data));
                cal_totalcost();
                get_total_value();
            }
        });
    }
    function cal_totalcost() {
        var sbill_new = 0;
        var priceval_new = new Array();
        $('.totalcost').each(function() {
            priceval_new.push($(this).val());
        });
        for (var i = 0; i < priceval_new.length; i++) {
            sbill_new += parseInt(priceval_new[i]); 
        };
        $("#totalbill_new").val(sbill_new);
    }


    var for_del_ser_u = 100;
    function  next_services_u_fun(){
        $("#next_services_u").append("<div class='row' id='row_u"+for_del_ser_u+"'><div class='form-group col-md-6'><label for='name'> Service <span style='color: red;'> *</span></label><select id='service"+for_del_ser_u+"' class='form-control' name='service_id_u[]' onchange='getsercharges_u("+for_del_ser_u+")' placeholder='... Select Service...' required><option value='' disabled selected>--- Select Service ---</option><?php foreach($fetch_data_ser_ex as $row){ ?><option value='<?php echo $row['S_ID'] ?>'><?php echo $row['Title'] ;?></option><?php }  ?> </select></div><div class='form-group col-md-5'><label for='name'> Charges <sub style='color: green !important;'>(Readonly)</sub><span style='color: red;'> *</span></label><input  type='number' class='form-control totalcost_u' name='sercost_u[]' id='charges"+for_del_ser_u+"' value='0' required readonly></div><div class='col-md-1'><label for='name'> &nbsp </label><a class='' onclick='remove_ser_u("+for_del_ser_u+");' style='font-size:22px'><i class='fa fa-trash'></i></a></div></div>");
            for_del_ser_u++;
    }
    function remove_ser_u(id) {
        $("#row_u"+id).remove();
        cal_totalcost_u()
    }
    function getsercharges_u(id) {
        var getserid = $("#service"+id).val();
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'get_ser_charges='+getserid,
            success:function(data) {
                $("#charges"+id).val(parseInt(data));
                cal_totalcost_u()
            }
        });
    }
    function cal_totalcost_u() {
        var sbill_new = 0;
        var priceval_new = new Array();
        $('.totalcost_u').each(function() {
            priceval_new.push($(this).val());
        });
        for (var i = 0; i < priceval_new.length; i++) {
            sbill_new += parseInt(priceval_new[i]); 
        };
        $("#totalbill_new_u").val(sbill_new);
    }


    
    function getdocprice() {
        var doc_id =  $("#selectize-programmatic2").val();
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'get_doctor_shares='+doc_id,
            success:function(data) {
                $('#doc_shares').val(parseInt(data));
                get_total_value();
            }
        });
    }
    function getdocprice_u() {
        var doc_id =  $("#selectize-programmatic3").val();
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'get_doctor_shares='+doc_id,
            success:function(data) {
                $('#doc_shares_u').val(parseInt(data));
            }
        });
    }
    function update_info_doc(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'update_indoor_doc='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
    function update_info_ser(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'update_indoor_services='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
    function get_total_value() {
        var ser =  $("#doc_shares").val();
        var doc_s = $("#totalbill_new").val();
        $("#total_charge_all").val(parseInt(ser) + parseInt(doc_s));
    }
</script>   