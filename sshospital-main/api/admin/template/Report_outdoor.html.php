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
    <div class="card ">
        <div class="card-body" dir="ltr">
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="text-center">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row col-sm-12">

                        <select  class="m-1" id="selectize-programmatic2" name="doc_id" onchange="getdocprice()" placeholder="Select Doctor" style=";width: 150px;float: left;" required>
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
                               $total_payment = 0;
                               $doctor_share = 0;
                               $hospital_share = 0;
                               $total_discount = 0;
                               $total_patient = 0;
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
                                        <th>Date</th>
                                        <th>Total Patient</th>
                                        <th>Total Payment</th>
                                        <th>Doctor Share</th>
                                        <th>Hospital Share</th>
                                        <th>Discount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sr = 1;
                                    $fetch_data = "SELECT ssh_dr_reg.D_ID,ssh_dr_reg.CNIC,ssh_p_dpr.A_DATE,COUNT(ssh_p_dpr.MRN) AS patients,SUM(ssh_p_dpr.D_Pay - ((ssh_p_dpr.D_Pay*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100) AS outdoor,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN))  AS hospitalshare,SUM(ssh_p_dpr.Charges-ssh_p_dpr.Paid) AS Discount,SUM((ssh_p_dpr.Charges-ssh_p_dpr.Paid)/2) AS doctor_discount,SUM(ssh_p_dpr.Charges-ssh_p_dpr.Paid) AS Discount FROM ssh_dr_reg, ssh_p_dpr

                                    WHERE ssh_p_dpr.D_ID=ssh_dr_reg.D_ID AND CONVERT(ssh_p_dpr.A_DATE,Date) BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."' AND ssh_p_dpr.D_ID = '".$_GET['doc_id'] ."' GROUP BY CONVERT(ssh_p_dpr.A_DATE,Date)";
                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                        ?>
                                        <tr>
                                            <input type="hidden" id="doc_name<?php echo $row['D_ID'] ?>" value="<?php echo $doc_name ?>">
                                            <input type="date" id="payment_date<?php echo $sr; ?>" hidden value="<?php  echo date('Y-m-d',strtotime($row['A_DATE'])) ?>"></td>

                                            <td><?php echo date('Y-m-d',strtotime($row['A_DATE'])) ?></td>
                                            <td><?php echo $row['patients']  ?><button class='btn btn-success ml-1' onclick='view_outdoor(<?php echo $row['D_ID'] ?>,<?php echo $sr; ?>);' style='padding: 4px 4px; float:right;'><i class='fa fa-eye'> </i></button></td>
                                            <td><?php echo  number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '')  ?></td>

                                            <td><?php echo number_format((float)$row['outdoor'], 2, '.', '');  ?> </td></td>
                                            <td><?php echo  number_format((float)$row['hospitalshare'], 2, '.', '')  ?></td>
                                            <td><?php echo number_format((float)$row['Discount'], 2, '.', '')  ?></td>
                                            
                                            <?php 
                                            $total_payment += number_format((float)$row['outdoor'], 2, '.', '') + number_format((float)$row['hospitalshare'], 2, '.', '') +  number_format((float)$row['Discount'], 2, '.', '');
                                            $doctor_share += number_format((float)$row['outdoor'], 2, '.', '');
                                            $hospital_share += number_format((float)$row['hospitalshare'], 2, '.', '');
                                            $total_discount += number_format((float)$row['Discount'], 2, '.', '');
                                             $total_patient += $row['patients'];
                                            $sr++;
                                        }
                                        ?>
                                    </tr> 
                                </tbody>
                                <tfoot style="background: lightgrey !important;">
                                    <tr>
                                        <td></td>
                                        <td class="text-center"><b><?php echo $total_patient ?></b></td>
                                        <td class="text-center"><b><?php echo $total_payment ?></b></td>
                                        <td class="text-center"><b><?php echo $doctor_share ?></b></td>
                                        <td class="text-center"><b><?php echo $hospital_share ?></b></td>
                                        <td class="text-center"><b><?php echo $total_discount ?></b></td>

                                    </tr>
                                </tfoot>
                            </table>
                        <?php }else{
                            ?>
                            <div class="alert alert-success">Select Doctor, Date Range to view Records !!</div>
                            <?php 
                        } ?>
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
                Swal.fire(
                  'Paid!',
                  'Record has been Updated.',
                  'success'
                  )
                reloadtablecontent();
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
    function view_outdoor(idcus,uniquedate) {
        var idcus = idcus;
        var uniquedate = uniquedate;
        var payment_date = $("#payment_date"+uniquedate).val();
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