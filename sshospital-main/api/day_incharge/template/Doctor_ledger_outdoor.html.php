<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> View Records </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                <input type="date" class="form-control"  name="search_date"  onchange="this.form.submit()" style="border: 1px solid red;width: 150px;float: left;" required>
                               <!--  <span style="float: left;" class="m-2"><b>To</b></span>
                                <input type="date" class="form-control"  name="date_to"  style="border: 1px solid red;width: 150px;float: left;" required>
                                <input type="button" class="btn btn-success ml-1"  name="search_date" value="Search"  style="float: left;height: 36px;"> -->
                        </div>   
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
                                        <th colspan="6"><?php echo $_GET['search_date']."<br>".date('l',strtotime($_GET['search_date'])) ?></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Doctor CNIC</th>
                                        <th>Doctor Name</th>
                                        <th>Total Patient</th>
                                        <th>Total Payment</th>
                                        <th>Doctor Share</th>
                                        <th>Hospital Share</th>
                                        <th>Discount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_patient = 0;
                                    $total_payment = 0;
                                    $total_doc_share = 0;
                                    $hospital_share = 0;
                                    $total_discount = 0; 
                                    $fetch_data = "SELECT ssh_dr_reg.D_ID,ssh_dr_reg.CNIC,ssh_dr_reg.Name,COUNT(ssh_p_dpr.MRN) AS Patients,SUM(ssh_p_dpr.D_Pay - ((ssh_p_dpr.D_Pay*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100) AS outdoor,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN))  AS hospitalshare,SUM(ssh_p_dpr.Charges-ssh_p_dpr.Paid) AS Discount,SUM((ssh_p_dpr.Charges-ssh_p_dpr.Paid)/2) AS doctor_discount FROM ssh_dr_reg, ssh_p_dpr
                    WHERE ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
                    AND CONVERT(ssh_p_dpr.A_DATE,Date) = '".$_GET['search_date']."'
                                    GROUP BY ssh_p_dpr.D_ID";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                        ?>
                                        <tr>
                                            <td><?php echo $row['CNIC']  ?></td>
                                            <td><?php echo $row['Name']  ?>
                                            <input type="hidden" id="doc_name<?php echo $row['D_ID'] ?>" value="<?php echo $row['Name']  ?>">
                                            <input type="date" id="payment_date" hidden value="<?php  echo $_GET['search_date'] ?>"></td>
                                            <td><?php echo $row['Patients']  ?></td>

                                            <td><?php echo  number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '')  ?></td>

                            <td><?php echo number_format((float)$row['outdoor'], 2, '.', '');  ?> <button class='btn btn-success ml-1' onclick='view_outdoor(<?php echo $row['D_ID'] ?>);' style='padding: 4px 4px; float:right;'><i class='fa fa-eye'> </i></button></td>
                            <td><?php echo  number_format((float)$row['hospitalshare'], 2, '.', '')  ?></td>
                            <td><?php echo number_format((float)$row['Discount'], 2, '.', '')  ?></td>



                                            <input type="hidden" value="<?php echo number_format((float)$row['outdoor'], 2, '.', '') ;?>" id="total_payment<?php echo $row['D_ID'] ?>">
                                            <input type="hidden" value="<?php echo number_format((float)$row['hospitalshare'], 2, '.', '') ;?>" id="hospitalshare<?php echo $row['D_ID'] ?>">
                                            <?php
                                            $fetch_data3 = " SELECT * FROM  ssh_dr_payment WHERE Date = '".$_GET['search_date']."'   AND D_ID = '".$row['D_ID']."' AND status = '0' ";
                                            $fetch_data3_ex = mysqli_query($con,$fetch_data3);
                                            if (mysqli_num_rows($fetch_data3_ex) > 0) { ?>
                                                <td class="text-center"><button class="btn btn-success ml-1 disabled" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Paid</button></td>
                                            <?php }else{
                                                ?>
                                                <td class="text-center"><button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>

                                                <?php 
                                            }
                                            $total_patient += $row['Patients'];
                                            $total_payment += number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '');
                                            $total_doc_share += number_format((float)$row['outdoor'], 2, '.', '');
                                            $hospital_share += number_format((float)$row['hospitalshare'], 2, '.', '');
                                            $total_discount += number_format((float)$row['Discount'], 2, '.', '');
                                        }
                                            ?>
                                        </tr> 
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_patient ?></b></td>
                                        <td class="text-center"><b><?php echo $total_payment ?></b></td>
                                        <td class="text-center"><b><?php echo $total_doc_share ?></b></td>
                                        <td class="text-center"><b><?php echo $hospital_share ?></b></td>
                                        <td class="text-center"><b><?php echo $total_discount ?></b></td>
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
                                        <th colspan="6"><?php echo date('Y-m-d')."<br>".date('l') ?></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Doctor CNIC</th>
                                        <th>Doctor Name</th>
                                        <th>Total Patient</th>
                                        <th>Total Payment</th>
                                        <th>Doctor Share</th>
                                        <th>Hospital Share</th>
                                        <th>Discount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                               <tbody>
                                    <?php 
                                    $total_patient = 0;
                                    $total_payment = 0;
                                    $total_doc_share = 0;
                                    $hospital_share = 0;
                                    $total_discount = 0; 
                                    $fetch_data = "SELECT ssh_dr_reg.D_ID,ssh_dr_reg.CNIC,ssh_dr_reg.Name,COUNT(ssh_p_dpr.MRN) AS Patients,SUM(ssh_p_dpr.D_Pay - ((ssh_p_dpr.D_Pay*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100) AS outdoor,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN))  AS hospitalshare,SUM(ssh_p_dpr.Charges-ssh_p_dpr.Paid) AS Discount,SUM((ssh_p_dpr.Charges-ssh_p_dpr.Paid)/2) AS doctor_discount FROM ssh_dr_reg, ssh_p_dpr
                    WHERE ssh_p_dpr.D_ID = ssh_dr_reg.D_ID
                    AND CONVERT(ssh_p_dpr.A_DATE,Date) = '".Date('Y-m-d')."'
                                    GROUP BY ssh_p_dpr.D_ID";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                        ?>
                                        <tr>
                                            <td><?php echo $row['CNIC']  ?></td>
                                            <td><?php echo $row['Name']  ?>
                                            <input type="hidden" id="doc_name<?php echo $row['D_ID'] ?>" value="<?php echo $row['Name']  ?>">
                                            <input type="date" id="payment_date" hidden value="<?php  echo Date('Y-m-d') ?>"></td>
                                            <td><?php echo $row['Patients']  ?></td>

                                            <td><?php echo  number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '')  ?></td>

                            <td><?php echo number_format((float)$row['outdoor'], 2, '.', '');  ?> <button class='btn btn-success ml-1' onclick='view_outdoor(<?php echo $row['D_ID'] ?>);' style='padding: 4px 4px; float:right;'><i class='fa fa-eye'> </i></button></td>
                            <td><?php echo  number_format((float)$row['hospitalshare'], 2, '.', '')  ?></td>
                            <td><?php echo number_format((float)$row['Discount'], 2, '.', '')  ?></td>



                                            <input type="hidden" value="<?php echo number_format((float)$row['outdoor'], 2, '.', '') ;?>" id="total_payment<?php echo $row['D_ID'] ?>">
                                            <input type="hidden" value="<?php echo number_format((float)$row['hospitalshare'], 2, '.', '') ;?>" id="hospitalshare<?php echo $row['D_ID'] ?>">
                                            <?php
                                            $fetch_data3 = " SELECT * FROM  ssh_dr_payment WHERE Date = '".Date('Y-m-d')."'   AND D_ID = '".$row['D_ID']."' AND status = '0' ";
                                            $fetch_data3_ex = mysqli_query($con,$fetch_data3);
                                            if (mysqli_num_rows($fetch_data3_ex) > 0) { ?>
                                                <td class="text-center"><button class="btn btn-success ml-1 disabled" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Paid</button></td>
                                            <?php }else{
                                                ?>
                                                <td class="text-center"><button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>

                                                <?php 
                                            }
                                            $total_patient += $row['Patients'];
                                            $total_payment += number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '');
                                            $total_doc_share += number_format((float)$row['outdoor'], 2, '.', '');
                                            $hospital_share += number_format((float)$row['hospitalshare'], 2, '.', '');
                                            $total_discount += number_format((float)$row['Discount'], 2, '.', '');
                                        }
                                            ?>
                                        </tr> 
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_patient ?></b></td>
                                        <td class="text-center"><b><?php echo $total_payment ?></b></td>
                                        <td class="text-center"><b><?php echo $total_doc_share ?></b></td>
                                        <td class="text-center"><b><?php echo $hospital_share ?></b></td>
                                        <td class="text-center"><b><?php echo $total_discount ?></b></td>
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
    function pay_this_doc(idcus) {
        var get_total_payment = $("#total_payment"+idcus).val();
        var hospital_share = $("#hospitalshare"+idcus).val();
        var payment_date = $("#payment_date").val();
        $.ajax({
            type:"POST",
            url:"models/doctor_ledger.php",
            data: {doctor_paid_oudoor:idcus,get_total_payment:get_total_payment,payment_date:payment_date,hospitalshare:hospital_share},
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
    function view_outdoor(idcus) {
        var idcus = idcus;
        var payment_date = $("#payment_date").val();
        var doc_name = $("#doc_name"+idcus).val();
        
        $.ajax({
            type:"POST",
            url:"models/doctor_ledger.php",
            data: {view_outdoor_records :idcus,payment_date:payment_date,doc_name:doc_name},
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
</script>   