
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



            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <div style="float: left;"> <p>&nbsp&nbsp</p> </div>
            
            <div class="row m-3">
                <div class="col-md-3 col-sm-6">
                    <div class="counter grey">
                        <div class="counter-icon">

                        </div>
                        <h1>Not Lodged</h1>
                        
                        <p>Current</p>
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

                        <p>Current</p>
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
                        <p>Current</p>
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
                        <p>Overall</p>
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
            <div class="col-md-12 mt-2" >
                <div class="card-box " style="border-right: 3px solid #f24c4f ;box-shadow: 0 3px 10px rgb(0 0 0 / 0.2)">
                    <div class="float-right d-none d-md-inline-block" style="color: black !important;">
                     <div class="btn-group " style="background: #f24c4f;color: black !important;">
                      <button type="button" class="btn btn-xs btn-primary  m-1" >Monthly</button>
                  </div>
              </div>

              <h4 class="header-title mb-3 p-2" style="background: #f24c4f;color: black !important;"><i class="fa fa-file"></i> Submitted Status</h4>

              <div dir="ltr">
                <div id="file_status_overall" class="mt-4" data-colors="#6658dd,green"></div>
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col-->

</div> <!-- end card-box -->
</div> <!-- end col -->
</div>
<!-- end row -->
</div>    
</div>
</div> 
</div>       
<script type="text/javascript">

</script>   