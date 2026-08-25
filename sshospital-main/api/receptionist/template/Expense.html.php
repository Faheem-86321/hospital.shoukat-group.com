
<style>
@media print {
  thead { display: table-header-group !important; }
  tfoot { display: table-footer-group !important; }
}
</style>
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update Expense </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update Expense</h4>
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
                <h4 class="modal-title" id="myCenterModalLabel">Add Expense</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="name">Title <span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" name="ex_title" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Amount<span style="color: red;"> *</span></label>
                            <input type="number" class="form-control" name="ex_price" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Date <span style="color: red;"> *</span></label>
                            <input type="date" class="form-control" name="ex_date" value="<?php  echo date('Y-m-d') ;?>" required>
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
            <button id="onloadclick" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Expense</button>
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div style="float: left;"> <p>&nbsp&nbsp</p> </div>
            <div class="text-center">
                <br>
                <br>
                   <form action="" method="get" enctype="multipart/form-data">
                    <div class="row col-sm-12">  
                        
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
                                date_default_timezone_set("Asia/Karachi");
                                if (isset($_GET['search_date'])) { ?>
                                  <table id="expenseTable" class="table table-centered table-striped table-bordered mb-0 toggle-circle">
    <thead>
        <tr>
            <th></th>
            <th colspan="3"><?php echo $_GET['date_from']." To ".$_GET['date_to'] ?></th>
            <th></th>
        </tr>
        <tr>
            <th>Sr No.</th>
            <th class="noExport">Option</th>
            <th>Title</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $sr_no = 1;
        $total_ex = 0;
        $fetch_data = "SELECT * FROM `ssh_expenses` 
        WHERE date >= '".$_GET['date_from']."' 
        AND date <= '".$_GET['date_to']."' 
        AND services = '0'  
        AND user_id = '".$_SESSION['user_id']."'";

        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ ?>
            <tr id="<?php echo $row['Voucher'] ?>">
                <td><?php echo $sr_no; ?></td>
                <td>
                    <a class='btn btn-primary' onclick="update_info(<?php echo $row['Voucher']; ?>);">
                        <i class='fa fa-edit'></i>
                    </a>
                </td>
                <td><?php echo $row['Title']; ?></td>
                <td><?php echo $row['Amount']; ?></td>
                <td><?php echo $row['Date']; ?></td>
            </tr>
        <?php 
        $total_ex += $row['Amount'];
        $sr_no++;
        } ?>
    </tbody>

    <!-- ✅ IMPORTANT: Footer must be here -->
    <tfoot style="background: lightgrey;">
        <tr>
            <td></td>
            <td></td>
            <td class="text-center"><b>Total</b></td>
            <td class="text-center"><b><?php echo $total_ex ?></b></td>
            <td></td>
        </tr>
    </tfoot>
</table>
                            </table>
                               <?php  }else{ ?>
                               <table id="expenseTable" class="table table-centered table-striped table-bordered mb-0 toggle-circle">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th><?php echo date('Y-m-d')."<br>".date('l') ?></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>Sr No.</th>
            <th class="noExport">Option</th>
            <th>Title</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $sr_no = 1;
        $total_ex = 0;

        $fetch_data = "SELECT * FROM `ssh_expenses` 
        WHERE date = '".date('Y-m-d')."' 
        AND services = '0' 
        AND user_id = '".$_SESSION['user_id']."'";

        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ ?>
            <tr id="<?php echo $row['Voucher'] ?>">
                <td><?php echo $sr_no; ?></td>
                <td>
                    <a class='btn btn-primary' onclick="update_info(<?php echo $row['Voucher']; ?>);">
                        <i class='fa fa-edit'></i>
                    </a>
                </td>
                <td><?php echo $row['Title']; ?></td>
                <td><?php echo $row['Amount']; ?></td>
                <td><?php echo $row['Date']; ?></td>
            </tr>
        <?php 
        $total_ex += $row['Amount'];
        $sr_no++;
        } ?>
    </tbody>

    <!-- ✅ IMPORTANT -->
    <tfoot style="background: lightgrey;">
        <tr>
            <td></td>
            <td></td>
            <td class="text-center"><b>Total</b></td>
            <td class="text-center"><b><?php echo $total_ex ?></b></td>
            <td></td>
        </tr>
    </tfoot>
</table>
                                <?php }
                                ?>
                            
                    </div> <!-- end card-box -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>    
    </div>
</div> 
</div>       

<script type="text/javascript">
    
    $('#expenseTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            footer: true,
            exportOptions: {
                columns: ':not(.noExport)'
            }
        },
        {
            extend: 'print',
            footer: true,
            exportOptions: {
                columns: ':not(.noExport)'
            }
        },
        {
            extend: 'pdfHtml5',
            footer: true,
            exportOptions: {
                columns: ':not(.noExport)'
            }
        }
    ]
});

    function update_info(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/expense.php",
            data: 'expense_update='+idcus,
            success:function(data) {
                $('.modalbody1').html(data);
                $('#updateinfobutton').trigger('click');
            }
        });
    };
    function delC(idcus) {
    var idcus = idcus;
    $.ajax({
        type:"POST",
        url:"models/expense.php",
        data: 'expense_del='+idcus,
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