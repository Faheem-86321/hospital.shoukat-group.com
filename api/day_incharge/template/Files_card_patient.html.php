
<button id="updateinfobutton" hidden class="btn " data-toggle="modal" data-target="#updateinfo" style="background: #21325E; color: white;" ><i class="mdi mdi-plus-circle mr-2"></i> Update File </button>
<div class="modal fade" id="updateinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="myCenterModalLabel"> Update File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 modalbody1">
            </div>    
        </div>
    </div>
</div>                    
<!-- Modal -->
<div class="modal fade" id="add-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Health Card Operation File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4 text-center">
                <style>
                    #myInput {
                      background-image: url('/css/searchicon.png');
                      background-position: 10px 10px;
                      background-repeat: no-repeat;
                      width: 100%;
                      font-size: 16px;
                      padding: 12px 20px 12px 40px;
                      border: 1px solid #ddd;
                      margin-bottom: 12px;
                  }

                  #myTable {
                      border-collapse: collapse;
                      width: 100%;
                      border: 1px solid #ddd;
                      font-size: 18px;
                  }

                  #myTable th, #myTable td {
                      text-align: left;
                      padding: 12px;
                  }

                  #myTable tr {
                      border-bottom: 1px solid #ddd;
                  }

                  #myTable tr.header, #myTable tr:hover {
                      background-color: #f1f1f1;
                  }
              </style>
              <form action="" method="post" enctype="multipart/form-data">
                  <div class="col-md-12 card-table-style" >
                    <input type="text" id="myInput" onkeyup="myFunction123()" placeholder="Search for Visitor-ID.." title="Type in a name">

                    <button type="submit" name="psubmit" id="errorbutton" class="btn btn-success waves-effect waves-light ">Click to send checked Files</button>

                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Visitor ID/Name</th>
                                <th>Case</th>
                                <th>Total Payment</th>
                                <th>Admit/Discharge</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sr = 0;
                            $sr_no = 1;
                            $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON  ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID Where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_status = '0' ";
                            $fetch_data_ex = mysqli_query($con,$fetch_data);
                            foreach($fetch_data_ex as $row){ ?>
                                <tr style="height:2px !important" >
                                    <td> <?php echo $sr_no ?></td>
                                    <td>
                                        <input type="hidden" value="<?php echo $row['pi_id'] ?>" name="sent_id[]">
                                        <input type="text" class="form-control" name=""  hidden value="<?php echo $row['visitor_id'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'>
                                        <?php echo $row['visitor_id'] ?> <br>
                                        <input type="text" class="form-control" name=""  hidden value="<?php echo $row['Name'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'>
                                        <?php echo $row['Name'] ?>
                                    </td> 
                                    <td style="width: auto !important;">

                                        <input type="text" class="form-control" name=""  value="<?php echo $row['Title'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name=""  value="<?php echo $row['Paid'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'> 
                                    </td>
                                    <td><?php echo $row['admit_date'] ?> <b><br>to<br></b> <?php echo $row['exit_date'] ?></td>
                                    <td>
                                        <input type="checkbox" class="form-control" id="checkop<?php echo $sr ?>" name="checkedvalue<?php echo $sr ?>" value='0'  onclick='checkop(<?php echo $sr ?>);'   required readonly style='font-size: 3px;'> 
                                    </td>
                                </tr>
                                <?php
                                $sr++;
                                $sr_no++;
                            } ?>
                        </tbody>
                    </table>
                    <script type="text/javascript">
                        function checkop(id) {
                            var chkk_id = '#checkop'+id;
                            var uncheck = $(chkk_id).val();
                            if (uncheck == 1){
                                $(chkk_id).val(0);
                            }
                            else{
                                $(chkk_id).val(1);
                            }
                                //alert(id);
                        }
                    </script>
                    <script>
                        function myFunction123() {
                          var input, filter, table, tr, td, i, txtValue;
                          input = document.getElementById("myInput");
                          filter = input.value.toUpperCase();
                          table = document.getElementById("myTable");
                          tr = table.getElementsByTagName("tr");
                          for (i = 0; i < tr.length; i++) {
                            td = tr[i].getElementsByTagName("td")[1];
                            if (td) {
                              txtValue = td.textContent || td.innerText;
                              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }       
                    }
                }
            </script>

        </div>
    </form>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="add-custom-modal_d" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Add Dialysis File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <style>
                #myInput_d {
                  background-image: url('/css/searchicon.png');
                  background-position: 10px 10px;
                  background-repeat: no-repeat;
                  width: 100%;
                  font-size: 16px;
                  padding: 12px 20px 12px 40px;
                  border: 1px solid #ddd;
                  margin-bottom: 12px;
              }

              #myTable_d {
                  border-collapse: collapse;
                  width: 100%;
                  border: 1px solid #ddd;
                  font-size: 15px;
              }

              #myTable_d th, #myTable_d td {
                  text-align: left;
                  padding: 4px;
              }

              #myTable_d tr {
                  border-bottom: 1px solid #ddd;
              }

              #myTable_d tr.header, #myTable_d tr:hover {
                  background-color: #f1f1f1;
              }
          </style>
          <div class="modal-body p-4 text-center">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="col-sm-12 card-table-style">
                    <input type="text" id="myInput_d" onkeyup="myFunction123_p()" placeholder="Search for Visitor-ID.." title="Type in a name">

                    <button type="submit" name="psubmit_d" id="errorbutton" class="btn btn-success waves-effect waves-light ">Click to send checked Files</button>
                    <table id="myTable_d" style="font-size: 18px;" >
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Visitor ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Total Payment</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sr = 0;
                            $sr_no = 1;
                            $fetch_data = "SELECT *,ssh_p_dialysis.date As date FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID where  ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_status = '0' ";
                            $fetch_data_ex = mysqli_query($con,$fetch_data);
                            foreach($fetch_data_ex as $row){ ?>
                                <tr style="height:2px !important" >
                                    <td><?php echo $sr_no ?></td>
                                    <td>
                                        <input type="hidden" value="<?php echo $row['pd_id'] ?>" name="sent_id[]">
                                        <input type="text" class="form-control" name=""  hidden value="<?php echo $row['visitor_id'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'>
                                        <?php echo $row['visitor_id'] ?>
                                    </td>    
                                    <td>
                                        <input type="text" class="form-control" name=""  value="<?php echo $row['Name'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name=""  value="<?php echo $row['phone'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name=""  value="<?php echo $row['date'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name=""  value="<?php echo $row['Paid'] ?>" required readonly style='border: none !important;width: auto !important; background: transparent;'> 
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-control" id="checkop_d<?php echo $sr ?>" name="checkedvalue<?php echo $sr ?>" value='0'  onclick='checkop_d(<?php echo $sr ?>);'   required readonly style='font-size: 3px;'> 
                                    </td>
                                </tr>
                                <?php
                                $sr++;
                                $sr_no++;
                            } ?>
                        </tbody>
                    </table>
                    <script type="text/javascript">
                        function checkop_d(id) {
                            var chkk_id = '#checkop_d'+id;
                            var uncheck = $(chkk_id).val();
                            if (uncheck == 1){
                                $(chkk_id).val(0);
                            }
                            else{
                                $(chkk_id).val(1);
                            }
                                //alert(uncheck);
                        }
                    </script>
                    <script>
                        function myFunction123_p() {
                          var input, filter, table, tr, td, i, txtValue;
                          input = document.getElementById("myInput_d");
                          filter = input.value.toUpperCase();
                          table = document.getElementById("myTable_d");
                          tr = table.getElementsByTagName("tr");
                          for (i = 0; i < tr.length; i++) {
                            td = tr[i].getElementsByTagName("td")[1];
                            if (td) {
                              txtValue = td.textContent || td.innerText;
                              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }       
                    }
                }
            </script>   
        </div>
    </form>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="col-xl-12  col-lg-12">
    <div class="card">
        <style type="text/css">
            .counter{
                color: #fff;
                background: #729C20;
                font-family: 'Poppins', sans-serif;
                text-align: center;
                width: 200px;
                height: 200px;
                padding: 38px 30px;
                margin: 0 auto;
                position: relative;
                z-index: 1;
                clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
            }
            .counter:before{
                content: "";
                background: #8EBF2F;
                border-radius: 50%;
                box-shadow: -10px 10px 8px rgba(0, 0, 0, 0.3);
                position: absolute;
                top: 15px;
                left: 15px;
                right: 15px;
                bottom: 15px;
                z-index: -1;
            }
            .counter .counter-icon{
                font-size: 35px;
                line-height: 35px;
                margin: 0 0 12px;
            }
            .counter .counter-value{
                font-size: 30px;
                font-weight: 500;
                display: block;
            }
            .counter h1{
                font-size: 20px;
                font-weight: 500;
                letter-spacing: 0.5px;
                line-height: 21px;
                color: white !important;
                text-transform: capitalize;
                margin: 0 0 3px;
            }
            .counter.blue{ background: #132C55; }
            .counter.blue:before{ background: #193C72; }
             .counter.red{ background: red; }
            .counter.red:before{ background: #FFCCCB; }
             .counter.grey{ background: grey; }
            .counter.grey:before{ background: lightgrey; }
            @media screen and (max-width:990px){
                .counter{ margin-bottom: 40px; }
            }
        </style>
            <div class="card-body" dir="ltr">

       
            <button id="onloadclick" class="btn" data-toggle="modal" data-target="#add-custom-modal" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Health Card Operation File</button>

            <button id="onloadclick" class="btn ml-1" data-toggle="modal" data-target="#add-custom-modal_d" style="background: #f24c4f; color: black;float: left;" ><i class="mdi mdi-plus-circle "></i> Add Dialysis File</button>
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div style="float: left;"> <p>&nbsp&nbsp</p> </div>
            <br><br>
             <div class="row m-3">
                <div class="col-md-3 col-sm-6">
                    <div class="counter grey">
                        <div class="counter-icon">
                           
                        </div>
                        <h1>Not Lodged</h1>
                        <span class="counter-value">
                            <?php
                                $fetch_data = "SELECT * FROM ssh_p_indoor where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_status = '0'   ";
                                $fetch_data_ex = mysqli_query($con,$fetch_data);
                                $fetch_data2 = "SELECT * FROM ssh_p_dialysis where ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_status = '0'   ";
                                $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                                echo mysqli_num_rows($fetch_data_ex)+mysqli_num_rows($fetch_data2_ex);
                            ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="counter blue">
                        <div class="counter-icon">
                            
                        </div>
                        <h1>Lodged</h1>
                        <span class="counter-value">
                            <?php
                                $fetch_data = "SELECT * FROM ssh_p_indoor where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_status = '1' AND DATE(ssh_p_indoor.file_date) >= DATE(NOW()) - INTERVAL 30 DAY  ";
                                $fetch_data_ex = mysqli_query($con,$fetch_data);
                                $fetch_data2 = "SELECT * FROM ssh_p_dialysis where ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_status = '1' AND DATE(ssh_p_dialysis.file_date) >= DATE(NOW()) - INTERVAL 30 DAY    ";
                                $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                                echo mysqli_num_rows($fetch_data_ex)+mysqli_num_rows($fetch_data2_ex);
                            ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="counter red">
                        <div class="counter-icon">
                           
                        </div>
                        <h1>Late</h1>
                        <span class="counter-value">
                            <?php
                                $fetch_data = "SELECT * FROM ssh_p_indoor where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_status = '1' AND DATE(ssh_p_indoor.file_date) <= DATE(NOW()) - INTERVAL 30 DAY  ";
                                $fetch_data_ex = mysqli_query($con,$fetch_data);
                                $fetch_data2 = "SELECT * FROM ssh_p_dialysis where ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_status = '1' AND DATE(ssh_p_dialysis.file_date) <= DATE(NOW()) - INTERVAL 30 DAY    ";
                                $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                                echo mysqli_num_rows($fetch_data_ex)+mysqli_num_rows($fetch_data2_ex);
                            ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="counter green">
                        <div class="counter-icon">
                            
                        </div>
                        <h1>Proceed </h1>
                        <span class="counter-value">
                            <?php
                                $fetch_data = "SELECT * FROM ssh_p_indoor where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_status = '2'  ";
                                $fetch_data_ex = mysqli_query($con,$fetch_data);
                                $fetch_data2 = "SELECT * FROM ssh_p_dialysis where ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_status = '2'    ";
                                $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                                echo mysqli_num_rows($fetch_data_ex)+mysqli_num_rows($fetch_data2_ex);
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-center col-md-12">  
                <div class="row">
                    <br><br>
                    <form action="" method="get" enctype="multipart/form-data">

                      <input type="date" class="form-control "  name="search_date_list_from"  style="width: 150px;float: left;" required>
                      <input type="date" class="form-control ml-1"  name="search_date_list_to"  style="width: 150px;float: left;" required>

                      <select class="form-control ml-1 mr-1" name="status" required  style="border: 1px solid red;width: 200px;float: left">
                        <option disabled selected value="">--- Search by Status ---</option>
                        <option value="1">Proceed</option><option value='2'>Late</option><option value='3'>Lodged</option>

                    <input type="submit" class="btn btn-success  "  name="search_date" value="Search"  style="float: left;height: 36px;">

                </form>
            </div>
        </div> 

        <div id="cardCollpase4" class="collapse show"  >
            <div class="row bodyoftable" style="padding: 0px 4px !important;">
                <div class="col-sm-12" style="padding: 0px 4px !important;">
                    <div class="card-box card-table-style" style="padding: 0px 4px !important;">
                        <?php 
                        date_default_timezone_set("Asia/Karachi");
                        if (isset($_GET['search_date'])) { ?>
                            <style>
                                #myInput_view {
                                  background-image: url('/css/searchicon.png');
                                  background-position: 10px 10px;
                                  background-repeat: no-repeat;
                                  width: 100%;
                                  padding: 12px 20px 12px 40px;
                                  border: 1px solid #ddd;
                                  margin-bottom: 12px;
                              }

                              #myTable_view {
                                  border-collapse: collapse;
                                  width: 100%;
                                  border: 1px solid #ddd;
                              }

                              #myTable_view th, #myTable_view td {
                                  text-align: left;
                                  padding: 12px;
                              }

                              #myTable_view tr {
                                  border-bottom: 1px solid #ddd;
                              }

                              #myTable_view tr.header, #myTable_view tr:hover {
                                  background-color: #f1f1f1;
                              }
                          </style>
                          <input type="text" id="myInput_view" onkeyup="myFunction123_view()" placeholder="Search for Visitor-ID.." title="Type in a name">
                          <table id="myTable_view"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" > <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Visitor ID</th>
                                <th  class="noExport">Option</th>
                                <th>Name</th>
                                <th>Case</th>
                                <th>Phone</th>
                                <th>Total Payment</th>
                                <th>Admit/Discharge</th>
                                <th>Send Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_ex = 0;
                            $sr_no = 1;
                            $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON  ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_date BETWEEN '".$_GET['search_date_list_from']."' AND '".$_GET['search_date_list_to']."'  ORDER BY ssh_p_indoor.file_date DESC  ";
                            $fetch_data_ex = mysqli_query($con,$fetch_data);
                            foreach($fetch_data_ex as $row){ 
                                $date1 = $row['file_date'];
                                $date2 = date('Y-m-d');
                                $days_new = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24)."<br>";

                                if ($row['file_status'] == 1 && intval($days_new) <=  30  && $_GET['status'] == 3) { ?>
                                    <tr style="background: yellow !important;">
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['visitor_id']."</td>";?>
                                        <td>
                                            <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA,<?php echo $row['pi_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                                        </td>
                                        <?php echo "<td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$row['file_date']."</td>"; ?>
                                    </tr>
                                <?php }elseif($row['file_status'] == 2 && $_GET['status'] == 1){ ?>
                                    <tr style="background: green !important;">
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['visitor_id']."</td>";?>
                                        <td>
                                            RECEIVED
                                        </td>
                                        <?php echo "<td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$row['file_date']."</td>"; ?>
                                    </tr>
                                    <?php
                                }
                                elseif($row['file_status'] == '1' && intval($days_new) > 30 && $_GET['status'] == 2){ ?>
                                    <tr style="background: red !important;">
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['visitor_id']."</td>";?>
                                        <td>
                                            <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA,<?php echo $row['pi_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                                        </td>
                                        <?php echo "<td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$row['file_date']."</td>"; ?>
                                    </tr>
                                    <?php
                                }
                                else{}
                                ?>


                                <?php 
                            }
                            ?>

                            <tr style="background: lightgrey ;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="background: lightgrey ;"><b>Dialysis Files</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                            $total_ex = 0;
                            $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID where ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_date BETWEEN '".$_GET['search_date_list_from']."' AND '".$_GET['search_date_list_to']."'  ORDER BY ssh_p_dialysis.file_date DESC ";
                            $fetch_data_ex = mysqli_query($con,$fetch_data);
                            foreach($fetch_data_ex as $row){ 
                                $date1 = $row['file_date'];
                                $date2 = date('Y-m-d');
                                $days = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24)."<br>";

                                if ($row['file_status'] == 1 && intval($days) <= 30 && $_GET['status'] == 3) { ?>
                                    <tr style="background: yellow !important;">
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['visitor_id']."</td>";?>
                                        <td>
                                            <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA_d,<?php echo $row['pd_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                                        </td>
                                        <?php echo "<td>".$row['Name']."</td><td></td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['date']."</td><td>".$row['file_date']."</td>"; ?>
                                    </tr>
                                <?php }elseif($row['file_status'] == 2 && $_GET['status'] == 1){ ?>
                                    <tr style="background: green !important;">
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['visitor_id']."</td>";?>
                                        <td>
                                            RECEIVED
                                        </td>
                                        <?php echo "<td>".$row['Name']."</td><td></td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['date']."</td><td>".$row['file_date']."</td>"; ?>
                                    </tr>
                                    <?php
                                }
                                elseif($row['file_status'] == 1 && intval($days) > 30 && $_GET['status'] == 2){ ?>
                                    <tr style="background: red !important;">
                                        <td><?php echo $sr_no; ?></td>
                                        <?php $sr_no++; ?>
                                        <?php echo "<td>".$row['visitor_id']."</td>";?>
                                        <td>
                                            <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA_d,<?php echo $row['pd_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                                        </td>
                                        <?php echo "<td>".$row['Name']."</td><td></td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['date']."</td><td>".$row['file_date']."</td>"; ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    <script>
                        function myFunction123_view() {
                          var input, filter, table, tr, td, i, txtValue;
                          input = document.getElementById("myInput_view");
                          filter = input.value.toUpperCase();
                          table = document.getElementById("myTable_view");
                          tr = table.getElementsByTagName("tr");
                          for (i = 0; i < tr.length; i++) {
                            td = tr[i].getElementsByTagName("td")[1];
                            if (td) {
                              txtValue = td.textContent || td.innerText;
                              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }       
                    }
                }
            </script>
        <?php  }else{ ?>
            <style>
                #myInput_view {
                  background-image: url('/css/searchicon.png');
                  background-position: 10px 10px;
                  background-repeat: no-repeat;
                  width: 100%;
                  padding: 12px 20px 12px 40px;
                  border: 1px solid #ddd;
                  margin-bottom: 12px;
              }

              #myTable_view {
                  border-collapse: collapse;
                  width: 100%;
                  border: 1px solid #ddd;
              }

              #myTable_view th, #myTable_view td {
                  text-align: left;
                  padding: 12px;
              }

              #myTable_view tr {
                  border-bottom: 1px solid #ddd;
              }

              #myTable_view tr.header, #myTable_view tr:hover {
                  background-color: #f1f1f1;
              }
          </style>
          <input type="text" id="myInput_view" onkeyup="myFunction123_view()" placeholder="Search for Visitor-ID.." title="Type in a name">
          <table id="myTable_view"  class="table table-centered table-striped table-bordered mb-0 toggle-circle" >
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Visitor ID</th>
                    <th  class="noExport">Option</th>
                    <th>Name</th>
                    <th>Case</th>
                    <th>Phone</th>
                    <th>Total Payment</th>
                    <th>Admit/Discharge</th>
                    <th>Send Date</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $total_ex = 0;
                $sr_no = 1;
                $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON  ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND MONTH(CONVERT(ssh_p_indoor.file_date,Date)) = MONTH(CURRENT_DATE())  ORDER BY ssh_p_indoor.file_date DESC ";
                $fetch_data_ex = mysqli_query($con,$fetch_data);
                foreach($fetch_data_ex as $row){ 
                    $days_new = 0;
                    date_default_timezone_set("Asia/Karachi");
                    $date1 = $row['file_date'];
                    $date2 = date('Y-m-d');
                    $days_new = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24)."<br>";

                    if ($row['file_status'] == 1 && intval($days_new) <= 30) { ?>
                        <tr style="background: yellow !important;">
                            <td><?php echo $sr_no; ?></td>
                            <?php $sr_no++; ?>
                            <?php echo "<td>".$row['visitor_id']."</td>";?>
                            <td>
                                <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA,<?php echo $row['pi_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                            </td>
                            <?php echo "<td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$row['file_date']."</td>"; ?>
                        </tr>
                    <?php }elseif($row['file_status'] == 1 && intval($days_new) > 30){ ?>
                        <tr style="background: red !important;">
                            <td><?php echo $sr_no ; ?></td>
                            <?php $sr_no++; ?>
                            <?php echo "<td>".$row['visitor_id']."</td>";?>
                            <td>
                                <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA,<?php echo $row['pi_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                            </td>
                            <?php echo "<td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$row['file_date']."</td>"; ?>
                        </tr>
                        <?php
                    }elseif($row['file_status'] == 2){ ?>
                        <tr style="background: green !important;">
                            <td><?php echo $sr_no; ?></td>
                            <?php $sr_no++; ?>
                            <?php echo "<td>".$row['visitor_id']."</td>";?>
                            <td>
                                RECEIVED
                            </td>
                            <?php echo "<td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['admit_date']." <b><br>to<br></b> ".$row['exit_date']."</td><td>".$row['file_date']."</td>"; ?>
                        </tr>
                        <?php
                    }else{}
                    ?>

                    <?php 
                }
                ?>

                <tr style="background: lightgrey ;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="background: lightgrey ;"><b>Dialysis Files</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $total_ex = 0;
                $fetch_data = "SELECT * FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID = ssh_p_reg.P_ID where ssh_p_dialysis.admission_type = '1' AND MONTH(CONVERT(ssh_p_dialysis.file_date,Date)) = MONTH(CURRENT_DATE()) ORDER BY ssh_p_dialysis.file_date DESC ";
                $fetch_data_ex = mysqli_query($con,$fetch_data);
                foreach($fetch_data_ex as $row){ 
                    $date1 = $row['file_date'];
                    $date2 = date('Y-m-d');
                    $days = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24)."<br>";

                    if ($row['file_status'] == 1 && intval($days) <= 30) { ?>
                        <tr style="background: yellow !important;">
                            <td><?php echo $sr_no; ?></td>
                            <?php $sr_no++; ?>
                            <?php echo "<td>".$row['visitor_id']."</td>";?>
                            <td>
                                <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA_d,<?php echo $row['pd_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                            </td>
                            <?php echo "<td>".$row['Name']."</td><td></td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['date']."</td><td>".$row['file_date']."</td>"; ?>
                        </tr>
                    <?php }elseif($row['file_status'] == 2){ ?>
                        <tr style="background: green !important;">
                            <td><?php echo $sr_no; ?></td>
                            <?php $sr_no++; ?>
                            <?php echo "<td>".$row['visitor_id']."</td>";?>
                            <td>
                                RECEIVED
                            </td>
                            <?php echo "<td>".$row['Name']."</td><td></td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['date']."</td><td>".$row['file_date']."</td>"; ?>
                        </tr>
                        <?php
                    }
                    elseif($row['file_status'] == 1 && intval($days) > 30){ ?>
                        <tr style="background: red !important;">
                            <td><?php echo $sr_no; ?></td>
                            <?php $sr_no++; ?>
                            <?php echo "<td>".$row['visitor_id']."</td>";?>
                            <td>
                                <button class='btn btn-success text-white ' onclick="recieved_tpa(tpA_d,<?php echo $row['pd_id']; ?>);"  style='padding: 6px 6px;margin: 2px; border-radius: 3px; color: white; '><i class='fa fa-check ' aria-hidden='true'></i></button>

                            </td>
                            <?php echo "<td>".$row['Name']."</td><td></td><td>".$row['phone']."</td><td>".$row['Paid']."</td><td>".$row['date']."</td><td>".$row['file_date']."</td>"; ?>
                        </tr>
                        <?php
                    }
                    ?>

                    <?php 
                }
                ?>


            </tbody>
        </table>
        <script>
            function myFunction123_view() {
              var input, filter, table, tr, td, i, txtValue;
              input = document.getElementById("myInput_view");
              filter = input.value.toUpperCase();
              table = document.getElementById("myTable_view");
              tr = table.getElementsByTagName("tr");
              for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                  txtValue = td.textContent || td.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }
</script>
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
    function tpA(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'payment_receieved='+idcus,
            success:function(data) {
                reloadtablecontent_files_tabel();
            }
        });
    };
    function tpA_d(idcus) {
        var idcus = idcus;
        $.ajax({
            type:"POST",
            url:"models/indoor.php",
            data: 'payment_receieved_dialysis='+idcus,
            success:function(data) {
              reloadtablecontent_files_tabel();
          }
      });
    };
</script>   