<style type="text/css">
  :root {
    --darkgreen: black;
    --white: black;
  }
  .tabs-to-dropdown .nav-wrapper {
    padding-top: 20px;
  }
  .tabs-to-dropdown .nav-wrapper a {
    color: var(--darkgreen);

  }
  .tabs-to-dropdown .nav-pills .nav-link.active {
    background-color: #f24c4f;
    color: black;

  }
  .tabs-to-dropdown .nav-pills .nav-link{
    background-color: grey;
  }
  .tabs-to-dropdown .nav-pills li:not(:last-child) {
    margin-right: 3px;
  }
  .tabs-to-dropdown .tab-content .container-fluid {
   background: white;   
   max-width: 1250px;
   padding-top: 30px;
 }
 .tabs-to-dropdown .dropdown-menu {
  border: none;
  
}
.tabs-to-dropdown .dropdown-item {
  /*padding: 14px 28px;*/
}
.tabs-to-dropdown .dropdown-item:active {
  color: black !important;
}
@media (min-width: 1280px) {
  .tabs-to-dropdown .nav-wrapper {
    /*padding: 15px 30px;*/
    border-bottom: 3px solid black;
  }
}
@media (max-width: 768px) {
  .nav-item{
    /*padding: 15px 30px;*/
    margin-top: 12px !important;
  }
}
.file-upload {
  background-color: #ffff;
  width: 600px;
  margin: 0 auto;
  padding: 20px;
}
.file-upload-btn {
  width: 100%;
  margin: 0;
  color: black;
  background: #f24c4f;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #f24c4f;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}
.file-upload-btn:active {
  border: 0;
  transition: all .2s ease;
}
.file-upload-content {
  display: none;
  text-align: center;
  padding-bottom: 30px;
}
.file-upload-input {
  position: absolute;
  margin: 0;
  padding: 0;
  outline: none;
  opacity: 0;
  cursor: pointer;
}
.image-upload-wrap {
  padding-bottom: 30px;
  position: relative;
}
.image-dropping:hover {
  background-color: #f24c4f;
  border: 4px dashed black;
}
.image-title-wrap {
  color: #f24c4f;
}
.drag-text {
  text-align: center;
}
.drag-text h4 {
  font-weight: 100;
  text-transform: uppercase;
  color: #f24c4f;
  padding: 60px 0;
}
</style>
<div class="col-xl-12  col-lg-12">
  <div class="card">
    <div class="card-body" dir="ltr">
      <div class="row">
        <div class="tabs-to-dropdown col-md-12">
          <div class="nav-wrapper d-flex align-items-center justify-content-between" >
            <ul class="nav nav-pills  d-md-flex" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-product-tab" data-toggle="pill" href="#company" role="tab" aria-controls="pills-product" aria-selected="false"><i class="fa fa-building"></i> Company info</a>
              </li>
              </ul>
            </div>
            <div class="tab-pane fade show active" id="company" role="tabpanel" aria-labelledby="pills-product-tab" style="padding-top: 25px;">
            <div class="container-fluid">
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                  <?php foreach ($company_ex as $row){?>
                    <div class="col-md-12">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label >Company Name <span class="req-data">*</span></label>
                          <input value="<?php echo $row['com_name'] ;?>" type="text" class="form-control" name="companyname" data-required="true" required="required" >
                        </div>
                        <div class="form-group col-md-6">
                          <label >Company Phone <span class="req-data">*</span></label>
                          <input value="<?php echo $row['com_phone'] ;?>" type="number" class="form-control" name="companyphone" data-required="true" required="required" >
                        </div>
                        <div class="form-group col-md-6">
                          <label >Company Tel <span class="req-data">*</span></label>
                          <input value="<?php echo $row['com_tel'] ;?>" type="number" class="form-control" name="companytel" data-required="true" required="required" >
                        </div>

                        <div class="form-group col-md-12">
                          <label >Company Email <span class="req-data">*</span></label>
                          <input value="<?php echo $row['com_email'] ;?>" type="email" class="form-control" name="companyemail" data-required="true" required="required" >
                        </div>
                        <div class="form-group col-md-12">
                          <label >Company Address <span class="req-data">*</span></label>
                          <textarea class="form-control" name="companyaddress" data-required="true" required="required"><?php echo $row['com_address'] ;?></textarea>
                        </div>
                      </div>
                    </div>
                   
                    <div class="col-md-12" style="padding-top: 20px;">
                      <hr>
                      <input type="submit" name="updatecompany" class="btn btn-success form-group" style="float: right; margin-right:5%; border-radius: 10px; padding: 12px 30px;" value="Update">
                    </div>
                  </div>
                <?php } ?>          
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('.image-upload-wrap').hide();
        $('.file-upload-image').attr('src', e.target.result);
        $('.file-upload-content').show();
        $('.image-title').html(input.files[0].name);
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      removeUpload();
    }
  }
</script>