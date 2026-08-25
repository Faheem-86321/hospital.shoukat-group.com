
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Payment </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Payment</h4>
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
                <h4 class="modal-title" id="myCenterModalLabel">Add Inventory</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
               <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Product <span style="color: red;"> *</span></label>
                        <select class="form-control" required name="productname">
                            <option value="" selected disabled>--- Select Product ---</option>
                            <option value="X-Ray-Small">X-Ray-Small</option>
                            <option value="CT-Scan">CT-Scan Films</option>
                            <option value="X-Ray-Big">X-Ray-Big</option>
                            <option value="Bicarb solution">Bicarb solution</option>
                            <option value="Heparin">Heparin</option>
                            <option value="Dialysis Set">Dialysis Set</option>
                            <option value="Erythropoietin">Erythropoietin</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label for="name">Quantity <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" value="" name="quantity" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">Amount <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" value="" name="expense_d" required>
                    </div>
                    
                    <!-- -->
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
            <button id="onloadclick" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Inventory </button>
            <form action="" method="get" enctype="multipart/form-data">
                <div class="row col-sm-12">  
                    <input type="submit" class="btn btn-success mt-1"  name="view_stock" value="View Stock Availability"  style="float: left;height: 36px;">
                </div>   
            </form>
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
                                <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="6"><?php echo $_GET['date_from']." To ".$_GET['date_to'] ?></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Sr No.</th>

                                            <th>Title</th>
                                            <th>Amount</th>

                                            <th>Quantity</th>
                                            <th>Paid</th>
                                            <th>Payment Date</th>
                                            <th>Added Date</th>
                                            <th>Added By</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sr_no = 1;
                                        $paid = 0;
                                        $total_ex = 0;
                                        $fetch_data = "SELECT * FROM `ssh_expenses` JOIN wt_users ON ssh_expenses.user_id = wt_users.id where ssh_expenses.date >= '".$_GET['date_from']."' AND ssh_expenses.date <= '".$_GET['date_to']."' AND (Title = 'Bicarb solution' || Title = 'Heparin' || Title = 'Dialysis Set' || Title = 'Erythropoietin'  || Title = 'BTL'  || Title = 'Dialyzer' || Title = 'X-Rays Product' || Title = 'X-Ray-Small' || Title = 'X-Ray-Big' || Title = 'CT-Scan' )And ssh_expenses.services != '0'   ";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ ?>
                                            <tr id="<?php echo $row['Voucher'] ?>">
                                                <?php echo "<td>".$sr_no."</td>";
                                                $buttonedit = '';
                                                if ($row['Amount'] > $row['paid']) {
                                                    $buttonedit = "<a class='btn btn-success btn-view' onclick='paymentthis(".$row['Voucher'].");''  style='padding: 6px 6px;margin: 2px; border-radius: 3px;color: black;float:right '><i class='fa fa-plus ' aria-hidden='true'></i></a>";

                                                }else{
                                                     $buttonedit = '';
                                                }
                                                ?>
                                                <?php echo "<td>".$row['Title']."</td><td>".$row['Amount']."</td><td>".$row['quantity']."</td><td> <span style='float:left'>".$row['paid']." </span>".$buttonedit."</td><td>".$row['payment_date']."</td><td>".$row['Date']."</td><td>".ucwords($row['fname'])."</td>"; ?>
                                            </tr>
                                            <?php 
                                            $total_ex += $row['Amount'];
                                            $paid += $row['paid'];
                                            $sr_no++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot style="background: lightgrey !important;">
                                        <tr>
                                            <td></td>

                                            <td class="text-center"><b>Total</b></td>
                                            <td class="text-center"><b><?php echo $total_ex ?></b></td>
                                            <td></td>
                                            <td class="text-center"><b><?php echo $paid ?></b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php  }elseif (isset($_GET['view_stock'])) { ?>
                                <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                    <thead>
                                        <tr>

                                            <th colspan="4"><?php echo "Stock Availability" ?></th>

                                        </tr>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Item</th>
                                            <th>Available Stock </th>
                                            <th>Last Update Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sr_no = 1;
                                        $total_ex = 0;
                                        $fetch_data = "SELECT * FROM `ssh_ser_inv` where ID = '1' OR ID = '2' OR ID = '6'";
                                        $fetch_data_ex = mysqli_query($con,$fetch_data);
                                        foreach($fetch_data_ex as $row){ ?>
                                            <tr id="">
                                                <?php echo "<td>".$sr_no."</td>";?>
                                                <?php echo "<td>".$row['Title']."</td><td>".$row['Stock']."</td>"; 
                                                // $fetch_data_extned = "SELECT * FROM `ssh_expenses`where services = '".$row['ID']."' ORDER BY Voucher DESC LIMIT 1;";
                                                // $fetch_data_extned_ex = mysqli_query($con,$fetch_data_extned);
                                                // if (mysqli_num_rows($fetch_data_extned_ex) > 0) {
                                                //     foreach($fetch_data_extned_ex as $row12){ 
                                                    echo "<td>".$row['last_date']."</td>";
                                                   // }    
                                                // }else{
                                                //     echo "<td>N/A</td>";
                                                // }
                                                ?>

                                                </tr>
                                                <?php 
                                                $sr_no++;
                                            }
                                            $fetch_data = "SELECT * FROM `dialysis_item`";
                                            $fetch_data_ex = mysqli_query($con,$fetch_data);
                                            foreach($fetch_data_ex as $row){ ?>
                                                <tr id="">
                                                    <?php echo "<td>".$sr_no."</td>";?>
                                                    <?php echo "<td>".$row['item_name']."</td><td>".$row['stock']."</td>"; 
                                                 echo "<td>".$row['last_update']."</td>";
                                                ?>
                                                </tr>
                                                <?php 
                                                $sr_no++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php  }else{ ?>
                                    <table id="example"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th colspan="4" ><?php echo date('M')."<br>This Month" ?></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th>Sr No.</th>

                                                <th>Title</th>
                                                <th>Amount</th>
                                                <th>Quantity</th><th>Paid</th>
                                                <th>Payment Date</th>
                                                <th>Added Date</th>
                                                <th>Added By</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_ex = 0;
                                            $paid = 0;
                                            $sr_no = 1;
                                            $fetch_data = "SELECT * FROM `ssh_expenses`JOIN wt_users ON ssh_expenses.user_id = wt_users.id  where MONTH(CONVERT(ssh_expenses.date,Date)) = MONTH(CURRENT_DATE()) And ssh_expenses.services != '0' ";
                                            $fetch_data_ex = mysqli_query($con,$fetch_data);
                                            foreach($fetch_data_ex as $row){ ?>
                                                <tr>
                                                <?php echo "<td>".$sr_no."</td>";
                                                $buttonedit = '';
                                                if ($row['Amount'] > $row['paid']) {
                                                    $buttonedit = "<a class='btn btn-success btn-view' onclick='paymentthis(".$row['Voucher'].");''  style='padding: 6px 6px;margin: 2px; border-radius: 3px;color: black;float:right '><i class='fa fa-plus ' aria-hidden='true'></i></a>";

                                                }else{
                                                     $buttonedit = '';
                                                } echo "<td>".$row['Title']."</td><td>".$row['Amount']."</td><td>".$row['quantity']."</td><td> <span style='float:left'>".$row['paid']." </span>".$buttonedit."</td><td>".$row['payment_date']."</td><td>".$row['Date']."</td><td>".ucwords($row['fname'])."</td>"; ?>
                                            </tr>
                                                <?php
                                                $total_ex += $row['Amount'];
                                                $paid += $row['paid'];
                                                $sr_no++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot style="background: lightgrey !important;">
                                            <tr>
                                                <td></td>

                                                <td class="text-center"><b>Total</b></td>
                                                <td class="text-center"><b><?php echo $total_ex ?></b></td>
                                                <td></td>
                                                <td class="text-center"><b><?php echo $paid ?></b></td>
                                                <td></td>
                                                <td></td>
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
         function paymentthis(idcus) {
            var idcus = idcus;
            $.ajax({
                type:"POST",
                url:"models/expense.php",
                data: 'expense_payment='+idcus,
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