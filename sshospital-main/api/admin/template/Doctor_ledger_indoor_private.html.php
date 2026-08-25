<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> View Records </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl ">
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
                                        <th></th>
                                        <th colspan="3">Pending Payments</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Doctor CNIC</th>
                                        <th>Doctor Name</th>
                                        <th>Total  Case</th>
                                        <th>Total Payment</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $fetch_data = "Select *,SUM(ssh_p_indoor_doctors.D_Fee) AS fee from ssh_p_indoor_doctors JOIN ssh_p_indoor ON ssh_p_indoor_doctors.pi_id = ssh_p_indoor.pi_id LEFT JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID Where ssh_p_indoor_doctors.to_paid = '0' AND ssh_p_indoor.admition_type = '0' GROUP BY ssh_p_indoor_doctors.D_ID";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                         $fetch_data2 = "Select * from ssh_p_indoor JOIN ssh_p_indoor_doctors   ON  ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id    where ssh_p_indoor_doctors.D_ID = '".$row['D_ID']."' AND ssh_p_indoor.admition_type = '0' AND ssh_p_indoor_doctors.to_paid = '0' ";
                                        $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                                        ?>
                                        <tr>
                                            <td><?php echo $row['CNIC']  ?></td>
                                            <td><?php echo $row['Name']  ?></td>
                                            <td><?php echo mysqli_num_rows($fetch_data2_ex)  ?><button class='btn btn-success ml-1' onclick='view_indoor_private(<?php echo $row['D_ID'] ?>,0);' style='padding: 4px 4px; float:right;'><i class='fa fa-edit'> </i></button></td>
                                            <td><?php echo $row['fee']  ?></td>
                                            <input type="hidden" value="<?php echo number_format((float)$row['fee'], 2, '.', '') ;?>" id="total_payment<?php echo $row['D_ID'] ?>">
                                            <td class="text-center"><button class="btn btn-success ml-1" onclick="approve_doc(pay_this_doc,<?php echo $row['D_ID']; ?>,0);" style="font-size:12px;height:28px !important; width:70px; padding: 4px 4px;background: green !important;color: white !important;";>Pay</button></td>                                            
                                        </tr> 
                                    <?php } ?>    
                                </tbody>
                                <!-- <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_charges ?></b></td>
                                        <td class="text-center"><b><?php echo $total_paid ?></b></td>
                                    </tr>
                                </tfoot> -->
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
    function pay_this_doc(idcus,whichone) {
        var get_total_payment = $("#total_payment"+idcus).val();
        $.ajax({
            type:"POST",
            url:"models/doctor_ledger.php",
            data: {doctor_paid_indoor:idcus,get_total_payment:get_total_payment,whichone:whichone},
            success:function(data) {
                location.reload();
            }
        });
    }
    function view_indoor_private(idcus,whichone) {
        var idcus = idcus;
        var whichone = whichone;
        $.ajax({
            type:"POST",
            url: "models/doctor_ledger.php",
            data: {view_indoor_private_records_doc_pay:idcus,whichone:whichone},
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
    function pay_this_doc_indivi(idcus,case_id) {
        var get_total_payment = $("#total_payment_p_ind"+case_id).val();
       
        $.ajax({
            type:"POST",
            url:"models/doctor_ledger.php",
            data: {doctor_paid_indoor_private:idcus,get_total_payment:get_total_payment,case_id:case_id},
            success:function(data) {
                var rowh = "#removethispay_private"+case_id;
                $(rowh).remove();
                Swal.fire(
                  'Paid!',
                  'Record has been Updated.',
                  'success'
                  )
                // alert(data);
            }
        });
    }
    // function view_outdoor(idcus) {
    //     var idcus = idcus;
    //     var payment_date = $("#payment_date").val();
    //     var doc_name = $("#doc_name"+idcus).val();
        
    //     $.ajax({
    //         type:"POST",
    //         url:"models/doctor_ledger.php",
    //         data: {view_outdoor_records :idcus,payment_date:payment_date,doc_name:doc_name},
    //         success:function(data) {
    //             $('.modalbody1').html(data);
    //             $('#updateinfobutton').trigger('click');
    //         }
    //     });
    // };
</script>   