
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Add Payment Details </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Add Payment Details</h4>
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
            <div style="float: left;"> <p>&nbsp&nbsp</p> </div>
            
            <div id="cardCollpase4" class="collapse show"  >
                <div class="row bodyoftable" style="padding: 0px 4px !important;">
                    <div class="col-sm-12" style="padding: 0px 4px !important;">
                        <div class="card-box card-table-style" style="padding: 0px 4px !important;">
                         <table id="example_withoutsort"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Date</th>
                                    <th>No of Files</th>
                                    <th>Recieved Payment</th>
                                    <th>Claim No</th>
                                    <th>Cheq Date</th>
                                    <th>Voucher No</th>
                                    <th>Cheq No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_ex = 0;
                                $sr_no = 1;
                                $fetch_data = "SELECT *,SUM(Paid) as Paid,count(pi_id) as tpi_id FROM ssh_p_indoor where file_status = '2' AND receive_date != '0000-00-00' GROUP BY receive_date Order BY receive_date DESC";
                                $fetch_data_ex = mysqli_query($con,$fetch_data);
                                foreach($fetch_data_ex as $row){ ?>
                                    <tr >
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['receive_date']."</td>";?>
                                        <?php echo "<td>".$row['tpi_id']."</td><td>".$row['Paid']."</td>"; ?>
                                        <?php 
                                            if (empty($row['payment_details'])) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                 <td> <a class='btn btn-primary ' onclick="update_info(<?php echo $row['pi_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-plus' aria-hidden='true'></i></a></td>
                                            <?php }else{
                                                $p_data = explode("!@#$%^&*()",$row['payment_details']);
                                                ?>
                                                <td><?php echo $p_data[0]; ?></td>
                                                <td><?php echo $p_data[1]; ?></td>
                                                <td><?php echo $p_data[2]; ?></td>
                                                <td><?php echo $p_data[3]; ?></td>
                                                <td></td>
                                            <?php }
                                        ?>
                                       
                                    </tr>

                                    <?php 
                                }
                                ?>
                                <tr style="background: lightgrey !important;">

                                    <td ></td>

                                    <td></td>

                                    <td></td>
                                    <td></td>
                                    <td style="background: lightgrey !important; float: left;"><b>Dialysis</b></td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                $fetch_data = "SELECT *,SUM(Paid) as Paid,count(pd_id) as tpd_id FROM ssh_p_dialysis where file_status = '2' AND receive_date != '0000-00-00' GROUP BY receive_date  ";
                                $fetch_data_ex = mysqli_query($con,$fetch_data);
                                foreach($fetch_data_ex as $row){ ?>
                                    <tr >
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['receive_date']."</td>";?>
                                        <?php echo "<td>".$row['tpd_id']."</td><td>".$row['Paid']."</td>"; ?>
                                       <?php 
                                            if (empty($row['payment_details'])) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                 <td> <a class='btn btn-primary ' onclick="update_info_dialysis(<?php echo $row['pd_id']; ?>);" style='padding: 6px 6px;margin: 2px; border-radius: 3px;color:white'><i class='fa fa-plus' aria-hidden='true'></i></a></td>
                                            <?php }else{
                                                $p_data = explode("!@#$%^&*()",$row['payment_details']);
                                                ?>
                                                <td><?php echo $p_data[0]; ?></td>
                                                <td><?php echo $p_data[1]; ?></td>
                                                <td><?php echo $p_data[2]; ?></td>
                                                <td><?php echo $p_data[3]; ?></td>
                                                <td></td>
                                            <?php }
                                        ?>
                                    </tr>

                                    <?php 

                                }
                                ?>
                            </tbody>
                               <!--  <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>

                                        <td></td>
                                        <td class="text-center"><b>Total</b></td>
                                        <td class="text-center"><b><?php echo $total_ex ?></b></td>
                                        
                                        <td></td>
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
    function update_info(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'paymentdetailsINDOOR_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
    function update_info_dialysis(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'paymentdetailsDialysis_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
</script>   