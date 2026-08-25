<?php 
if (isset($_GET['profile'])) {
    $profile = $_GET['profile'];
    $db->Select("*");
    $db->From("wt_users");
    $db->Where("id = '".$profile."'");
    $user_update = $db->result(); 
    $row = mysqli_fetch_array($user_update);
    ?>
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">
                <?php if(!empty($row['profile_pic'])){ ;?>
                    <img src="../images/<?php echo $row['profile_pic'];?>" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">
                <?php } ?>
                <h4 class="mb-0"><?php echo ucwords($row['fname'])." ".ucwords($row['lname']) ?></h4>
                <div class="text-left mt-3">
                    <h4 class="font-13 text-uppercase">About Me :</h4>
                    <p class="text-muted font-13 mb-3">
                        <?php echo $row['aboutme'] ?>
                    </p>
                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo ucwords($row['fname'])." ".ucwords($row['lname']) ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2"><?php echo $row['phone'] ;?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 "><?php echo $row['email'] ;?></span></p>
                    <p class="text-muted mb-1 font-13"><strong>Address :</strong> <span class="ml-2"><?php echo $row['address'] ;?></span></p>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col-->
        <div class="col-lg-8 col-xl-8">
            <div class="card-box">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item" >
                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link active" style="background: black !important;">
                            Settings
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="settings">
                        <form action="" method="post" enctype="multipart/form-data">
                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                            <div class="row"><div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname">First Name </label>
                                            <input type="text" value="<?php echo $row['fname'] ;?>"  class="form-control" id="firstname"  name="fname" required placeholder="Enter first name">
                                            <input type="hidden" value="<?php echo $row['id'] ;?>" name="id_update" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" value="<?php echo $row['lname'] ;?>"  class="form-control" id="lastname" name="lname" placeholder="Enter last name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="useremail">Email Address</label>
                                            <input type="email" value="<?php echo $row['email'] ;?>"  name="email" class="form-control" id="useremail" required placeholder="Enter email">

                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="lastname">Profile Picture</label>
                                <input type="file" name="profile_pic" data-plugins="dropify"  data-default-file="../images/<?php echo $row['profile_pic'];?>"
                                />
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userbio">About me</label>
                                    <textarea class="form-control" id="userbio" rows="4"  name="aboutme" placeholder="Write something..."><?php echo $row['aboutme'] ;?></textarea>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="useremail">Phone</label>
                                    <input type="number" value="<?php echo $row['phone'] ;?>"  name="phone" class="form-control" id="useremail" placeholder="Enter phone" >

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="useremail">Salary</label>
                                    <input type="number" value="<?php echo $row['salary'] ;?>"  name="salary_u" class="form-control" id="" required>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="userbio">Address</label>
                                    <textarea class="form-control" id="userbio" rows="4" name="address" placeholder="Write something..."><?php echo $row['address'] ;?></textarea>
                                </div>
                            </div>
                            <!-- end col -->
                        </div> <!-- end row -->
                        <div class="text-right">
                            <button type="submit" name="pupdate" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- end settings content-->
            </div> <!-- end tab-content -->
        </div> <!-- end card-box-->
    </div> <!-- end col -->
</div>
<!-- end row-->
</div> <!-- container -->
</div> <!-- content -->
</div>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->
<?php 
        }
    ?>