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

                        <select  class="m-1" id="selectize-programmatic2" name="doc_id" onchange="getdocprice()" placeholder="Select Doctor" style="width: 200px !important;float: left;" required>
                        </select>   
                        
                        <input type="date" class="form-control m-1"  name="date_from"  style="width: 150px;float: left;" required>
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
                               date_default_timezone_set("Asia/Karachi");
                               $fetch_data1 = "SELECT * FROM ssh_dr_reg WHERE D_ID = '".$_GET['doc_id'] ."'";
                               $fetch_data1_ex = mysqli_query($con,$fetch_data1);
                               foreach($fetch_data1_ex as $row1){ 
                                $doc_name = $row1['Name'];
                            }
                            ?>
                            <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th colspan="4"><?php echo $doc_name."<br>".$_GET['date_from']." To ".$_GET['date_to'] ?></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Doctor Name</th>
                                        <th>Total  Case</th>
                                        <th>Total Payment</th>
                                        <th>Doctor Payment</th>
                                        <th>Hospital Share</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sr_no = 1;
                                    $fetch_data = "Select *,count(ssh_p_indoor.pi_id) as numberofcase,SUM(ssh_p_indoor_doctors.D_Fee) AS fee,SUM(ssh_p_indoor.Paid) as Paid from ssh_p_indoor JOIN ssh_p_indoor_doctors ON ssh_p_indoor.pi_id = ssh_p_indoor_doctors.pi_id JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID Where ssh_p_indoor_doctors.to_paid = '1' AND ssh_p_indoor.admition_type = '1' AND CONVERT(ssh_p_indoor.admit_date,Date) BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."' AND ssh_p_indoor_doctors.D_ID = '".$_GET['doc_id']."' GROUP BY ssh_p_indoor_doctors.D_ID";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                        ?>
                                        <tr>
                                            <td><?php echo $sr_no  ?></td>
                                            
                                            <td><?php echo $row['Name']  ?></td>
                                            
                                            <input type="date" id="date_from" value="<?php echo $_GET['date_from'] ?>" hidden>
                                            <input type="date" id="date_to" value="<?php echo $_GET['date_to'] ?>" hidden>

                                            <td><?php echo $row['numberofcase']  ?><button class='btn btn-success ml-1' onclick='view_indoor_private(<?php echo $row['D_ID'] ?>,1);' style='padding: 4px 4px; float:right;'><i class='fa fa-eye'> </i></button></td>

                                            <td><?php echo $row['Paid']  ?></td>
                                            <td><?php echo $row['fee']  ?></td>                                           
                                            <td><?php echo $row['Paid']-$row['fee']  ?></td>
                                        </tr> 
                                    <?php $sr_no++; } ?>
                                    <tr style="background: lightgrey !important;">

                                        <td><?php echo $sr_no  ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
  
                                        <td><strong>Paid</strong></td>

                                        <td><strong>Details</strong></td>
                                    </tr> 
                                    <?php 
                                    $fetch_data = "Select * from ssh_dr_payment_indoor JOIN ssh_dr_reg ON ssh_dr_payment_indoor.D_ID = ssh_dr_reg.D_ID Where ssh_dr_payment_indoor.type = '1' AND CONVERT(ssh_dr_payment_indoor.Date,Date) BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."' AND ssh_dr_payment_indoor.D_ID = '".$_GET['doc_id']."' ";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                        $sr_no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $sr_no  ?></td>
                                            <td></td><td></td>
                                            <td><?php echo $row['Name']  ?></td>
                                            <td><?php echo $row['payment'] ?></td>
                                            <td style="width: 400px;"><?php echo $row['checkno'] ?></td>                                            
                                        </tr> 
                                    <?php  } ?>    
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
                        <?php }else{
                            date_default_timezone_set("Asia/Karachi");
                            ?>
                            <div class="alert alert-success">Select Doctor, Date Range to view Records !!</div>
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
        $.ajax({
            type:"POST",
            url:"models/doctor_ledger.php",
            data: {doctor_paid_indoor:idcus,get_total_payment:get_total_payment},
            success:function(data) {
                location.reload();
            }
        });
    }
    function view_indoor_private(idcus,whichone) {
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();

        var idcus = idcus;
        var whichone = whichone;
        $.ajax({
            type:"POST",
            url: "models/doctor_ledger.php",
            data: {view_indoor_private_records_reports:idcus,whichone:whichone,date_from:date_from,date_to:date_to},
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
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