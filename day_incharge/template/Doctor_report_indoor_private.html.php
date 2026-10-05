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

                        <select  class="m-1" id="selectize-programmatic2" name="doc_id" onchange="getdocprice()" placeholder="Select Doctor" style=";width: 200px;float: left;" required>
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
                 $fetch_data = "
SELECT 
    d.D_ID,
    dr.Name,
    COUNT(DISTINCT p.pi_id) AS numberofcase,
    SUM(d.D_Fee) AS doctor_fee,
    SUM(p.Paid) AS total_paid,
    SUM(p.Paid) - SUM(all_docs.total_fee) AS hospital_share
FROM ssh_p_indoor p
JOIN ssh_p_indoor_doctors d ON p.pi_id = d.pi_id
JOIN ssh_dr_reg dr ON d.D_ID = dr.D_ID
JOIN (
    SELECT pi_id, SUM(D_Fee) AS total_fee
    FROM ssh_p_indoor_doctors
    GROUP BY pi_id
) all_docs ON p.pi_id = all_docs.pi_id
WHERE d.to_paid = '1'
  AND p.admition_type = '0'
  AND CONVERT(p.admit_date, DATE) 
      BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."'
  AND d.D_ID = '".$_GET['doc_id']."'
GROUP BY d.D_ID";


                                    $fetch_data_ex = mysqli_query($con,$fetch_data);
                                    foreach($fetch_data_ex as $row){ 
                                        ?>
                                        <tr>
                                            <td><?php echo $sr_no  ?></td>
                                            
                                            <td><?php echo $row['Name']  ?></td>
                                            
                                            <input type="date" id="date_from" value="<?php echo $_GET['date_from'] ?>" hidden>
                                            <input type="date" id="date_to" value="<?php echo $_GET['date_to'] ?>" hidden>
<td>
  <?php echo $row['numberofcase'] ?>
  <button class='btn btn-success ml-1' 
          onclick='view_indoor_private(<?php echo $row['D_ID'] ?>,0);' 
          style='padding: 4px 4px; float:right;'>
      <i class='fa fa-eye'></i>
  </button>
</td>

<td><?php echo $row['total_paid'] ?></td>
<td><?php echo $row['doctor_fee'] ?></td>
<td><?php echo $row['hospital_share'] ?></td>

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
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();
        
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