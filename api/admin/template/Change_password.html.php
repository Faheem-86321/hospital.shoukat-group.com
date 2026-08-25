<div class="col-xl-12  col-lg-12">
    <div class="card">
        <div class="card-body" dir="ltr">
            <?php if(!empty($message)){
                ?>
                <p style="color: red; text-align: center;"><?php echo $message; ?></p>
                <?php
            } ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label >Password</label>
                        <input type="password" class="form-control" required="required" name="password" data-required="true" id="password" onkeyup='check()'; autofocus>
                    </div>
                    <div class="form-group col-md-6">
                        <label >Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" required="required" data-required="true" id="confirm_password"  onkeyup='check()';>
                    </div>
                    <div class="form-group col-md-12">
                        <span id='message'></span>
                    </div>
                    <div class="form-group col-md-4"></div>
                    <div class="col-md-12">
                        <input type="submit" name="change" class="btn btn-danger form-group" style="float: right; " value="Change Password">
                    </div>
                </div>
            </div>
        </form> <br><br>
    </div><!-- container-fluid -->
</div>
</div>
<script type="text/javascript">
    var check = function() {
      if (document.getElementById('password').value ==
        document.getElementById('confirm_password').value) {
        document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = '**Passwords match**';
} else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = '**Passwords do not match**';
}
}
</script>