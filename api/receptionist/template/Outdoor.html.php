<script type="text/javascript">
    window.onload = function() {
      yourFunction();
  };
  function yourFunction(){
    $('#onloadclick').trigger('click');
}
</script>
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Charges </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Charges</h4>
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
                <h4 class="modal-title" id="myCenterModalLabel">Add Outdoor Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
             <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
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
                        <label for="name">Doctor <span style="color: red;"> *</span></label>
                        <select  id="selectize-programmatic2" name="doc_id" onchange="getdocprice()" placeholder="... Select Doctor..." required >
                        </select>   
                    </div>
                    <div class="col-md-12" id="valuesinputs">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name"> Hospital Share <sub style="color: green !important;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                                <input type="number"  class="form-control"   name='' required onkeypress="return false;">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name"> Doctor Share <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                                <input type="number" class="form-control" onkeyup=""  name='' id=''  required onkeypress="return false;">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name"> Total Payable <sub style="color: green !important;">(Readonly)</sub> <span style="color: red;"> *</span></label>
                                <input type="number" class="form-control"  name='' id=''  required onkeypress="return false;">
                            </div>
                        </div>
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
            <button id="onloadclick" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Outdoor Patient</button>
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
                                            <th></th>
                                            <th colspan="2"><?php echo $_GET['search_date']."<br>".date('l', strtotime($_GET['search_date'])); ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>MRN</th>
                                            <th  class="noExport">Option</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Charges</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_charges_s = 0;
                                        $total_paid_s = 0;
                                        $fetch_data = "Select ssh_p_reg.Name AS p_name, ssh_p_reg.Gender, ssh_p_reg.age, ssh_p_reg.phone, ssh_p_dpr.MRN,ssh_p_dpr.Charges,ssh_p_dpr.Paid, (SELECT COUNT(P_ID)+1 FROM ssh_p_dpr WHERE P_ID=1) AS visit, ssh_p_dpr.A_Date, ssh_dr_reg.Name AS d_name From ssh_p_dpr
                                        LEFT JOIN ssh_p_reg
                                        ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID 
                                        LEFT JOIN ssh_dr_reg
                                        ON ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
                                        Where CONVERT(A_DATE,Date) = '".$_GET['search_date']."' AND ssh_p_dpr.user_id = '".$_SESSION['user_id']."' ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ ?>
                                            <tr>
                                               <?php echo "<td>".$row['MRN']."</td>" ?>
                                               <td>

                                                <a class='btn btn-primary ' onclick="update_info(<?php echo $row['MRN']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>

                                            </td>
                                            <?php echo "<td>".$row['p_name']."</td><td>".$row['d_name']."</td><td>".$row['Charges']."</td><td>".$row['Paid']."</td>"; ?>
                                        </tr>
                                        <?php 
                                        $total_charges_s += $row['Charges'];
                                        $total_paid_s += $row['Paid'];
                                    }
                                    ?>
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_charges_s ?></b></td>
                                        <td class="text-center"><b><?php echo $total_paid_s ?></b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php }elseif (isset($_GET['searchbymrnorname'])) { 
                                date_default_timezone_set("Asia/Karachi");
                                ?>
                                <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th colspan="2"><?php echo $_GET['keyword'] ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>MRN</th>
                                            <th  class="noExport">Option</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Charges</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total_charges = 0;
                                    $total_paid = 0;
                                    $fetch_data = "Select ssh_p_reg.Name AS p_name, ssh_p_reg.Gender, ssh_p_reg.age, ssh_p_reg.phone, ssh_p_dpr.MRN,ssh_p_dpr.Charges,ssh_p_dpr.Paid, (SELECT COUNT(P_ID)+1 FROM ssh_p_dpr WHERE P_ID=1) AS visit, ssh_p_dpr.A_Date, ssh_dr_reg.Name AS d_name From ssh_p_dpr
                                    LEFT JOIN ssh_p_reg
                                    ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID 
                                    LEFT JOIN ssh_dr_reg
                                    ON ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
                                    Where ssh_p_reg.Name LIKE '%".$_GET['keyword']."%' OR ssh_p_dpr.MRN = '".$_GET['keyword']."' AND  ssh_p_dpr.user_id = '".$_SESSION['user_id']."'";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ ?>
                                        <tr>
                                            <?php echo "<td>".$row['MRN']."</td>";?>
                                            <td>

                                                <a class='btn btn-primary ' onclick="update_info(<?php echo $row['MRN']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>

                                            </td>
                                            <?php echo "<td>".$row['p_name']."</td><td>".$row['d_name']."</td><td>".$row['Charges']."</td><td>".$row['Paid']."</td>"; ?>
                                        </tr>
                                        <?php 
                                        $total_charges += $row['Charges'];
                                        $total_paid += $row['Paid'];
                                    }
                                    ?>
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_charges ?></b></td>
                                        <td class="text-center"><b><?php echo $total_paid ?></b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php } else{
                            date_default_timezone_set("Asia/Karachi");
                            ?>
                            <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th colspan="2"><?php echo date('Y-m-d')."<br>".date('l') ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>MRN</th>
                                        <th  class="noExport">Option</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Charges</th>
                                        <th>Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_charges = 0;
                                    $total_paid = 0;
                                    $fetch_data = "Select ssh_p_reg.Name AS p_name, ssh_p_reg.Gender, ssh_p_reg.age, ssh_p_reg.phone, ssh_p_dpr.MRN,ssh_p_dpr.Charges,ssh_p_dpr.Paid, (SELECT COUNT(P_ID)+1 FROM ssh_p_dpr WHERE P_ID=1) AS visit, ssh_p_dpr.A_Date, ssh_dr_reg.Name AS d_name From ssh_p_dpr
                                    LEFT JOIN ssh_p_reg
                                    ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID 
                                    LEFT JOIN ssh_dr_reg
                                    ON ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
                                    Where CONVERT(A_DATE,Date) = '".date('Y-m-d')."' AND ssh_p_dpr.user_id = '".$_SESSION['user_id']."'";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ ?>
                                        <tr>
                                            <?php echo "<td>".$row['MRN']."</td>";?>
                                            <td>

                                                <a class='btn btn-primary ' onclick="update_info(<?php echo $row['MRN']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-edit' aria-hidden='true'></i></a>

                                            </td>
                                            <?php echo "<td>".$row['p_name']."</td><td>".$row['d_name']."</td><td>".$row['Charges']."</td><td>".$row['Paid']."</td>"; ?>
                                        </tr>
                                        <?php 
                                        $total_charges += $row['Charges'];
                                        $total_paid += $row['Paid'];
                                    }
                                    ?>
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_charges ?></b></td>
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
    function getdocprice(){
        var getdoc = $("#selectize-programmatic2").val();
        $.ajax({
            type:"POST",
            url:"models/outdoor.php",
            data: 'get_doctor_fee='+getdoc,
            success:function(data) {
                $('#valuesinputs').html(data);
                $("#errorbutton").attr("disabled",false);
            }
        });
    };
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
    function update_info(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/outdoor.php",
            data: 'charges_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
</script>  