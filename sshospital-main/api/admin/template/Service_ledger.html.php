<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> View Records </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> View Records</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div>  
<div class="col-xl-12  col-lg-12">
    <div class="card">
        <div class="card-body" dir="ltr">
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="text-center">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row col-sm-12">
                        <!-- <select  class=" form-control m-1 text-center col-md-3 col-sm-12 " id="" name="emp_id"   required style="border: 1px solid lightgrey; color: grey;">
                            <option disabled selected value=""> --- Select Receptionist --- </option>
                            <?php
                            $fetch_data_ep = "SELECT * FROM wt_users WHERE status='1' AND close = '1' AND type='receptionist' ";
                            $fetch_data_ep_ex = mysqli_query($con,$fetch_data_ep);
                            foreach($fetch_data_ep_ex as $row1){ 
                                echo "<option value='".$row1['id']."'>".ucwords($row1['fname']." ".$row1['lname'])."</option>";
                            }
                            ?>

                        </select> -->

                        <select  class="m-1 form-control " id="select_services_search" name="service_id_search"  placeholder="... Select Service ..." required style="border: 1px solid lightgrey;width: 250px; " >
                            <option value="" selected disabled> --- Select Service ---</option>
                            <?php
                            $fetch_data = "SELECT * FROM ssh_ser_inv";
                            $fetch_data_ex = mysqli_query($con,$fetch_data);
                            foreach($fetch_data_ex as $row){    
                                ?>
                                <option value="<?php echo $row['ID'];?>" > <?php echo $row['Title'] ;?> </option>
                            <?php } ?>
                        ?>
                    </select>
                        <input type="date" class=" form-control m-1"  name="date_from"  style="width: 150px;float: left;" required>
                        <span style="float: left;" class="m-2"><b>To</b></span>
                        <input type="date" class="form-control m-1"  name="date_to"  style="width: 150px;float: left;" required>
                        <input type="submit" class="btn btn-success m-1"  name="search_date" value="Search"  style="float: left;height: 36px;">
                    </div>   
                </form>
            </div> 
            <div id="cardCollpase4" class="collapse show"  >
                <div class="row bodyoftable" style="padding: 0px 4px !important;">
                    <div class="col-sm-12" style="padding: 0px 4px !important;">
                        <div class="card-box card-table-style" style="padding: 0px 4px !important;">
                            <?php 
                            if (isset($_GET['search_date'])) { 
                               $date_from = $_GET['date_from'];
                               $date_to = $_GET['date_to'];
                               date_default_timezone_set("Asia/Karachi");
                               ?>
                               <table id="example" class="table table-centered table-striped table-bordered "  >

                                <thead >
                                    <tr>
                                        <th colspan="5"><?php echo $date_from." To ".$date_to ?></th>

                                    </tr>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Service</th>
                                        <th>Total Patients</th>
                                        <th>Discount</th>
                                        <th>Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                   $sr = 1;
                                   $fetch_data = "SELECT *,count(ssh_p_services.ser_p_id) as pat,SUM(Paid) as Paid,SUM(Charges)-SUM(Paid) AS Discount From ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID WHERE ssh_ser_inv.ID = '".$_GET['service_id_search']."' AND CONVERT(ssh_p_services.Date,Date) BETWEEN '".$date_from."' AND '".$date_to."'  GROUP BY ssh_ser_inv.ID ";
                                   $fetch_data_ex = mysqli_query($con,$fetch_data);
                                   foreach($fetch_data_ex as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $sr ?></td>
                                        <td><?php echo $row['Title'];  ?></td>
                                        <td><?php echo $row['pat'] ?>
                                            <button class='btn btn-success ml-1' onclick='view_services_records(<?php echo $row['ID'] ?>);' style='padding: 4px 4px; float:right;'><i class='fa fa-eye'> </i></button>

                                            <input type="date" id="date_from" hidden value="<?php echo $date_from ?>">
                                            <input type="date" id="date_to" hidden value="<?php echo $date_to ?>">
                                        </td>
                                        <td><?php echo $row['Discount']  ?></td>
                                        <td><?php echo number_format((float)$row['Paid'], 2, '.', '');  ?> </td></td>

                                    </tr>


                                    <?php
                                    $sr++;
                                } ?>
                            </tbody>
                        </table>
                    <?php }else{
                        date_default_timezone_set("Asia/Karachi");
                        ?>
                        <table id="example" class="table table-centered table-striped table-bordered " >

                            <thead >
                                <tr>
                                    <th colspan="5"><?php echo date('Y-m-d') ;?></th>
                                </tr>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Service</th>
                                    <th>Total Patients</th>
                                    <th>Discount</th>
                                    <th>Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                   $sr = 1;
                                   $fetch_data = "SELECT *,count(ssh_p_services.ser_p_id) as pat,SUM(Paid) as Paid,SUM(Charges)-SUM(Paid) AS Discount From ssh_p_services JOIN ssh_ser_cat ON ssh_p_services.C_ID = ssh_ser_cat.C_ID JOIN ssh_ser_inv ON ssh_ser_cat.ser_id = ssh_ser_inv.ID WHERE CONVERT(ssh_p_services.Date,Date) BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d')."' GROUP BY ssh_ser_inv.ID ";
                                   $fetch_data_ex = mysqli_query($con,$fetch_data);
                                   foreach($fetch_data_ex as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $sr ?></td>
                                        <td><?php echo $row['Title'];  ?></td>
                                        <td><?php echo $row['pat'] ?>
                                            <button class='btn btn-success ml-1' onclick='view_services_records(<?php echo $row['ID'] ?>);' style='padding: 4px 4px; float:right;'><i class='fa fa-eye'> </i></button>

                                            <input type="date" id="date_from" hidden value="<?php echo date('Y-m-d') ?>">
                                            <input type="date" id="date_to" hidden value="<?php echo date('Y-m-d') ?>">
                                        </td>
                                        <td><?php echo $row['Discount']  ?></td>
                                        <td><?php echo number_format((float)$row['Paid'], 2, '.', '');  ?> </td></td>

                                    </tr>


                                    <?php
                                    $sr++;
                                } ?>




                            </tbody>
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
    function pay_this_doc(idcus) {
        var get_total_payment = $("#total_payment"+idcus).val();
        var payment_date = $("#payment_date").val();
        $.ajax({
            type:"POST",
            url:"models/doctor_ledger.php",
            data: {doctor_paid_oudoor:idcus,get_total_payment:get_total_payment,payment_date:payment_date},
            success:function(data) {
                location.reload();
            }
        });
    }
    function view_indoor(idcus) {
        var idcus = idcus;
        var payment_date = $("#payment_date").val();
        var doc_name = $("#doc_name").val();
        
        $.ajax({
            type:"POST",
            url:"models/doctor_ledger.php",
            data: {view_indoor_records :idcus,payment_date:payment_date,doc_name:doc_name},
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
    function view_services_records(idcus) {
        var idcus = idcus;
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();
        $.ajax({
            type:"POST",
            url:"models/other_services.php",
            data: {view_services_records:idcus,date_from:date_from,date_to:date_to},
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
</script>   