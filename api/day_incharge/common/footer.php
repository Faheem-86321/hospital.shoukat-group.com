<!-- Template js-->
<script src="../assets/footer/vendor.min.js"></script>
<script src="../assets/footer/dropzone.min.js"></script>
<script src="../assets/footer/dropify.min.js"></script>
<script src="../assets/footer/form-fileuploads.init.js"></script>

<script src="../assets/footer/app.min.js"></script>
<script src="../assets/footer/morris.min.js"></script>
<script src="../assets/footer/raphael.min.js"></script>
<script src="../assets/footer/crm-leads.init.js"></script>
<!-- Delete Alert js-->
<script src="../assets/footer/sweetalert2.all.min.js"></script>
<!-- Template js-->
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script src="../assets/footer/form-advanced.init.js"></script>
<script src="../assets/footer/jquery.bootstrap.wizard.min.js"></script>
<script src="../assets/footer/form-wizard.init.js"></script>
<script src="../assets/footer/bootstrap-datepicker.min.js"></script>
<!-- Datatable -->
<script src="../assets/datatable/vfs_fonts.js"></script>
<script src="../assets/datatable/jszip.min.js"></script>
<script src="../assets/datatable/jquery-3.5.1.js"></script>
<script src="../assets/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/datatable/buttons.print.min.js"></script>
<script src="../assets/datatable/buttons.html5.min.js"></script>
<script src="../assets/datatable/pdfmaker.js"></script>
<script src="../assets/datatable/pdfvfont.js"></script>
<!-- Template js-->
<script src="../assets/footer/jquery.bootstrap.wizard.min.js"></script>
<script src="../assets/footer/form-wizard.init.js"></script>

<script src="../assets/footer/selectize.min.js"></script>
<script src="../assets/footer/select2.min.js"></script>
<script src="../assets/footer/bootstrap-select.min.js"></script>
<script src="../assets/footer/bootstrap-maxlength.min.js"></script>
<script type="text/javascript">
// Data Table Customization 
    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
  }
  
  $('#example_dashboard').DataTable({
    "bPaginate": false,
    
} );
  $('#myTable').DataTable({
    "bPaginate": false,
    "bFilter": false, 
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'print',
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );
$('#expenseTable').DataTable({
    pageLength: 15,
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copy',
            footer: true,
            title: 'Expense Report',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        },
        {
            extend: 'excelHtml5',
            footer: true,
            title: 'Expense Report',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            },
            customizeData: function(data) {

                let total = 0;

                data.body.forEach(function(row) {
                    total += parseFloat(row[3]) || 0;
                });

                data.body.push([
                    '',
                    '',
                    'Total',
                    total.toFixed(2),
                    '',
                    ''
                ]);
            }
        },
        {
            extend: 'pdfHtml5',
            footer: true,
            title: 'Expense Report',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            },
            customize: function(doc) {

                var body = doc.content[1].table.body;
                var total = 0;

                for (var i = 1; i < body.length; i++) {
                    total += parseFloat(body[i][3].text) || 0;
                }

                body.push([
                    '',
                    '',
                    { text: 'Total', bold: true },
                    { text: total.toFixed(2), bold: true },
                    '',
                    ''
                ]);
            }
        },
        {
            extend: 'print',
            footer: true,
            title: 'Expense Report',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }
    ]
});
  $('#myTable_d').DataTable({
    "bPaginate": false,
    "bFilter": false, 
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'print',
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );
  $('#myTable_view').DataTable({
    "bPaginate": false,
    "bFilter": false, 
    
    "ordering": false,
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'print',
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );


  const  fetchurl = window.location.href.split('/');
  var lastItem = fetchurl.pop();
  $('#example').DataTable({
    "pageLength": 15,
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'copy',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'excel',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'pdf',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }, {
        extend: 'print',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );
  var currentDate = $("#closing_date").val();

  $('#example_dashboard_service').DataTable({
    "pageLength": 500,
    "ordering": false,
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'copy',
        footer: true ,
        title: "Outdoor Closing Sheet "+currentDate,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'excel',
        footer: true ,
        title: "Outdoor Closing Sheet "+currentDate,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'pdf',
        footer: true ,
        title: "Outdoor Closing Sheet "+currentDate,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }, {
        extend: 'print',
        footer: true ,
        title: "Outdoor Closing Sheet "+currentDate,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );
  var currentDate_indoor = $("#closing_date_indoor").val();
  $('#example_dashboard_indoor').DataTable({
    "pageLength": 500,
    "ordering": false,
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'copy',
        footer: true ,
        title: "Health Card Closing Sheet "+currentDate_indoor,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'excel',
        footer: true ,
        title: "Health Card Closing Sheet "+currentDate_indoor,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'pdf',
        footer: true ,
        title: "Health Card Closing Sheet "+currentDate_indoor,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }, {
        extend: 'print',
        footer: true ,
        title: "Health Card Closing Sheet "+currentDate_indoor,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );
  var currentDate_indoor_private = $("#closing_date_indoor_private").val();
  $('#example_dashboard_indoor_private').DataTable({
    "pageLength": 500,
    "ordering": false,
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'copy',
        footer: true ,
        title: "Private Indoor Closing Sheet "+currentDate_indoor_private,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'excel',
        footer: true ,
        title: "Private Indoor Closing Sheet "+currentDate_indoor_private,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'pdf',
        footer: true ,
        title: "Private Indoor Closing Sheet "+currentDate_indoor_private,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }, {
        extend: 'print',
        footer: true ,
        title: "Private Indoor Closing Sheet "+currentDate_indoor_private,
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );

  $('#example_withoutsort').DataTable({
    "pageLength": 15,
    "ordering": false,
    dom: 'Bfrtip',
    buttons:  [{
        extend: 'copy',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'excel',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    },{
        extend: 'pdf',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }, {
        extend: 'print',
        title: "List of "+capitalizeFirstLetter(lastItem),
        exportOptions: {
            columns: "thead th:not(.noExport)"
        }
    }
    ]
} );
// Reload Content 
  function reloadtablecontent()
  { 
    $( "#example").load(window.location.href + " #example");
}
function reloadtablecontent_files_tabel()
{ 
    $( "#myTable_view").load(window.location.href + " #myTable_view");
}
// Database Backup
function backup(x) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#bab8b8',
        confirmButtonText: 'Yes, do it!'
    }).then((result) => {
        if (result.isConfirmed) {
            x();
        }
    })
}
function backup_data() {
    $.ajax({
        type:"POST",
        url:"getState.php",
        data: 'data_backup',
        success:function(data) {
            alert(data);
            Swal.fire(
              'Backuped!',
              'Data has been Backuped.',
              'success'
              )
        }
    });
}
// For Delete alert error
function del(x,y) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#bab8b8',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            x(y);
        }
    })
}
// For Delete alert error
function discharged_pat(x,y) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#bab8b8',
        confirmButtonText: 'Yes, Discharged!'
    }).then((result) => {
        if (result.isConfirmed) {
            x(y);
        }
    })
}

// For Approve Payment Alert
function approve_doc(x,y,z) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#bab8b8',
        confirmButtonText: 'Yes, Paid!'
    }).then((result) => {
        if (result.isConfirmed) {
            x(y,z);
        }
    })
}
// For Approve Payment Alert
function recieved_tpa(x,y) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#bab8b8',
        confirmButtonText: 'Yes, Recieved!'
    }).then((result) => {
        if (result.isConfirmed) {
            x(y);
        }
    })
}

// Prevent from form resubmission
if(window.history.replaceState){
    window.history.replaceState(null, null, window.location.href);
}
// Print Div
function printSection(el){
    var getFullContent = document.body.innerHTML;
    var printsection = document.getElementById(el).innerHTML;
    document.body.innerHTML = printsection;
    window.print();
    document.body.innerHTML = getFullContent;
    window.addEventListener("afterprint", myFunction);
    
}

function myFunction() {
    location.reload();             
}

!function(t){"use strict";function e(){}e.prototype.initSelect2=function(){t('[data-toggle="select2"]').select2()},e.prototype.initMaxLength=function(){t("input#defaultconfig").maxlength({warningClass:"badge badge-success",limitReachedClass:"badge badge-danger"})
,t("#selectize-programmatic2").selectize({options:[
    <?php 
    $fetch_data2 = "SELECT Name,CNIC,D_ID FROM ssh_dr_reg Where status = '1' ";
    $fetch_data2_ex = mysqli_query($con,$fetch_data2);
    foreach($fetch_data2_ex as $row){    
        ?>
        {value:"<?php echo $row['D_ID'];?>",name:"<?php echo $row['Name'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})

,t("#select_patient").selectize({options:[
    <?php 
    $fetch_data3 = "Select ssh_p_reg.Name AS P_Name,ssh_p_reg.phone, ssh_p_dpr.MRN,ssh_p_dpr.A_Date From ssh_p_dpr
    LEFT JOIN ssh_p_reg
    ON ssh_p_dpr.P_ID = ssh_p_reg.P_ID 
    Where CONVERT(ssh_p_dpr.A_Date,Date) = '".date('Y-m-d')."'";
    $fetch_data3_ex = mysqli_query($con,$fetch_data3);
    foreach($fetch_data3_ex as $row){    
        ?>
        {value:"<?php echo $row['MRN'];?>",name:"<?php echo $row['MRN']." ".$row['P_Name']." ".$row['phone'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})

,t("#selectize-programmatic").selectize({options:[<?php 
    $fetch_data = "SELECT Name,P_ID,phone FROM ssh_p_reg";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){    
        ?>
        {value:"<?php echo $row['P_ID'];?>",name:"<?php echo $row['Name']." ".$row['phone'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})


,t("#select_services").selectize({options:[<?php 
    $fetch_data = "SELECT * FROM ssh_ser_cat";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){    
        ?>
        {value:"<?php echo $row['C_ID'];?>",name:"<?php echo $row['Name'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})

,t("#case_id").selectize({options:[<?php 
    $fetch_data = "SELECT * FROM ssh_cases_indoor WHERE type = '0' AND close = '1'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){    
        ?>
        {value:"<?php echo $row['S_ID'];?>",name:"<?php echo $row['Title'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})

,t("#case_id1").selectize({options:[<?php 
    $fetch_data = "SELECT * FROM ssh_cases_indoor WHERE type = '1' AND close = '1'";
    $fetch_data_ex = mysqli_query($con,$fetch_data);
    foreach($fetch_data_ex as $row){    
        ?>
        {value:"<?php echo $row['S_ID'];?>",name:"<?php echo $row['Title'] ;?>"},
    <?php } ?>
    ],optgroupField:"class",labelField:"name",searchField:["name"],render:{optgroup_header:function(e,a){return'<div class="optgroup-header">'+a(e.label)+' <span class="scientific">('+a(e.label_scientific)+")</span></div>"}}})


,t(".selectize-drop-header").selectize({sortField:"text",hideSelected:!1,plugins:{dropdown_header:{title:"Language"}}})},e.prototype.initSwitchery=function(){t('[data-plugin="switchery"]').each(function(e,a){new Switchery(t(this)[0],t(this).data())})},e.prototype.initMultiSelect=function(){0<t('[data-plugin="multiselect"]').length&&t('[data-plugin="multiselect"]').multiSelect(t(this).data())},e.prototype.initTouchspin=function(){var n={};t('[data-toggle="touchspin"]').each(function(e,a){var i=t.extend({},n,t(a).data());t(a).TouchSpin(i)})},e.prototype.init=function(){this.initSelect2(),this.initMaxLength(),this.initSelectize(),this.initSwitchery(),this.initMultiSelect(),this.initTouchspin()},t.FormAdvanced=new e,t.FormAdvanced.Constructor=e}(window.jQuery),function(){"use strict";window.jQuery.FormAdvanced.init()}(),$(function(){"use strict";var o=$.map(countries,function(e,a){return{value:e,data:a}});$.mockjax({url:"*",responseTime:2e3,response:function(e){var a=e.data.query,i=a.toLowerCase(),n=new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi"),t={query:a,suggestions:$.grep(o,function(e){return n.test(e.value)})};this.responseText=JSON.stringify(t)}}),$("#autocomplete-ajax").autocomplete({lookup:o,lookupFilter:function(e,a,i){return new RegExp("\\b"+$.Autocomplete.utils.escapeRegExChars(i),"gi").test(e.value)},onSelect:function(e){$("#selction-ajax").html("You selected: "+e.value+", "+e.data)},onHint:function(e){$("#autocomplete-ajax-x").val(e)},onInvalidateSelection:function(){$("#selction-ajax").html("You selected: none")}});var e=$.map(["Anaheim Ducks"],function(e){return{value:e,data:{category:"NHL"}}}),a=$.map(["Atlanta Hawks"],function(e){return{value:e,data:{category:"NBA"}}}),i=e.concat(a);$("#autocomplete").devbridgeAutocomplete({lookup:i,minChars:1,onSelect:function(e){$("#selection").html("You selected: "+e.value+", "+e.data.category)},showNoSuggestionNotice:!0,noSuggestionNotice:"Sorry, no matching results",groupBy:"category"}),$("#autocomplete-custom-append").autocomplete({lookup:o,appendTo:"#suggestions-container"}),$("#autocomplete-dynamic").autocomplete({lookup:o})});var countries={AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates"};

</script>
<script src="../assets/footer/apexcharts.min.js"></script>
<script src="https://apexcharts.com/samples/assets/ohlc.js"></script>
<script type="text/javascript">


    var colors=["#6658dd","#1abc9c"];(dataColors=$("#sales-analytics").data("colors"))&&(colors=dataColors.split(","));var options={chart:{height:385,type:"candlestick"},plotOptions:{candlestick:{colors:{upward:colors[0],downward:colors[1]}}},series:[{data:seriesData}],stroke:{show:!0,colors:"#f1f3fa",width:[1,4]},xaxis:{type:"datetime"},grid:{borderColor:"#f1f3fa"}};(chart=new ApexCharts(document.querySelector("#sales-analytics"),options)).render();colors=["#1abc9c","#4a81d4"];(dataColors=$("#deal-analytics").data("colors"))&&(colors=dataColors.split(","));options={series:[{name:"Income",type:"column",data:[<?php
       $year = date("Y");
       for ($i=1; $i <= 12; $i++) { 
          $select_query = "SELECT *,SUM(Paid) As total FROM ssh_p_dpr WHERE MONTH(A_DATE) = '".$i."' AND YEAR(A_DATE) = '".$year."'  GROUP BY MONTH(A_DATE)";
          $select_query_ex = mysqli_query($con,$select_query);
          if (mysqli_num_rows($select_query_ex) != 0) {
           foreach($select_query_ex as $month){
            echo $month['total'].",";
        }
    }
    else{
        echo "0,";
    }
}
?>]},{name:"Expense",type:"line",data:[<?php
   $year = date("Y");
   for ($i=1; $i <= 12; $i++) { 
      $select_query = "SELECT *,SUM(Amount) FROM ssh_expenses WHERE  services = '0' AND MONTH(Date) = '".$i."' AND YEAR(Date) = '".$year."' GROUP BY MONTH(Date)";
      $select_query_ex = mysqli_query($con,$select_query);
      if (mysqli_num_rows($select_query_ex) != 0) {
       foreach($select_query_ex as $month){
        echo $month['SUM(Amount)'].",";
    }
}
else{
    echo "0,";
}
}
?>]}],chart:{height:370,type:"line"},stroke:{width:[2,3]},plotOptions:{bar:{columnWidth:"50%"}},colors:colors,dataLabels:{enabled:!0,enabledOnSeries:[1]},labels:["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],grid:{padding:{bottom:20}},fill:{type:"gradient",gradient:{shade:"light",type:"horizontal",shadeIntensity:.25,gradientToColors:void 0,inverseColors:!0,opacityFrom:.75,opacityTo:.75,stops:[0,0,0]}},yaxis:[{title:{text:""}},{opposite:!0,title:{text:""}}]};(chart=new ApexCharts(document.querySelector("#deal-analytics"),options)).render();var dataColors;colors=["#f1556c"];(dataColors=$("#deal-analytics2").data("colors"))&&(colors=dataColors.split(","));options={series:[{name:"Private",type:"column",data:[<?php
   $year = date("Y");
   for ($i=1; $i <= 12; $i++) { 
      $select_query = "SELECT *,SUM(Paid) As total FROM ssh_p_indoor WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'  GROUP BY MONTH(admit_date)";
      $select_query_ex = mysqli_query($con,$select_query);
      if (mysqli_num_rows($select_query_ex) != 0) {
       foreach($select_query_ex as $month){
        echo $month['total'].",";
    }
}
else{
    echo "0,";
}
}
?>]},{name:"Health Card",type:"line",data:[<?php
   $year = date("Y");
   for ($i=1; $i <= 12; $i++) { 
     $select_query = "SELECT *,SUM(Paid) As total FROM ssh_p_indoor WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'  GROUP BY MONTH(admit_date)";
     $select_query_ex = mysqli_query($con,$select_query);
     if (mysqli_num_rows($select_query_ex) != 0) {
       foreach($select_query_ex as $month){
        echo $month['total'].",";
    }
}
else{
    echo "0,";
}
}
?>]}],chart:{height:370,type:"line"},stroke:{width:[2,3]},plotOptions:{bar:{columnWidth:"50%"}},colors:colors,dataLabels:{enabled:!0,enabledOnSeries:[1]},labels:["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],grid:{padding:{bottom:20}},fill:{type:"gradient",gradient:{shade:"light",type:"horizontal",shadeIntensity:.25,gradientToColors:void 0,inverseColors:!0,opacityFrom:.75,opacityTo:.75,stops:[0,0,0]}},yaxis:[{title:{text:""}},{opposite:!0,title:{text:""}}]};(chart=new ApexCharts(document.querySelector("#deal-analytics2"),options)).render();var dataColors;colors=["#f1556c"];(dataColors=$("#apex-column-1").data("colors"))&&(colors=dataColors.split(","));options={chart:{height:380,type:"bar",toolbar:{show:!1}},plotOptions:{bar:{horizontal:!1,endingShape:"rounded",columnWidth:"55%"}},dataLabels:{enabled:!1},stroke:{show:!0,width:2,colors:["transparent"]},colors:colors,series:[{name:"Health Card Dialysis",data:[
<?php
$year = date("Y");
for ($i=1; $i <= 12; $i++) { 
    $select_query = "SELECT *,SUM(Paid) As total FROM ssh_p_dialysis WHERE admission_type = '1' AND MONTH(date) = '".$i."' AND YEAR(date) = '".$year."'  GROUP BY MONTH(date)";
    $select_query_ex = mysqli_query($con,$select_query);
    if (mysqli_num_rows($select_query_ex) != 0) {
     foreach($select_query_ex as $month){
        echo $month['total'].",";
    }
}
else{
    echo "0,";
}
}
?>
]},{name:"Private Dialysis",data:[
<?php
$year = date("Y");
for ($i=1; $i <= 12; $i++) { 
    $select_query = "SELECT *,SUM(Paid) As total FROM ssh_p_dialysis WHERE admission_type = '0' AND MONTH(date) = '".$i."' AND YEAR(date) = '".$year."'  GROUP BY MONTH(date)";
    $select_query_ex = mysqli_query($con,$select_query);
    if (mysqli_num_rows($select_query_ex) != 0) {
     foreach($select_query_ex as $month){
        echo $month['total'].",";
    }
}
else{
    echo "0,";
}
}
?>
]},{name:"Expense",data:[

<?php
$year = date("Y");
for ($i=1; $i <= 12; $i++) { 
  $select_query = "SELECT *,SUM(Amount) FROM ssh_expenses WHERE services = '3' AND MONTH(Date) = '".$i."' AND YEAR(Date) = '".$year."' GROUP BY MONTH(Date)";
  $select_query_ex = mysqli_query($con,$select_query);
  if (mysqli_num_rows($select_query_ex) != 0) {
   foreach($select_query_ex as $month){
    echo $month['SUM(Amount)'].",";
}
}
else{
    echo "0,";
}
}
?>
]}],xaxis:{categories:["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"]},legend:{offsetY:5},yaxis:{title:{text:""}},fill:{opacity:1},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa",padding:{bottom:10}},tooltip:{y:{formatter:function(e){return""+e+""}}}};(chart=new ApexCharts(document.querySelector("#apex-column-1"),options)).render();colors=["#6658dd"];(dataColors=$("#apex-radialbar-3").data("colors"))&&(colors=dataColors.split(","));var chart;options={chart:{height:375,type:"radialBar"},plotOptions:{radialBar:{startAngle:-135,endAngle:135,dataLabels:{name:{fontSize:"16px",color:void 0,offsetY:120},value:{offsetY:76,fontSize:"22px",color:void 0,formatter:function(e){return e+"%"}}}}},fill:{gradient:{enabled:!0,shade:"dark",shadeIntensity:.15,inverseColors:!1,opacityFrom:1,opacityTo:1,stops:[0,50,65,91]}},stroke:{dashArray:4},colors:colors,series:[67],labels:["Median Ratio"],responsive:[{breakpoint:380,options:{chart:{height:280}}}]};(chart=new ApexCharts(document.querySelector("#apex-radialbar-3"),options)).render();
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.counter-value').each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            },{
                duration: 3500,
                easing: 'swing',
                step: function (now){
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });
</script>
</body>
</html>