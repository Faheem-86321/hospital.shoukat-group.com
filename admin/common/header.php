<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php  echo $head_title1 = ucwords(str_replace("_", " ", $head_title))." | ".$_SESSION['com_name'] ;?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="icon" href="<?php  echo "../images/".$_SESSION['com_logo'] ;?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- App css -->
    <link href="../assets/header/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="../assets/header/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <link href="../assets/header/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="../assets/header/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />
    <!-- Plugins css -->
    <link href="../assets/header/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/header/dropify.min.css" rel="stylesheet" type="text/css" />
    <!-- icons -->
    <link href="../assets/header/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/datatable/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../assets/datatable/jquery.dataTables.min.css" rel="stylesheet"/>
    <link href="../assets/header/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/header/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/header/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/header/custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets/header/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    
    <link href="../assets/header/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
</head>
<body class="loading">
    <!-- Begin page -->
    <div id="wrapper" style="height: 0px !important;">
        <!-- Topbar Start -->
        <div class="navbar-custom" style="background: #f24c4f;">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">
                    <li class="d-none d-lg-block">
                     <form action="outdoor" method="get" enctype="multipart/form-data" class="app-search">
                        <style type="text/css">
                            .app-search-box input::placeholder{
                                color: black !important;
                            }
                        </style>
                        <div class="app-search-box "style="width: 300px !important;">
                            <div class="input-group" style="width: 400px !important;" >
                                <input type="search" name="keyword" class="form-control" placeholder="Search By MRN or Patient Name..."  id="top-search" style="background: white !important; color: black !important;">
                                <div class="input-group-append" style="">
                                    <button class="btn" type="submit" name="searchbymrnorname" style="color: white;border: 2px solid white;">
                                        <i class="fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>   
                <li>
                    <button id="" class="btn mt-2" data-toggle="modal" data-target="#add-custom-modal-room-room" style="background: #f24c4f; color: black;float: left;font-size: 22px;" ><i class="fa fa-bed"> Bed Status</i> </button>

                </button>
            </li>
            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#" style="margin-top: 25px;color: black;">
                    <i class="fe-maximize noti-icon"></i>
                </a>
            </li>

        </li>
        <?php
        $fetch_data_noti = "SELECT * FROM ssh_dr_payment JOIN ssh_dr_reg ON ssh_dr_payment.D_ID = ssh_dr_reg.D_ID WHERE  ssh_dr_payment.notification = '0'" ;
        $fetch_data_noti_ex = mysqli_query($con,$fetch_data_noti);
        ?>          
        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="color: black;" >
                <i class="fe-bell noti-icon"></i>
                <span class="badge badge-dark" ><?php echo mysqli_num_rows($fetch_data_noti_ex); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">

                        </span>Notification
                    </h5><button style="float: right;" class="btn" onclick="removenoti();">Mark all as read</button>


                    <div class="dropdown-item text-center  notify-item notify-all" style="height: 300px;overflow-y: scroll;">
                        <?php 
                        foreach($fetch_data_noti_ex as $row){
                            ?>
                            <div>
                                <?php echo $row['Name']." has been paid <br>".$row['Payment']." on ".$row['Date'] ;?>
                            </div>



                        <?php }  ?>
                    </div>

                </div>
            </div>
        </li>
        <style type="text/css">
            @media screen and (max-width: 767px) {
                .nav-user-set{
                    margin-top: 25px;
                }
            }
        </style>
        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light nav-user-set" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="color: white;" >
                <img src="../images/<?php echo $_SESSION['profile_pic'] ;?>" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php echo $_SESSION['uname'] ;?> <i class="mdi mdi-chevron-down"></i> 
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>
                <!-- item-->
                <a href="profile" class="dropdown-item notify-item">
                    <i class="fa fa-user"></i>
                    <span>My Profile</span>
                </a>
                <a href="changepassword" class="dropdown-item notify-item">
                    <i class="fa fa-key"></i>
                    <span>Password</span>
                </a>
                <!-- item-->
                <div class="dropdown-divider"></div>
                <!-- item-->
                <a href="logout" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>
    <!-- LOGO -->
    <div class="logo-box" style="background: white;">
        <a href="dashboard" class="logo logo-dark text-center" >
            <span class="logo-sm">
             <strong style="color: white;font-size: 20px;"></strong>
         </span>
         <span class="logo-lg">
             <strong style="color: white;font-size: 20px;"></strong>
         </span>
     </a>
     <a href="dashboard" class="logo logo-light text-center" >
        <span class="logo-sm">
         <strong style="color: white;font-size: 20px;"></strong>
     </span>
     <span class="logo-lg">
         <img src="<?php  echo "../images/".$_SESSION['com_logo'] ;?>" alt="" height='50px' style='float: left;'>
         <h3 style="padding: 10px"><b><?php  echo $_SESSION['com_name'] ;?></b></h3> 

     </span>
 </a>
</div>
<ul class="list-unstyled topnav-menu topnav-menu-left m-0">
    <li>
        <button class="button-menu-mobile waves-effect waves-light" style="color: black;">
            <i class="fe-menu"></i>
        </button>
    </li>
    

    <script type="text/javascript">
                // Date Time For Header
        function date_time(id)
        {
            date = new Date;
            year = date.getFullYear();
            month = date.getMonth();
            months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
            d = date.getDate();
            day = date.getDay();
            days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            h = date.getHours();
            if(h<10)
            {
                h = "0"+h;
            }
            m = date.getMinutes();
            if(m<10)
            {
                m = "0"+m;
            }
            s = date.getSeconds();
            if(s<10)
            {
                s = "0"+s;
            }
            result = '<span style="font-size: 18px;">'+days[day]+'</span>  <b style="font-size: 22px;">'+h+':'+m+'</b>:'+s+' <b style="font-size: 22px">'+d+' </b><b>'+months[month]+'</b>';
            document.getElementById(id).innerHTML = result;
            setTimeout('date_time("'+id+'");','1000');
            return true;
        }
    </script>
   <!-- Place this before the closing </ul> of topnav-menu-left -->
<style>
    /* Blinking fade animation */
    .fas12 {
        animation: fas12 1.5s linear infinite !important;
    }
    @keyframes fas12 {
        0% { opacity: 0; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    /* Styling for date-time */
    .date_time_div {
        color: black !important;
        padding: 30px 30px;
        font-size: 12px;
        font-weight: 500;
    }
</style>

<li style="text-align: center; width:15%; bold">
    <div class="date_time_div">
        <span id="date_time"></span>
    </div>
</li>

<script>
function date_time(id) {
    const date = new Date();
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    let day = days[date.getDay()];
    let d = date.getDate();
    let month = months[date.getMonth()];
    let year = date.getFullYear();

    let h = date.getHours();
    let m = date.getMinutes();
    let s = date.getSeconds();

    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;
    if (m < 10) m = '0' + m;
    

    const result = `<b>${day}</b> ${h}:${m}:${s} ${ampm} · ${d} ${month} ${year}`;
    document.getElementById(id).innerHTML = result;

    setTimeout(() => date_time(id), 1000);
}

window.onload = function() {
    date_time('date_time');
};
</script>

        <!-- Mobile menu toggle (Horizontal Layout)-->
        <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
        <!-- End mobile menu toggle-->
    </li>
</ul>
<div class="clearfix"></div>
</div>
</div>
<!-- end Topbar -->
<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu" style="background:black;">
    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu" >
                <li class="menu-title text-white" >Dashboard</li>
                <li>
                    <a href="dashboard" class="text-white">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="menu-title mt-2 text-white">Outdoor</li>
                <li>
                    <a href="#sidebaruser1" data-toggle="collapse" class="text-white">
                        <i class="fa fa-stethoscope"></i>
                        <span> Outdoor </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser1" class="text-white">
                        <ul class="nav-second-level">
                            <li>
                                <a href="outdoor_dashboard" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Dashboard</a>
                            </li>
                            <li>
                                <a href="outdoor" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Outdoor Slip</a>
                            </li>
                            
                            
                            <li>
                                <a href="other_services_slip" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Services Slip</a>
                            </li>
                            <li>
                                <a href="service_ledger" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Services Ledger</a>
                            </li>

                            <li>
                                <a href="other_services_types" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Services Types</a>
                            </li>
                            
                            <li>
                                <a href="expense" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Expense</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-title mt-2 text-white">Health Card Indoor</li>
                <li>
                    <a href="#sidebaruser2_health" data-toggle="collapse" class="text-white">
                        <i class="fa fa-wheelchair"></i>
                        <span> Health Card Indoor </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser2_health" class="text-white">
                        <ul class="nav-second-level">

                            <li>
                                <a href="health_card_indoor_dashboard" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Dashboard</a>
                            </li>
                            <li>
                                <a href="health_card_patient" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Health Card Patient</a>
                            </li>

                            <li>
                                <a href="health_card_dialysis" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Health Card Dialysis</a>
                            </li>
                            
                            <li>
                                <a href="cases_list_health_card" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Cases List</a>
                            </li>
                            <li>
                                <a href="doctor_fee_health_card" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>
                                Doctor Fee</a>
                            </li>
                        </ul>
                    </div>
                </li> 
                <li class="menu-title mt-2 text-white">Private Indoor</li>
                <li>
                    <a href="#sidebaruser2" data-toggle="collapse" class="text-white">
                        <i class="fa fa-wheelchair"></i>
                        <span> Private Indoor </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser2" class="text-white">
                        <ul class="nav-second-level">

                            <li>
                                <a href="private_indoor_dashboard" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Dashboard</a>
                            </li>
                            <li>
                                <a href="private_patient" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Private Patient</a>
                            </li>

                            <li>
                                <a href="private_dialysis" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Private Dialysis</a>
                            </li>
                            
                            <li>
                                <a href="cases_list" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Cases List</a>
                            </li>
                            <li>
                                <a href="doctor_fee" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Doctor Fee</a>
                            </li>
                        </ul>
                    </div>
                </li>  
                <!--  -->
                <li class="menu-title mt-2 text-white">Doctor Payment</li>
                <li>
                    <a href="#sidebaruser0" data-toggle="collapse" class="text-white">
                        <i class="fa fa-money-bill-alt"></i>
                        <span> Doctor Payment </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser0" class="text-white">
                        <ul class="nav-second-level">
                           
                            <li>
                                <a href="doctor_ledger_outdoor" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Outdoor Payment</a>
                            </li>
                            <li>
                                <a href="doctor_ledger_indoor_private" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Private Indoor </a>
                            </li>
                            <li>
                                <a href="doctor_ledger_indoor_health_card" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Health Card Indoor </a>
                            </li>
                        </ul>
                    </div>
                </li>

                 <li class="menu-title text-white" >General Income</li>
                <li>
                    <a href="general_income" class="text-white">
                        <i class="fa fa-money-bill-alt"></i>
                        <span> General Income </span>
                    </a>
                </li>
                <li class="menu-title mt-2 text-white">Reports</li>
                <li>
                    <a href="#sidebaruser-1" data-toggle="collapse" class="text-white">
                        <i class="fa fa-file"></i>
                        <span> Reports </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser-1" class="text-white">
                        <ul class="nav-second-level">
                           
                           <li>
                                <a href="report_outdoor" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>Outdoor Report</a>
                            </li>
                            <li>
                                <a href="doctor_report_indoor_private" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Private Indoor Report</a>
                            </li>
                           <li>
                                <a href="doctor_report_indoor_health_card" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>Health Card Report</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-title mt-2 text-white">Health Card Files</li>
                <li>
                    <a href="#sidebaruser2_health_files" data-toggle="collapse" class="text-white">
                        <i class="fa fa-file"></i>
                        <span> Health Card Files </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser2_health_files" class="text-white">
                        <ul class="nav-second-level">

                            <li>
                                <a href="files_card_dashboard" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Dashboard</a>
                            </li>
                            <li>
                                <a href="files_card_patient" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Patients Files</a>
                            </li>
                            <li>
                                <a href="files_card_recieved_payment" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Recieved payment</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                
                 
                
                
                
                 <li class="menu-title text-white" >Doctors</li>
                <li>
                    <a href="doctors" class="text-white">
                        <i class="fa fa-user-md"></i>
                        <span> Doctors </span>
                    </a>
                </li>
                 <li class="menu-title mt-2 text-white">Product Inventory</li>
                <li>
                    <a href="product_inventory" class="text-white"><i class="fa fa-archive mr-1"> </i> Product Inventory</a>
                </li>
                
                
                <li class="menu-title mt-2 text-white">Employees</li>
                <li>
                    <a href="#sidebaruser3" data-toggle="collapse" class="text-white">
                        <i class="fa fa-users"></i>
                        <span> Employees </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser3" class="text-white">
                        <ul class="nav-second-level">

                            <li>
                                <a href="users" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Employee</a>
                            </li>
                            <li>
                                <a href="https://attendance.shoukat-group.com/" class="text-white"  target="_blank"><i class="fa fa-arrow-right mr-1"> </i>  Attendance</a>
                            </li>
                            <!--<li>-->
                            <!--    <a href="payroll" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Payroll</a>-->
                            <!--</li>-->
                            
                        </ul>
                    </div>
                </li> 
                
                <li class="menu-title text-white" >Assets</li>
                <li>
                    <a href="assets" class="text-white">
                        <i class="fa fa-database"></i>
                        <span> Assets </span>
                    </a>
                </li>

                <li class="menu-title mt-2 text-white">Setting</li>
                <li>
                    <a href="#sidebaruser" data-toggle="collapse" class="text-white">
                        <i class="fa fa-cogs"></i>
                        <span> Setting </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser" class="text-white">
                        <ul class="nav-second-level">

                            <!-- <li>
                                <a href="rooms" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Rooms</a>
                            </li> -->
                            <li>
                                <a onclick="backup(backup_data);" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Database Backup</a>
                            </li>
                            <!-- <li>
                                <a href="companyprofile" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Company Profile </a>
                            </li> -->
                            <li>
                                <a href="profile" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  My Profile</a>
                            </li>
                            <li>
                                <a href="changepassword" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Password</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="logout" style="color: white !important;">
                        <i class="fe-log-out"></i>
                        <span> Log out </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
</div> 
<!-- Left Sidebar End -->
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid" >
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="alert" style="color: black; font-size: 20px; font-weight: bold; ">
                        <i class="fa fa-arrow-circle-left" onclick="history.back()"></i>&nbsp;
                        <i class="fa fa-arrow-circle-right" onclick="history.forward()"></i>&nbsp;
                        <?php  echo ucwords($_SESSION['user_type'])." / ".$head_title1 = ucwords(str_replace("_", " ", $head_title));?>
                        
                        <!-- <h3 style="float: right;border: 2px solid #f24c4f  !important;" class="alert p-1 text-black"><b>Cash In Hand: <span > -->
                            <?php 


               //   $fetch_data = "SELECT (SUM(ssh_p_dpr.Paid)+(SELECT SUM(ssh_p_services.Paid) FROM ssh_p_services))-((SELECT SUM(ssh_dr_payment.Payment) FROM ssh_dr_payment WHERE ssh_dr_payment.D_ID=0)+(SELECT SUM(payments.p_credit) FROM payments)) AS total FROM ssh_p_dpr LEFT JOIN ssh_dr_reg ON ssh_p_dpr.D_ID = ssh_dr_reg.D_ID";
               //  $fetch_data_ex = mysqli_query($con,$fetch_data);
               //  foreach($fetch_data_ex as $rowcash){
               //     echo "<a onclick='r_payment(".number_format((float)$rowcash['total'], 2, '.', '').");' class='fas12'>".number_format((float)$rowcash['total'], 2, '.', '')."</a>";  
               // }

                            ?>
                        </span></b></h3>

                    </div>
                </div>
            </div>  
            


            <script type="text/javascript">
                function removenoti(){
                    var idcus = "allread";
                    $.ajax({
                        type:"POST",
                        url:"getState.php",
                        data: 'markasread='+idcus,
                        success:function(data) {
                            location.reload();
                        }
                    });
                }
                
                
            </script>

            <div class="modal fade" id="add-custom-modal-room-room" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl ">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h4 class="modal-title" id="myCenterModalLabel"> View Rooms</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body p-4 modalbody901">

                            <?php 
                            $new_array_room = array();
                            $fetch_data12 = "Select * from ssh_p_indoor where exit_date = '0000-00-00' ";
                            $fetch_data12_ex = mysqli_query($con,$fetch_data12);
                            foreach($fetch_data12_ex as $row1){ 
                                array_push($new_array_room,$row1['room_id']);
                            }
                            $fetch_data_s = "SELECT * from indoor_room GROUP BY status Order BY status DESC";
                            $fetch_data_s_ex = mysqli_query($con,$fetch_data_s);
                            foreach($fetch_data_s_ex as $row1){ 
                                ?>
                                <div class="col-md-12 badge badge-dark m-1" style="float: left;height: 30px;padding: 5px;font-size: 18px"><?php echo ucwords($row1['status']); ?></div>
                                <?php
                                $fetch_data = "SELECT * from indoor_room where status = '".$row1['status']."' ";
                                $fetch_data_ex = mysqli_query($con,$fetch_data);
                                foreach($fetch_data_ex as $row){ 
                                    if (in_array($row['ir_id'], $new_array_room)) {
                                        echo "<div style='float:left;border:1px solid black;margin:7px;text-align:center;color:red;padding:10px'><h3 style='color:red;'><i class='fa fa-bed'> </i></h3>".$row['room_no']."</div>";
                                    }else{
                                        echo "<div style='float:left;border:1px solid black;margin:7px;text-align:center;color:green;padding:10px'><h3 style='color:green;'><i class='fa fa-bed'> </i></h3>".$row['room_no']."</div>";
                                    }   

                                }
                            }    
                            ?>

                        </div>    
                    </div>
                </div>
            </div>