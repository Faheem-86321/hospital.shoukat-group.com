<?php
ob_start();
session_start();
include_once("../../env/main_config.php");
/////////////////////paymentdetailsINDOOR_update Pat//////////////////
///////////////////////////////////////////////
if (isset($_POST['paymentdetailsDialysis_update'])) {
    $paymentdetailsDialysis_update = $_POST['paymentdetailsDialysis_update']; 

    $view_data = "Select * from ssh_p_dialysis where pd_id = '".$paymentdetailsDialysis_update."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_update" value="<?php echo $row['pd_id'] ?>">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="name">Claim No <span style="color: red;"> *</span></label>
                <input type="text" class="form-control"   name='claim_no' required>
            </div>
            <div class="form-group col-md-12">
                <label for="name">Cheque Date <span style="color: red;"> *</span></label>
                <input type="date" class="form-control"  name='cheq_date'  required>
            </div>
            <div class="form-group col-md-12">
                <label for="name">Voucher No <span style="color: red;"> *</span></label>
                <input type="textr" class="form-control" name='voucher_no'   required>
            </div>
            <div class="form-group col-md-12">
                <label for="name">Cheq No <span style="color: red;"> *</span></label>
                <input type="textr" class="form-control" name="cheq_no"  required >
            </div>

        </div>   
        <div class="col-md-12 text-right">
            <button type="submit" name="pupdate2" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
        </div>
    </div>
</form>
<?php 
}
}
/////////////////////paymentdetailsINDOOR_update Pat//////////////////
///////////////////////////////////////////////
if (isset($_POST['paymentdetailsINDOOR_update'])) {
    $paymentdetailsINDOOR_update = $_POST['paymentdetailsINDOOR_update']; 

    $view_data = "Select * from ssh_p_indoor where pi_id = '".$paymentdetailsINDOOR_update."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_update" value="<?php echo $row['pi_id'] ?>">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="name">Claim No <span style="color: red;"> *</span></label>
                <input type="text" class="form-control"   name='claim_no' required>
            </div>
            <div class="form-group col-md-12">
                <label for="name">Cheque Date <span style="color: red;"> *</span></label>
                <input type="date" class="form-control"  name='cheq_date'  required>
            </div>
            <div class="form-group col-md-12">
                <label for="name">Voucher No <span style="color: red;"> *</span></label>
                <input type="textr" class="form-control" name='voucher_no'   required>
            </div>
            <div class="form-group col-md-12">
                <label for="name">Cheq No <span style="color: red;"> *</span></label>
                <input type="textr" class="form-control" name="cheq_no"  required >
            </div>

        </div>   
        <div class="col-md-12 text-right">
            <button type="submit" name="pupdate" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
        </div>
    </div>
</form>
<?php 
}
}
/////////////////////Update Indoor//////////////////
///////////////////////////////////////////////
if (isset($_POST['update_admit_private'])) {
    $update_admit_private = $_POST['update_admit_private'];

    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="number" value="<?php echo $update_admit_private ?>" name="update_admit_id" hidden>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="name">Case <span style="color: red;"> *</span></label>
                <select  class="form-control" name="case_id_u" placeholder='--- Select Case ---' id="case_id" onchange="get_doctor();"   required>
                    

                </select>  
            </div>
            <div class="col-md-12 text-center">Note: Admin will set the doctor's payment</div>
            <div class="col-md-12" id="case_doctor">
             <div class="row">
                <div class="form-group col-md-12" id="buttonshow1">

                </div>
                <div class="form-group col-md-6">
                    <label for="name">Doctor <span style="color: red;"> *</span></label>
                    <select  class="form-control" name="doc_id[]" id="doc_option1"  onchange="get_doctor_price(1);"  required>
                        <option disabled selected value=""> --- Select Doctor --- </option>


                    </select>   
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                    <input type="number" class="form-control totalcost" readonly id="doc_fee1" name="doctor_payment[]" value="0"> 
                </div>
                <div class="col-md-12" id="more_doctor"></div> 

                <div class="form-group col-md-12" id="buttonshow">

                </div></div>
            </div>
            <div class="form-group col-md-12">
                <label for="name"> Total Charges<span style="color: red;"> *</span></label>
                <input type="number" class="form-control" name="Paid_u"  onkeyup="minvalue()" required  id="totalbill_new">
                <input type="number" class="form-control"  hidden  id="totalbill_new_hide">

            </div> 
            <div class="col-md-12" id="warnmsg_newone"></div>
        </div>    
        <script type="text/javascript">
            function minvalue(){
                var total_doc_0 = parseInt($("#totalbill_new_hide").val());
                var total_doc_1 = parseInt($("#totalbill_new").val());
                if (total_doc_1 < total_doc_0) {
                    $('#warnmsg_newone').html("<div class='alert alert-danger'>Total Payment must be greater then doctors payments</div>");
                    $("#errorbutton").attr('disabled',true);
                }else{
                   $('#warnmsg_newone').html(' ');
                   $("#errorbutton").attr('disabled',false);
               }


           }
       </script>   
       <div class="col-md-12 text-right">
        <button type="submit" name="updateindoor" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
    </div>
</div>
</form>
<script type="text/javascript">
!function(t){"use strict";function e(){}e.prototype.initSelect2=function(){t('[data-toggle="select2"]').select2()},e.prototype.initMaxLength=function(){t("input#defaultconfig").maxlength({warningClass:"badge badge-success",limitReachedClass:"badge badge-danger"})
t("#case_id").selectize({options:[<?php 
    $fetch_data = "SELECT * FROM ssh_cases_indoor WHERE type = '0' AND close = '1'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){    
        ?>
        {value:"<?php echo $row['S_ID'];?>",name:"<?php echo $row['Title'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})

,t(".selectize-drop-header").selectize({sortField:"text",hideSelected:!1,plugins:{dropdown_header:{title:"Language"}}})},e.prototype.initSwitchery=function(){t('[data-plugin="switchery"]').each(function(e,a){new Switchery(t(this)[0],t(this).data())})},e.prototype.initMultiSelect=function(){0<t('[data-plugin="multiselect"]').length&&t('[data-plugin="multiselect"]').multiSelect(t(this).data())},e.prototype.initTouchspin=function(){var n={};t('[data-toggle="touchspin"]').each(function(e,a){var i=t.extend({},n,t(a).data());t(a).TouchSpin(i)})},e.prototype.init=function(){this.initSelect2(),this.initMaxLength(),this.initSelectize(),this.initSwitchery(),this.initMultiSelect(),this.initTouchspin()},t.FormAdvanced=new e,t.FormAdvanced.Constructor=e}(window.jQuery),function(){"use strict";window.jQuery.FormAdvanced.init()}(),$(function(){"use strict";var o=$.map(countries,function(e,a){return{value:e,data:a}});$.mockjax({url:"*",responseTime:2e3,response:function(e){var a=e.data.query,i=a.toLowerCase(),n=new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi"),t={query:a,suggestions:$.grep(o,function(e){return n.test(e.value)})};this.responseText=JSON.stringify(t)}}),$("#autocomplete-ajax").autocomplete({lookup:o,lookupFilter:function(e,a,i){return new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi").test(e.value)},onSelect:function(e){$("#selction-ajax").html("You selected: "+e.value+", "+e.data)},onHint:function(e){$("#autocomplete-ajax-x").val(e)},onInvalidateSelection:function(){$("#selction-ajax").html("You selected: none")}});var e=$.map(["Anaheim Ducks"],function(e){return{value:e,data:{category:"NHL"}}}),a=$.map(["Atlanta Hawks"],function(e){return{value:e,data:{category:"NBA"}}}),i=e.concat(a);$("#autocomplete").devbridgeAutocomplete({lookup:i,minChars:1,onSelect:function(e){$("#selection").html("You selected: "+e.value+", "+e.data.category)},showNoSuggestionNotice:!0,noSuggestionNotice:"Sorry, no matching results",groupBy:"category"}),$("#autocomplete-custom-append").autocomplete({lookup:o,appendTo:"#suggestions-container"}),$("#autocomplete-dynamic").autocomplete({lookup:o})});var countries={AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates"};

</script>
<?php  
}
/////////////////////Update Indoor//////////////////
///////////////////////////////////////////////
if (isset($_POST['update_admit'])) {
    $update_admit = $_POST['update_admit'];

    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="number" value="<?php echo $update_admit ?>" name="update_admit_id" hidden>
        <div class="row">
           <div class="form-group col-md-12">
            <label for="name">Case <span style="color: red;"> *</span></label>
            <select  class="form-control" name="case_id_u" id="case_id1" placeholder=' --- Select Case ---' onchange="get_doctor();"   required>
                

            </select>  
        </div>
        <div class="col-md-12" id="case_doctor">
           <div class="row">
            <div class="form-group col-md-12" id="buttonshow1">

            </div>
            <div class="form-group col-md-6">
                <label for="name">Doctor <span style="color: red;"> *</span></label>
                <select  class="form-control" name="doc_id[]" id="doc_option1"  onchange="get_doctor_price(1);"  required>
                    <option disabled selected value=""> --- Select Doctor --- </option>


                </select>   
            </div>
            <div class="form-group col-md-6">
                <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" class="form-control totalcost" readonly id="doc_fee1" name="doctor_payment[]" value="0"> 
            </div>
            <div class="col-md-12" id="more_doctor"></div> 

            <div class="form-group col-md-12" id="buttonshow">

            </div></div>
        </div>
        <div class="form-group col-md-12">
            <label for="name"> Total Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
            <input type="number" class="form-control" name="Paid_u" value="0" required readonly id="totalbill_new">
            <input type="number" hidden class="form-control" name="" value="0" required readonly id="totalbill_new_hide">
        </div>
        <div class="form-group col-md-12">
            <label for="name">Hospital Share <sub style="color: green !important;">(Readonly)</sub></label>
            <input type="number" class="form-control" readonly value="0" name=" " onkeyup="" id="hospital_share_ok" required>
        </div> 
    </div>    
    <div class="col-md-12 text-right">
        <button type="submit" name="updateindoor" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
    </div>
</div>
</form><script type="text/javascript">
!function(t){"use strict";function e(){}e.prototype.initSelect2=function(){t('[data-toggle="select2"]').select2()},e.prototype.initMaxLength=function(){t("input#defaultconfig").maxlength({warningClass:"badge badge-success",limitReachedClass:"badge badge-danger"})
t("#case_id1").selectize({options:[<?php 
    $fetch_data = "SELECT * FROM ssh_cases_indoor WHERE type = '1' AND close = '1'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){    
        ?>
        {value:"<?php echo $row['S_ID'];?>",name:"<?php echo $row['Title'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})

,t(".selectize-drop-header").selectize({sortField:"text",hideSelected:!1,plugins:{dropdown_header:{title:"Language"}}})},e.prototype.initSwitchery=function(){t('[data-plugin="switchery"]').each(function(e,a){new Switchery(t(this)[0],t(this).data())})},e.prototype.initMultiSelect=function(){0<t('[data-plugin="multiselect"]').length&&t('[data-plugin="multiselect"]').multiSelect(t(this).data())},e.prototype.initTouchspin=function(){var n={};t('[data-toggle="touchspin"]').each(function(e,a){var i=t.extend({},n,t(a).data());t(a).TouchSpin(i)})},e.prototype.init=function(){this.initSelect2(),this.initMaxLength(),this.initSelectize(),this.initSwitchery(),this.initMultiSelect(),this.initTouchspin()},t.FormAdvanced=new e,t.FormAdvanced.Constructor=e}(window.jQuery),function(){"use strict";window.jQuery.FormAdvanced.init()}(),$(function(){"use strict";var o=$.map(countries,function(e,a){return{value:e,data:a}});$.mockjax({url:"*",responseTime:2e3,response:function(e){var a=e.data.query,i=a.toLowerCase(),n=new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi"),t={query:a,suggestions:$.grep(o,function(e){return n.test(e.value)})};this.responseText=JSON.stringify(t)}}),$("#autocomplete-ajax").autocomplete({lookup:o,lookupFilter:function(e,a,i){return new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi").test(e.value)},onSelect:function(e){$("#selction-ajax").html("You selected: "+e.value+", "+e.data)},onHint:function(e){$("#autocomplete-ajax-x").val(e)},onInvalidateSelection:function(){$("#selction-ajax").html("You selected: none")}});var e=$.map(["Anaheim Ducks"],function(e){return{value:e,data:{category:"NHL"}}}),a=$.map(["Atlanta Hawks"],function(e){return{value:e,data:{category:"NBA"}}}),i=e.concat(a);$("#autocomplete").devbridgeAutocomplete({lookup:i,minChars:1,onSelect:function(e){$("#selection").html("You selected: "+e.value+", "+e.data.category)},showNoSuggestionNotice:!0,noSuggestionNotice:"Sorry, no matching results",groupBy:"category"}),$("#autocomplete-custom-append").autocomplete({lookup:o,appendTo:"#suggestions-container"}),$("#autocomplete-dynamic").autocomplete({lookup:o})});var countries={AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates"};

</script>
<?php  
}

/////////////////////payment_receieved_dialysis Pat//////////////////
///////////////////////////////////////////////
if (isset($_POST['get_taxmed'])) {
    $get_taxmed = $_POST['get_taxmed']; 
    
    ?>
    <div class="row">
        <?php
        $fetch_data = "SELECT * FROM ssh_docsetting_indoor where D_ID = '16' AND S_ID = '".$get_taxmed."' AND close = '1' ";
        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ 
            ?>
            <div class="form-group col-md-6">
                <label for="name">Doctor <span style="color: red;"> *</span></label>
                <select  class="form-control" name="doc_id[]"   required>
                    <option  selected value="16"> Tax</option>
                </select>   
            </div>
            <div class="form-group col-md-6">
                <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" class="form-control totalcost" readonly id="" name="doctor_payment[]" value="<?php echo $row['doc_charges'] ?>"> 
            </div>
        <?php } ?> 

        <?php
        $fetch_data = "SELECT * FROM ssh_docsetting_indoor where D_ID = '17' AND S_ID = '".$get_taxmed."' AND close = '1' ";
        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ 
            ?>
            <div class="form-group col-md-6">
                <label for="name">Doctor <span style="color: red;"> *</span></label>
                <select  class="form-control" name="doc_id[]"   required>
                    <option  selected value="17"> Medicine</option>
                </select>   
            </div>
            <div class="form-group col-md-6">
                <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" class="form-control totalcost" readonly id="" name="doctor_payment[]" value="<?php echo $row['doc_charges'] ?>"> 
            </div>

        <?php } ?>

    </div>
    <?php 
}
/////////////////////payment_receieved_dialysis Pat//////////////////
///////////////////////////////////////////////
if (isset($_POST['get_taxmed_private'])) {
    $get_taxmed = $_POST['get_taxmed_private']; 
    
    ?>
    <div class="row">
        <?php
        $fetch_data = "SELECT * FROM ssh_docsetting_indoor where D_ID = '16' AND S_ID = '".$get_taxmed."' AND close = '1' ";
        $fetch_data_ex = mysqli_query($con,$fetch_data);
        foreach($fetch_data_ex as $row){ 
            ?>
            <div class="form-group col-md-6">
                <label for="name">Doctor <span style="color: red;"> *</span></label>
                <select  class="form-control" name="doc_id[]"   required>
                    <option  selected value="16"> Tax</option>
                </select>   
            </div>
            <div class="form-group col-md-6">
                <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" class="form-control totalcost" readonly id="" name="doctor_payment[]" value="<?php echo $row['doc_charges'] ?>"> 
            </div>
        <?php } ?> 

        
            <div class="form-group col-md-6">
                <label for="name">Doctor <span style="color: red;"> *</span></label>
                <select  class="form-control" name="doc_id[]"   required>
                    <option  selected value="17"> Medicine</option>
                </select>   
            </div>
            <div class="form-group col-md-6">
                <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" class="form-control totalcost" readonly id="" name="doctor_payment[]" value="<?php echo 0 ?>"> 
            </div>

    </div>
    <?php 
}
/////////////////////payment_receieved_dialysis Pat//////////////////
///////////////////////////////////////////////
if (isset($_POST['payment_receieved_dialysis'])) {
    $payment_receieved_dialysis = $_POST['payment_receieved_dialysis'];
    date_default_timezone_set("Asia/Karachi");
    $update_data = "UPDATE ssh_p_dialysis SET file_status = '2',receive_date = '".date('Y-m-d')."'  WHERE pd_id='".$payment_receieved_dialysis."' ";
    $update_data_ex = mysqli_query($con,$update_data);
    if ($update_data_ex) {
     echo 'true';
 }else{
     echo 'false';
 }
}
/////////////////////payment_receieved Pat//////////////////
///////////////////////////////////////////////
if (isset($_POST['payment_receieved'])) {
    $payment_receieved = $_POST['payment_receieved'];
    date_default_timezone_set("Asia/Karachi");
    $update_data = "UPDATE ssh_p_indoor SET file_status = '2',receive_date = '".date('Y-m-d')."'  WHERE pi_id='".$payment_receieved."' ";
    $update_data_ex = mysqli_query($con,$update_data);
    if ($update_data_ex) {
     echo 'true';
 }else{
     echo 'false';
 }
}
/////////////////////View get_hospital_share//////////////////
///////////////////////////////////////////////
if (isset($_POST['get_hospital_share'])) {
    $get_hospital_share = $_POST['get_hospital_share'];
    $fetch_data = "SELECT * FROM ssh_cases_indoor where S_ID = '".$get_hospital_share."'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ 
        echo $row['Charges'];
    }
}          
/////////////////////Validate Room//////////////////
///////////////////////////////////////////////
if (isset($_POST['room_id_validate'])) {
    $room_id_validate = $_POST['room_id_validate'];
    $val_data = "Select * from ssh_p_indoor where room_id = '".$room_id_validate."' AND exit_date = '0000-00-00' ";
    $val_data_ex = mysqli_query($con,$val_data);
    if (mysqli_num_rows($val_data_ex) > 0) {
       echo 'false';
   }else{
       echo 'true';
   }
}
/////////////////////View Indoor//////////////////
///////////////////////////////////////////////
if (isset($_POST['view_admit'])) {
    $view_admit = $_POST['view_admit'];
    $fetch_data = "SELECT * FROM ssh_p_indoor JOIN ssh_p_reg ON ssh_p_indoor.P_ID = ssh_p_reg.P_ID LEFT JOIN ssh_cases_indoor ON ssh_p_indoor.S_ID = ssh_cases_indoor.S_ID LEFT JOIN indoor_room ON ssh_p_indoor.room_id = indoor_room.ir_id where ssh_p_indoor.pi_id = '".$view_admit."'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){ 
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="name">Visitor ID <span style="color: red;"> *</span><sub style="color: green;">(Readonly)</sub></label>
                    <input type="text" class="form-control"  readonly value="<?php echo $row['visitor_id'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Admit Date <span style="color: red;"> *</span><sub style="color: green;">(Readonly)</sub></label>
                    <input type="date" class="form-control"  readonly value="<?php echo $row['admit_date'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Discharged Date <span style="color: red;"> *</span><sub style="color: green;">(Readonly)</sub></label>
                    <input type="date" class="form-control"  readonly value="<?php echo $row['exit_date'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Name <span style="color: red;"> *</span></label>
                    <input type="text" class="form-control"  readonly value="<?php echo $row['Name'] ?>" >
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Age <span style="color: red;"> *</span></label>
                    <input type="number" class="form-control"  readonly value="<?php echo $row['age'] ?>" >
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Phone <span style="color: red;"> *</span></label>
                    <input type="number" class="form-control"  readonly value="<?php echo $row['phone'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Gender <span style="color: red;"> *</span></label>
                    <select class="form-control"   readonly >
                        <option selected value=""><?php echo $row['gender'] ?></option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Room <span style="color: red;"> *</span></label>
                    <select class="form-control"   readonly >
                        <option selected value=""><?php echo $row['room_no'] ?></option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Case <span style="color: red;"> *</span></label>
                    <select class="form-control"   readonly >
                        <option selected value=""><?php echo $row['Title'] ?></option>
                    </select>
                </div>
                <?php
                $fetch_data_new = "SELECT * FROM ssh_p_indoor_doctors JOIN ssh_dr_reg ON ssh_p_indoor_doctors.D_ID = ssh_dr_reg.D_ID  where ssh_p_indoor_doctors.pi_id = '".$view_admit."'";
                $fetch_data_new_ex = mysqli_query($con,$fetch_data_new);
                foreach($fetch_data_new_ex as $row1){ 
                    ?>
                    <div class="form-group col-md-6">
                        <label for="name">Doctor <span style="color: red;"> *</span></label>
                        <select  class="form-control" required>
                            <option disabled selected value=""> <?php echo $row1['Name'] ?> </option>


                        </select>   
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Doctor Fee<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" readonly value="<?php echo $row1['D_Fee'] ?>"> 
                    </div>

                    <?php 
                } 
                $discount = 0;
                $discount = $row['total_fee'] - $row['Paid'];
                if ($row['admition_type'] == '0') { ?>
                    <div class="form-group col-md-6">
                        <label for="name">Discount <span style="color: red;"> *</span></label>
                        <input type="number" class="form-control" value="<?php echo $discount ?>" readonly  required>
                    </div>
                <?php } ?>   
                <div class="form-group col-md-6">
                    <label for="name">Total Charges<sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                    <input type="number" class="form-control" readonly value="<?php echo $row['Paid'] ?>"> 
                </div>
            </div>
        </form>      
        <?php  
    }
}

/////////////////////Del pat adm//////////////////
///////////////////////////////////////////////
if (isset($_POST['admit_del'])) {
    $admit_del = $_POST['admit_del'];
    $del_data = "DELETE FROM ssh_p_indoor where pi_id='".$admit_del."'";
    $del_data_ex = mysqli_query($con,$del_data);
    if ($del_data_ex) {
       $del_data1 = "DELETE FROM ssh_p_indoor_doctors where pi_id='".$admit_del."'";
       $del_data1_ex = mysqli_query($con,$del_data1);
       echo 'true';
   }else{
     echo 'false';
 }
}
 /////////////////////Del pat adm//////////////////
///////////////////////////////////////////////
if (isset($_POST['admit_del_dialysis'])) {
    $admit_del_dialysis = $_POST['admit_del_dialysis'];
    $fetch_data = "SELECT * FROM ssh_p_dialysis  where pd_id = '".$admit_del_dialysis."'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){
        if ($row['injection'] == '1') {
            $fetch_data = "SELECT * FROM dialysis_item ";
            $fetch_data_ex = mysqli_query($con,$fetch_data);
            foreach($fetch_data_ex as $row){ 
                $pr_id = $row['di_id'];
                $ser_count = $row['stock'] + 1;
                $update_data_12 = " UPDATE dialysis_item SET stock ='".$ser_count."' where di_id='".$pr_id."'";
                $update_data_12_ex = mysqli_query($con,$update_data_12);
            }

        }elseif ($row['injection'] == '0') {
             $fetch_data = "SELECT * FROM dialysis_item where di_id != 5 ";
            $fetch_data_ex = mysqli_query($con,$fetch_data);
            foreach($fetch_data_ex as $row){ 
                $pr_id = $row['di_id'];
                $ser_count = $row['stock'] + 1;
                $update_data_12 = " UPDATE dialysis_item SET stock ='".$ser_count."' where di_id='".$pr_id."'";
                $update_data_12_ex = mysqli_query($con,$update_data_12);
            }
        }else{
           
        }
    }
    $del_data = "DELETE FROM ssh_p_dialysis where pd_id='".$admit_del_dialysis."'";
    $del_data_ex = mysqli_query($con,$del_data);
    if ($del_data_ex) {

       echo 'true';
   }else{
     echo 'false';
 }
}

/////////////////////Discharged Pat//////////////////
///////////////////////////////////////////////
if (isset($_POST['discharged_patient'])) {
    $discharged_patient = $_POST['discharged_patient'];
    date_default_timezone_set("Asia/Karachi");
    $update_data = "UPDATE ssh_p_indoor SET exit_date = '".date('Y-m-d')."'  WHERE pi_id='".$discharged_patient."' ";
    $update_data_ex = mysqli_query($con,$update_data);
    if ($update_data_ex) {
     echo 'true';
 }else{
     echo 'false';
 }
}
///////////////////// Get Doctor//////////////////
///////////////////////////////////////////////
if (isset($_POST['case_new'])) {
    $get_doctor = $_POST['case_new'];
    $new_fee_id = $_POST['new_fee_id']; 
    ?>
    <div class="row" id="rows<?php echo $new_fee_id ;?>">
        <div class="form-group col-md-5">
            <label for="name">Doctor <span style="color: red;"> *</span></label>
            <select  class="form-control" name="doc_id[]" id="doc_option<?php echo $new_fee_id ?>"   onchange="get_doctor_price(<?php echo $new_fee_id ?>);"  required>
                <option disabled selected value=""> --- Select Doctor --- </option>
                <?php
                $fetch_data_ep = "SELECT * FROM ssh_docsetting_indoor JOIN ssh_dr_reg ON ssh_docsetting_indoor.D_ID = ssh_dr_reg.D_ID  WHERE ssh_docsetting_indoor.close = '1' AND ssh_dr_reg.status= '1' AND ssh_docsetting_indoor.S_ID = '".$get_doctor."' ";
                $fetch_data_ep_ex = mysqli_query($con,$fetch_data_ep);
                foreach($fetch_data_ep_ex as $row1){ 
                    echo "<option value='".$row1['D_ID']."'>".ucwords($row1['Name'])."</option>";
                }
                ?>

            </select>  
        </div>
        <div class="form-group col-md-5">
            <label for="name">Doctor Fee <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
            <input type="number" class="form-control totalcost" readonly  id="doc_fee<?php echo $new_fee_id ?>" name="doctor_payment[]" value="0"> 
        </div>
        <div class="form-group col-md-2">
            <label for="name">Option </label>
            <a class='btn btn-danger text-white' onclick='removethiseduc(<?php echo $new_fee_id ;?>);' style='height: 35px;padding: 10px;'><i class='fa fa-trash'></i></a>
        </div>
    </div>
    <?php
}
///////////////////// Get Doctor Price//////////////////
///////////////////////////////////////////////
if (isset($_POST['doc_option1'])) {
    $doc_option1 = $_POST['doc_option1'];
    $case = $_POST['case'];
    $fetch_data_ep = "SELECT * FROM ssh_docsetting_indoor  WHERE close = '1' AND D_ID = '".$doc_option1."' AND S_ID = '".$case."'";
    $fetch_data_ep_ex = mysqli_query($con,$fetch_data_ep);
    foreach($fetch_data_ep_ex as $row1){ 
        echo $row1['doc_charges'];
    }
    ?>



    <?php
} 
///////////////////// Get Doctor//////////////////
///////////////////////////////////////////////
if (isset($_POST['get_doctor'])) {
    $get_doctor = $_POST['get_doctor'];
    ?>
    <option disabled selected value=""> --- Select Doctor --- </option>
    <?php
    $fetch_data_ep = "SELECT * FROM ssh_docsetting_indoor JOIN ssh_dr_reg ON ssh_docsetting_indoor.D_ID = ssh_dr_reg.D_ID  WHERE ssh_docsetting_indoor.close = '1' AND ssh_dr_reg.status= '1' AND ssh_docsetting_indoor.S_ID = '".$get_doctor."' ";
    $fetch_data_ep_ex = mysqli_query($con,$fetch_data_ep);
    foreach($fetch_data_ep_ex as $row1){ 
        echo "<option value='".$row1['D_ID']."'>".ucwords($row1['Name'])."</option>";
    }
    ?>



    <?php
}    

/////////////////////Update Indoor Services//////////////////
///////////////////////////////////////////////
if (isset($_POST['update_indoor_services'])) {
    $update_indoor_mrn = $_POST['update_indoor_services'];
    ?>
    <div class="alert alert-success text-center"><?php echo $update_indoor_mrn ?></div>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $update_indoor_mrn ;?>"  name="mrn_f_up">

        <?php 
        $view_data = "Select * From ssh_p_indoor Join ssh_services_indoor ON ssh_p_indoor.S_ID = ssh_services_indoor.S_ID Where ssh_p_indoor.MRN = '".$update_indoor_mrn."'  ";
        $view_data_ex = mysqli_query($con,$view_data);
        foreach($view_data_ex as $row){ ?>
            <div class='row' id='row<?php echo $row['S_ID'] ?>'>
               <div class="form-group col-md-6">
                <label for="name"> Service <span style="color: red;"> *</span></label>
                <select id="" class="form-control" name="" onchange="getsercharges(0)" placeholder="... Select Service..." required>
                    <option value="<?php echo $row['S_ID'] ?>" selected><?php echo $row['Title'] ;?></option>
                    <!-- <?php
                    $fetch_data_ser1 = "SELECT S_ID,Title from ssh_services_indoor";
                    $fetch_data_ser1_ex = mysqli_query($con,$fetch_data_ser1);
                    foreach($fetch_data_ser1_ex as $row1){ 
                        ?>
                        <option value="<?php echo $row1['S_ID'] ?>"><?php echo $row1['Title'] ;?></option>
                        <?php }  ?>  -->  
                    </select>   
                </div>
                <div class="form-group col-md-5">
                    <label for="name"> Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                    <input  type="number" class="form-control" value="<?php echo $row['Paid'] ?>" name="" id="" required readonly value='0'>
                </div>  


            </div>
        <?php }  
        ?>
        <div class="row"> 
            <div class="col-md-12" id="next_services_u"></div>
            <div class="form-group col-md-12">
                <a class="form-control btn btn-success" onclick="next_services_u_fun();" style="height: 35px;padding: 10px;width: 30px;"><i class="fa fa-plus"></i></a>
            </div>
            <!-- <?php 
            $view_data_p = "Select SUM(Paid) AS total_paid From ssh_p_indoor  Where MRN = '".$update_indoor_mrn."'  ";
            $view_data_p_ex = mysqli_query($con,$view_data_p);
            foreach($view_data_p_ex as $row2){
                $total_paid = $row2['total_paid'];
            }
            ?>
            <div class="form-group col-md-6">
                <label for="name"> Paid Charges <sub style="color: green !important;">+ DOCTOR CHARGES (Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" id="paid" class="form-control" name="" readonly value="<?php echo $total_paid; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="name"> Total Charges <sub style="color: green !important;">+ DOCTOR CHARGES (Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" id="totalbill_new" class="form-control" name="" readonly value="<?php echo $total_paid; ?>" required>
            </div> -->
            <div class="form-group col-md-12">
                <label for="name"> UnPaid Charges <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input type="number" id="totalbill_new_u" class="form-control" name="" readonly value="0" required>
            </div>
            <div class="col-md-12 text-right">
                <button type="submit" name="psubmit_u_u" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
            </div>
        </div>
    </form>      
    <?php  
}
/////////////////////Update Indoor//////////////////
///////////////////////////////////////////////
if (isset($_POST['update_indoor_doc'])) {
    $update_indoor_mrn = $_POST['update_indoor_doc'];
    ?>
    <div class="alert alert-success text-center"><?php echo $update_indoor_mrn ?></div>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $update_indoor_mrn ;?>"  name="mrn_f_up">
        <div class="row">  
            <?php 
            $view_data = "Select * From ssh_p_indoor Join ssh_dr_reg ON ssh_p_indoor.D_ID = ssh_dr_reg.D_ID Where ssh_p_indoor.MRN = '".$update_indoor_mrn."'  ";
            $view_data_ex = mysqli_query($con,$view_data);
            foreach($view_data_ex as $row){ ?>
             <div class="form-group col-md-6">
                <label for="name"> Doctor <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <select id="" class="form-control" name="" onchange="" readonly placeholder="... Select Doctor..." required>
                    <option value="<?php echo $row['D_ID'] ?>"  selected><?php echo $row['Name'] ;?></option>
                </select>   
            </div>
            <div class="form-group col-md-6">
                <label for="name">  Shares <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
                <input  type="number" class="form-control" name="" id="" required readonly value='<?php echo $row['Paid'] ;?>'>
            </div>
        <?php }  
        ?>
        <script src="../assets/footer/selectize.min.js"></script>
        <script src="../assets/footer/select2.min.js"></script>
        <script src="../assets/footer/bootstrap-select.min.js"></script>
        <script src="../assets/footer/bootstrap-maxlength.min.js"></script>
        <script type="text/javascript">
            !function(t){"use strict";function e(){}e.prototype.initSelect2=function(){t('[data-toggle="select2"]').select2()},e.prototype.initMaxLength=function(){t("input#defaultconfig").maxlength({warningClass:"badge badge-success",limitReachedClass:"badge badge-danger"})
            ,t("#selectize-programmatic3").selectize({options:[
                <?php 
                $fetch_data2 = "SELECT Name,CNIC,D_ID FROM ssh_dr_reg Where status = '1' ";
                $fetch_data2_ex = mysqli_query($con,$fetch_data2);
                foreach($fetch_data2_ex as $row){    
                    ?>
                    {value:"<?php echo $row['D_ID'];?>",name:"<?php echo $row['Name'] ;?>"},
                <?php } ?>
                ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})

            ,t(".selectize-drop-header").selectize({sortField:"text",hideSelected:!1,plugins:{dropdown_header:{title:"Language"}}})},e.prototype.initSwitchery=function(){t('[data-plugin="switchery"]').each(function(e,a){new Switchery(t(this)[0],t(this).data())})},e.prototype.initMultiSelect=function(){0<t('[data-plugin="multiselect"]').length&&t('[data-plugin="multiselect"]').multiSelect(t(this).data())},e.prototype.initTouchspin=function(){var n={};t('[data-toggle="touchspin"]').each(function(e,a){var i=t.extend({},n,t(a).data());t(a).TouchSpin(i)})},e.prototype.init=function(){this.initSelect2(),this.initMaxLength(),this.initSelectize(),this.initSwitchery(),this.initMultiSelect(),this.initTouchspin()},t.FormAdvanced=new e,t.FormAdvanced.Constructor=e}(window.jQuery),function(){"use strict";window.jQuery.FormAdvanced.init()}(),$(function(){"use strict";var o=$.map(countries,function(e,a){return{value:e,data:a}});$.mockjax({url:"*",responseTime:2e3,response:function(e){var a=e.data.query,i=a.toLowerCase(),n=new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi"),t={query:a,suggestions:$.grep(o,function(e){return n.test(e.value)})};this.responseText=JSON.stringify(t)}}),$("#autocomplete-ajax").autocomplete({lookup:o,lookupFilter:function(e,a,i){return new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi").test(e.value)},onSelect:function(e){$("#selction-ajax").html("You selected: "+e.value+", "+e.data)},onHint:function(e){$("#autocomplete-ajax-x").val(e)},onInvalidateSelection:function(){$("#selction-ajax").html("You selected: none")}});var e=$.map(["Anaheim Ducks"],function(e){return{value:e,data:{category:"NHL"}}}),a=$.map(["Atlanta Hawks"],function(e){return{value:e,data:{category:"NBA"}}}),i=e.concat(a);$("#autocomplete").devbridgeAutocomplete({lookup:i,minChars:1,onSelect:function(e){$("#selection").html("You selected: "+e.value+", "+e.data.category)},showNoSuggestionNotice:!0,noSuggestionNotice:"Sorry, no matching results",groupBy:"category"}),$("#autocomplete-custom-append").autocomplete({lookup:o,appendTo:"#suggestions-container"}),$("#autocomplete-dynamic").autocomplete({lookup:o})});var countries={AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates"};
        </script>
        <div class="form-group col-md-6" >
            <label for="name">Doctor <span style="color: red;"> *</span></label>
            <select  id="selectize-programmatic3" name="doc_id_u" onchange="getdocprice_u()" placeholder="... Select Doctor..." required>
            </select>   
        </div>
        <div class="form-group col-md-6">
            <label for="name">  Shares <sub style="color: green !important;">(Readonly)</sub><span style="color: red;"> *</span></label>
            <input type="number" class="form-control" name="doc_ch_u" value="0" required readonly id="doc_shares_u">
        </div>
        <div class="col-md-12 text-right">
            <button type="submit" name="psubmit_u" id="errorbutton" class="btn btn-success waves-effect waves-light">Save</button>
        </div>
    </div>
</form>      
<?php  
}
/////////////////////Get doctor Indoor shares //////////////////
///////////////////////////////////////////////
if (isset($_POST['get_doctor_shares'])) {
    $get_doctor_shares = $_POST['get_doctor_shares'];
    $view_data = "SELECT D_ID,Indoor_Shares FROM ssh_dr_reg WHERE D_ID= '".$get_doctor_shares."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ 
        echo $row['Indoor_Shares']; 
        ?>
        
    <?php }
}
/////////////////////Get Charges form services //////////////////
///////////////////////////////////////////////
if (isset($_POST['get_ser_charges'])) {
    $get_ser_charges = $_POST['get_ser_charges'];
    $view_data = "SELECT Charges FROM ssh_services_indoor WHERE S_ID= '".$get_ser_charges."'";
    $view_data_ex = mysqli_query($con,$view_data);
    foreach($view_data_ex as $row){ 
        echo $row['Charges']; 
        ?>
        
    <?php }
}
?>