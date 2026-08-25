<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
     <title><?php  echo $head_title1 = ucwords(str_replace("_", " ", $head_title))." | ".$_SESSION['com_name'] ;?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- App favicon -->
    <link rel="icon" href="<?php  echo "../images/".$_SESSION['com_logo'] ;?>">
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
    <!-- <li class="dropdown notification-list topbar-dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="color: black;" >
            <i class="fe-bell noti-icon"></i>
            <span class="badge badge-danger " ><?php echo  0 ;?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-lg">
            <div class="dropdown-item noti-title">
                <h5 class="m-0">
                    <span class="float-right">

                    </span>Notification
                </h5>
            </div>
        </div>
    </li> -->
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
        <!-- <a href="changepassword" class="dropdown-item notify-item">
            <i class="fa fa-key"></i>
            <span>Password</span>
        </a> -->
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
    <li style="text-align: center;width: 20%;">
        <div class="date_time_div" style="color: black !important;padding: 15px;">
            <span id="date_time"></span>
            <script type="text/javascript">window.onload = date_time('date_time');</script>
        </div>
    </li>

    <li>
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
                <!-- <li class="menu-title text-white" >Dashboard</li>
                <li>
                    <a href="dashboard" class="text-white">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                  -->
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
                                <a href="outdoor_dailybook" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Outdoor Dailybook</a>
                            </li>
                            <li>
                                <a href="outdoor" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Outdoor Slip</a>
                            </li>
                            <li>
                                <a href="doctor_ledger_outdoor" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Doctor Payment</a>
                            </li>
                            <li>
                                <a href="other_services_slip" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Services Slip</a>
                            </li>
                               <li>
                                <a href="expense" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Expense</a>
                            </li>
                            <!-- <li>
                                <a href="report_outdoor" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Report</a>
                            </li> -->
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
                                <a href="private_patient" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Private Patient</a>
                            </li>

                            <li>
                                <a href="private_dialysis" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Private Dialysis</a>
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
                                <a href="health_card_patient" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Health Card Patient</a>
                            </li>

                            <li>
                                <a href="health_card_dialysis" class="text-white"><i class="fa fa-arrow-right mr-1"> </i> Health Card Dialysis</a>
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
             
                <!-- <li class="menu-title text-white" >Indoor</li>
                <li>
                    <a href="indoor" class="text-white">
                        <i class="fa fa-user-plus"></i>
                        <span> Indoor </span>
                    </a>
                </li> -->

                <!-- <li class="menu-title text-white" >Services</li>
                <li>
                    <a href="services" class="text-white">
                        <i class="fa fa-wrench"></i>
                        <span> Services </span>
                    </a>
                </li> -->
                
                <li class="menu-title mt-2 text-white">Setting</li>
                <li>
                    <a href="#sidebaruser" data-toggle="collapse" class="text-white">
                        <i class="fa fa-cogs"></i>
                        <span> Setting </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebaruser" class="text-white">
                        <ul class="nav-second-level">

                            <li>
                                <a href="profile" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  My Profile</a>
                            </li>
                            <!-- <li>
                                <a href="changepassword" class="text-white"><i class="fa fa-arrow-right mr-1"> </i>  Password</a>
                            </li> -->
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
                    </div>
                </div>
            </div>  
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