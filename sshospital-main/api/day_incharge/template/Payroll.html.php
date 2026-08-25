<?php 
$db->Select("*");
$db->From("wt_users");
$db->Where("status = '1' AND close = '1' AND type != 'admin' ");
$select_employee_query_ex = $db->result();

$db->Select('*','SUM(p_debit)','SUM(p_credit)');
$db->From("payments");
$db->Join("wt_users");
$db->ON("payments.e_id","wt_users.id");
$db->Where("payments.close = '1' AND payments.status = '1' GROUP BY payments.e_id");
$salary_month_new = $db->result();

?>
<style type="text/css">
    input[type=file]::-webkit-file-upload-button {
        display: none;
    }
</style>
<div class="col-xl-12  col-lg-12">
    <div class="card">
        <div class="card-body" dir="ltr">
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-12">
                        <a  type="button" href="../images/List of Employees.csv" download="List_of_Employees.csv" class="btn btn-secondary  " style="border-radius: 3px;" ><i class="fa fa-download"></i> Download Sample</a>
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                        <input  class="form-control"   min='<?php echo date("Y-m"); ?>' type="month" name="e_salary_date"  autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                        <input  class="form-control"   type="file" name="excel_file"  autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-2">
                        <input id="btn1" type="submit" name="Generatesalary" class="btn btn-Success search " style="border-radius: 3px;" value="Generate Salary">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-Success search ml-2" style="float: left; border-radius: 3px;" data-toggle="modal" data-target="#addpayment">
                        <i class="fa fa-plus"></i>
                    Release Payment  </button> 
                </div>
                <div class="col-md-12 mt-2">
                   <form action="" method="get" enctype="multipart/form-data">
                    <div class="row  ">


                        <div class="form-group col-md-3">

                            <select id="e_name" name="emp_id" class="form-control m-1"  required autofocus autocomplete="off">
                                <option value disabled selected>--- Select Employee ---</option>
                                <?php
                                /*$type_data = select_fun("customers",$con);*/
                                foreach ($select_employee_query_ex as $row) {
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['fname'])." ".ucwords($row['lname'])." / ".$row['aboutme'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div> 

                        <div class="form-group col-md-7">
                            <input type="date" class="form-control m-1 "  name="date_from"  style="width: 150px;float: left;" required>
                            <span style="float: left;" class="m-2"><b>To</b></span>
                            <input type="date" class="form-control m-1 "  name="date_to"  style="width: 150px;float: left;" required> <input type="submit" class="btn btn-success m-1  "  name="search_date" value="Search"  style=" height: 36px;">
                        </div>
                        <div class="form-group col-md-3">
                           
                        </div>
                    </div>   
                </form>
            </div>

        </div>

        <div id="cardCollpase4" class="collapse show"  >
            <div class="row bodyoftable" style="padding: 0px 4px !important;">
                <div class="col-sm-12" style="padding: 0px 4px !important;">
                    <div class="card-box card-table-style" style="padding: 0px 4px !important;">

                        <!-- Modal -->
                        <div class="modal fade" id="addpayment"tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Payment</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="background: transparent !important; color: white !important;">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label >Employee Name <span style="color: red;">*</span></label>
                                                <select id="e_name" name="e_name" class="form-control"  required autofocus autocomplete="off">
                                                    <option value disabled selected>--- Select Employee ---</option>
                                                    <?php
                                                    /*$type_data = select_fun("customers",$con);*/
                                                    foreach ($select_employee_query_ex as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['fname'])." ".ucwords($row['lname'])." / ".$row['aboutme'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label >Purpose <span style="color: red;">*</span></label>
                                                <select id="p_purpose" name="p_purpose" class="form-control"  required autofocus autocomplete="off">
                                                    <option value disabled selected>--- Select Purpose ---</option>
                                                    <option value="salary">Salary</option>
                                                    <option value="advance">Advance</option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label >Date <span style="color: red;">*</span></label>
                                                <input id="datepick" value="<?php echo Date('Y-m-d')?>" type="date" class="form-control" name="p_date"  required autofocus autocomplete="off" style="border: 1px solid lightgrey !important;">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label >Payment/Cash <span style="color: red;">*</span></label>
                                                <input value="0" type="number" id="payment_cash" onkeyup="payment_cash_fun();" class="form-control" name="e_cash" required autofocus autocomplete="off" style="border: 1px solid lightgrey !important;">
                                            </div>
                                            <div id="warnmsg1" class="col-md-12"></div>
                                            <div class="col-md-12">
                                                <div class="modal-footer">
                                                    <input id="submit_payment" type="submit" name="submit_payment" class="btn btn-Success form-group" value="Save">
                                                </div>    
                                            </div>
                                        </div>
                                    </form>
                                </div>    
                            </div>    
                        </div>
                    </div>
                    <button class="btn btn-Success search green_back" style="float: right; border-radius: 3px;" data-toggle="modal" data-target="#updatepayment" id="updatepayment1" hidden>aaaaa</button>
                    <div class="modal fade" id="updatepayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">

                         <!--  Modal content -->
                         <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title">Update Payment</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                              <div class="updatepayment">             
                              </div>
                          </div>     
                      </div>
                  </div>
              </div>
              <?php if (isset($_GET['emp_id'])){
                $employee_id = $_GET['emp_id'];
                $date_from = $_GET['date_from'];
                $date_to = $_GET['date_to'];
                $db->Select('*');
                $db->From("payments");
                $db->Join("wt_users");
                $db->ON("payments.e_id","wt_users.id");
                $db->Where("payments.e_id = ".$employee_id." AND payments.close = '1' AND payments.status = '1'  AND p_date BETWEEN '".$date_from."' AND '".$date_to."' ");
                $select_payments_employee_ex = $db->result();


                ?>
                <div id="viewrent" class="card-body">
                    <table id="example" class="display nowrap" style="width:100%;font-size: 12px;">
                        <thead>
                            <tr> 
                                <th>Date</th>
                                <th>Purpose</th>
                                <th>Salary</th>
                                <th>Bonus</th>
                                <th>Absents</th>
                                <th>Deduction</th>
                                <th>Total Payment</th>
                                <th>Release Payment</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <?php
                        foreach($select_payments_employee_ex as $row){
                            ?>  
                            <tbody>
                                <tr class="font-weight-bold">
                                    
                                    <td></td>
                                    <td></td><td></td>
                                    <td></td>
                                    <td><?php echo ucwords($row['fname'])." ".ucwords($row['lname'])."&nbsp | &nbsp".$row['aboutme']."<br>Current Monthly Salary : ".$row['salary']."<br>".date("d-m-Y", strtotime($date_from))." to ".date("d-m-Y", strtotime($date_to)) ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                </tr>
                                <?php
                                $sr = 1;
                                $remaining_amount = 0;
                                $debit = 0;
                                $credit = 0;
                                $t_debit = 0;
                                $t_credit = 0;
                                foreach ($select_payments_employee_ex as $row) {
                                    /*$res_data = select_cus_fun("rent",$con);*/
                                    $date = date("d-m-Y", strtotime($row['p_date']));
                                    $purpose = $row['p_purpose'];
                                    $credit = $row['p_credit'];
                                    $debit = $row['p_debit'];
                                    $remaining_amount = $credit - $debit;
                                    $t_debit += $debit;
                                    $t_credit += $credit;

                                    ?>
                                    <tr id="<?php echo $row['p_id'] ?>"> 
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo ucfirst($purpose); ?></td>
                                        <td><?php echo $row['total_salary']; ?></td>
                                        <td><?php echo $row['bonus']; ?></td>
                                        <td><?php echo $row['absents']; ?></td>
                                        <td><?php echo $row['deductions']; ?></td>
                                    <td><?php echo $debit; ?></td>
                                    <?php
                                     echo "<td>".$credit."<input type='hidden' id='idpayment' value='".$row['p_id']."' ><input type='hidden' id='idemployee' value='".$row['e_id']."' ></td>";
                                    ?>

                                    <td>
                                       <button id="btn-delete" class="btn btn-danger btn-delete" title="Delete Payment" style="" onclick="del(delS,<?php echo $row['p_id']; ?>);"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
                                   </td>
                               </tr>
                               <?php 
                               $sr++;
                           }

                           ?>
                       </tbody>
                       <thead>
                        <tr class="table-info font-weight-bold">
                             
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>  <th></th>
                            <th>Total</th>
                            <th><?php echo $t_debit; ?></th>
                            <th><?php echo $t_credit; ?> </th>
                            <?php 
                            $rem = $t_credit - $t_debit;
                            ?>
                            <th><?php if($rem < 0){ echo  "<span style='color:red'>".$rem."</span>"; }else{ echo  "<span style='color:green'>".$rem."</span>";  } ?></th>
                           
                        </tr>
                    </thead>
                </table>
            </div><hr>
            <?php 
        }
    }
    else{
        ?>
            <!-- <div id="viewrent" class="card-body">
                <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Name</th>
                            <th>About</th>
                            <th>Total Payment</th>
                            <th>Advanced Amount</th>
                            <th>Remaining Amount</th>
                            <th>Option</th>
                        </tr>
                    </thead>  
                    <tbody>
                        <?php
                        $sr = 1;
                        $remaining_amount = 0;
                        $debit = 0;
                        $credit = 0;
                        $t_debit = 0;
                        $t_credit = 0;
                        foreach ($salary_month_new as $salary_per_name_ex) {
                            /*$res_data = select_cus_fun("rent",$con);*/
                            $credit = $salary_per_name_ex['SUM(p_credit)'];
                            $debit = $salary_per_name_ex['SUM(p_debit)'];
                            $remaining_amount = $credit - $debit;
                            $t_debit += $debit;
                            $t_credit += $credit;

                            ?>
                            <tr>
                                <td><?php echo $sr ?></td>
                                <td><?php echo ucwords($salary_per_name_ex['fname'])." ".ucwords($salary_per_name_ex['lname'])."</td><td>".$salary_per_name_ex['aboutme']; ?></td>
                                <td><?php echo $debit; ?></td>
                                <?php
                                if ($remaining_amount > 0) {
                                    echo "<td>".$remaining_amount."</td><td>0</td>";
                                }else{
                                    echo "<td>0</td><td>".abs($remaining_amount)."</td>";   
                                }
                                ?>

                                <td><a href="payroll?emp_id=<?php echo $salary_per_name_ex['id']; ?>" id="btn-view" class="btn btn-primary btn-view" style="" title="view record for this name"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php 
                            $sr++;
                        }
                        ?>
                    </tbody>

                </table>
            </div><hr> -->
            <?php 
        }
        ?>
    </div><!-- container-fluid -->
</div><!-- custom-body -->
</div>
</div>
</div>
</div>
</div>

<!-- <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.9.0.min.js"></script> -->
<script type="text/javascript">

    function delS(idpayment) {
        var idpayment = idpayment;
    /*var employee_id = $(this).closest("tr").find('#employee_id').val();*/
        $.ajax({
            type:"POST",
            url:"models/payroll.php",
            data:"employee_payment_delete="+idpayment,
        /*data:{employee_payment_delete:idpayment,
            employee_id:employee_id
        },*/
            success:function(data) {
                var rowh = "#"+idpayment;
                $(rowh).remove();
                Swal.fire(
                  'Deleted!',
                  'Payment has been deleted.',
                  'success'
                  )
            }
        });
    }
    function check(id) {
      var checkBox = document.getElementById(id);
      var chkid = '#'+id;
      if (checkBox.checked == true){
         $(chkid).val(1);
         var x = $(chkid).val();
     } else {
        $(chkid).val(0);
        var x = $(chkid).val();
    }
}
function daysInMonth (month, year) {
    return new Date(year, month, 0).getDate();
}
function t_salary(id){
    var idsalary = "#sal"+id;
    var idbonus = "#bonus"+id;
    var idtr = "#t_salary"+id;
    
    var total_days = $('#total_days'+id).val();
    var total_hours_days = $('#total_hours'+id).val()/180;
    var total_salary_ll = $("#sal"+id).val();
    var g_date = $("#salar_g_date").val().split('-');
    var onedaysalary = total_salary_ll/parseInt(daysInMonth(g_date[1],g_date[0]));
    var remaing_salary = onedaysalary*(parseInt(total_days)+parseInt(total_hours_days));

    var total_salary = 0;
    var salary = $(idsalary).val();
    var bonus = $(idbonus).val();
    total_salary += parseInt(salary);
    total_salary += parseInt(bonus);
    total_salary -= parseInt(remaing_salary);
    $(idtr).val(total_salary);
}

function payment_cash_fun() {
    var cash = $("#payment_cash").val();
    $.ajax({
        type:"POST",
        url:"models/payroll.php",
        data:"payment_cash="+cash,
        success:function(data) {
            if(data == 'false'){
                $("#warnmsg1").html("<div class='alert alert-danger' style='text-align:center'><strong>Sorry! You dont have enough cash to pay!!</strong></div>");
                $("#submit_payment").attr('disabled',true);
            }else{
                $("#warnmsg1").empty();
                $("#submit_payment").attr('disabled',false);
            }
        }
    });
}
</script>

