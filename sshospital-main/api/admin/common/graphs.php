<script src="../assets/footer/apexcharts.min.js"></script>
<script src="https://apexcharts.com/samples/assets/ohlc.js"></script>
<script type="text/javascript">


    var colors=["#6658dd","#1abc9c"];(dataColors=$("#sales-analytics").data("colors"))&&(colors=dataColors.split(","));var options={chart:{height:385,type:"candlestick"},plotOptions:{candlestick:{colors:{upward:colors[0],downward:colors[1]}}},series:[{data:seriesData}],stroke:{show:!0,colors:"#f1f3fa",width:[1,4]},xaxis:{type:"datetime"},grid:{borderColor:"#f1f3fa"}};(chart=new ApexCharts(document.querySelector("#sales-analytics"),options)).render();colors=["#1abc9c","#4a81d4"];(dataColors=$("#deal-analytics").data("colors"))&&(colors=dataColors.split(","));options={series:[{name:"Income",type:"column",data:[<?php
     $year = date("Y");
     for ($i=1; $i <= 12; $i++) { 
        $total_val = 0;
        $select_query = "SELECT *,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN)) As total FROM ssh_p_dpr WHERE MONTH(A_DATE) = '".$i."' AND YEAR(A_DATE) = '".$year."'  GROUP BY MONTH(A_DATE)";
        $select_query_ex = mysqli_query($con,$select_query);
        if (mysqli_num_rows($select_query_ex) != 0) {
         foreach($select_query_ex as $month){
            $total_val += number_format((float)$month['total'], 2, '.', '');
        }
    }else{
        $total_val +=  0;
    }
    $select_query12 = "SELECT *,SUM(Paid) As total FROM ssh_p_services WHERE MONTH(DATE) = '".$i."' AND YEAR(DATE) = '".$year."'  GROUP BY MONTH(DATE)";
    $select_query12_ex = mysqli_query($con,$select_query12);
    if (mysqli_num_rows($select_query12_ex) != 0) {
     foreach($select_query12_ex as $month){
        $total_val += $month['total'];
    }
}else{
    $total_val +=  0;
}
echo $total_val.",";
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
?>]},{name:"Patients",type:"column",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
    $total_val = 0;
    $select_query = "SELECT *,count(MRN) AS total
    FROM ssh_p_dpr
    WHERE MONTH(A_DATE) = '".$i."' AND YEAR(A_DATE) = '".$year."'
    GROUP BY MONTH(A_DATE)";

    $select_query_ex = mysqli_query($con, $select_query);

    if (mysqli_num_rows($select_query_ex) != 0) {
     foreach($select_query_ex as $month){
        $total_val += number_format((float)$month['total'], 2, '.', '');
    }
}else{
    $total_val +=  0;
}
$select_query12 = "SELECT *,count(ser_p_id) As total FROM ssh_p_services WHERE MONTH(DATE) = '".$i."' AND YEAR(DATE) = '".$year."'  GROUP BY MONTH(DATE)";
$select_query12_ex = mysqli_query($con,$select_query12);
if (mysqli_num_rows($select_query12_ex) != 0) {
 foreach($select_query12_ex as $month){
    $total_val += $month['total'];
}
}else{
    $total_val +=  0;
}
echo $total_val.",";
}
?>]}],chart:{height:370,type:"line"},stroke:{width:[2,3]},plotOptions:{bar:{columnWidth:"50%"}},colors:colors,dataLabels:{enabled:!0,enabledOnSeries:[1]},labels:["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],grid:{padding:{bottom:20}},fill:{type:"gradient",gradient:{shade:"light",type:"horizontal",shadeIntensity:.25,gradientToColors:void 0,inverseColors:!0,opacityFrom:.75,opacityTo:.75,stops:[0,0,0]}},yaxis:[{title:{text:""}},{opposite:!0,title:{text:""}}]};(chart=new ApexCharts(document.querySelector("#deal-analytics"),options)).render();colors=["#1abc9c","#4a81d4"];(dataColors=$("#deal-analytics-ovarall").data("colors"))&&(colors=dataColors.split(","));options={series:[{name:"Income",type:"column",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
    $total_val = 0;
    $select_query = "SELECT *,SUM(((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay) - ((((ssh_p_dpr.Charges-50)-ssh_p_dpr.D_Pay)*100)/(ssh_p_dpr.Charges-50))*((ssh_p_dpr.Charges-50)-(ssh_p_dpr.Paid-50))/100)+(50*count(MRN)) As total FROM ssh_p_dpr WHERE MONTH(A_DATE) = '".$i."' AND YEAR(A_DATE) = '".$year."'  GROUP BY MONTH(A_DATE)";
    $select_query_ex = mysqli_query($con,$select_query);
    if (mysqli_num_rows($select_query_ex) != 0) {
     foreach($select_query_ex as $month){
        $total_val += number_format((float)$month['total'], 2, '.', '');
    }
}else{
    $total_val +=  0;
}
$select_query = "SELECT *, 
(SELECT SUM(Paid) FROM ssh_p_indoor WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."') - 
 (SELECT SUM(D_Fee) FROM ssh_p_indoor_doctors WHERE pi_id IN (SELECT pi_id FROM ssh_p_indoor WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."')) AS total 
 FROM ssh_p_indoor 
 WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'
 GROUP BY MONTH(admit_date)";

 $select_query_ex = mysqli_query($con, $select_query);


 if (mysqli_num_rows($select_query_ex) != 0) {
   foreach($select_query_ex as $month){
       $total_val += $month['total'];
   }
}
else{
    $total_val +=  0;
}
$select_query = "SELECT *, 
(SELECT SUM(Paid) FROM ssh_p_indoor WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."') - 
 (SELECT SUM(D_Fee) FROM ssh_p_indoor_doctors WHERE pi_id IN (SELECT pi_id FROM ssh_p_indoor WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."')) AS total 
 FROM ssh_p_indoor 
 WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'
 GROUP BY MONTH(admit_date)";

 $select_query_ex = mysqli_query($con, $select_query);


 if (mysqli_num_rows($select_query_ex) != 0) {
   foreach($select_query_ex as $month){
       $total_val += $month['total'];
   }
}
else{
    $total_val +=  0;
}
$select_query12 = "SELECT *,SUM(Paid) As total FROM ssh_p_services WHERE MONTH(DATE) = '".$i."' AND YEAR(DATE) = '".$year."'  GROUP BY MONTH(DATE)";
$select_query12_ex = mysqli_query($con,$select_query12);
if (mysqli_num_rows($select_query12_ex) != 0) {
 foreach($select_query12_ex as $month){
    $total_val += $month['total'];
}
}else{
    $total_val +=  0;
}
$select_query = "SELECT *,SUM(Paid) As total FROM ssh_p_dialysis WHERE admission_type = '1' AND MONTH(date) = '".$i."' AND YEAR(date) = '".$year."'  GROUP BY MONTH(date)";
$select_query_ex = mysqli_query($con,$select_query);
if (mysqli_num_rows($select_query_ex) != 0) {
   foreach($select_query_ex as $month){
    $total_val +=  $month['total'];
}
}
else{
    $total_val +=  0;
}
$select_query = "SELECT *,SUM(Paid) As total FROM ssh_p_dialysis WHERE admission_type = '0' AND MONTH(date) = '".$i."' AND YEAR(date) = '".$year."'  GROUP BY MONTH(date)";
$select_query_ex = mysqli_query($con,$select_query);
if (mysqli_num_rows($select_query_ex) != 0) {
   foreach($select_query_ex as $month){
    $total_val +=  $month['total'];
}
}
else{
    $total_val +=  0;
}
$select_query = "SELECT *,SUM(income) As total FROM ssh_general_income WHERE  MONTH(created_at) = '".$i."' AND YEAR(created_at) = '".$year."'  GROUP BY MONTH(created_at)";
$select_query_ex = mysqli_query($con,$select_query);
if (mysqli_num_rows($select_query_ex) != 0) {
   foreach($select_query_ex as $month){
    $total_val +=  $month['total'];
}
}
else{
    $total_val +=  0;
}
echo $total_val.",";
}
?>]},{name:"Expense",type:"line",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
  $select_query = "SELECT *,SUM(Amount) FROM ssh_expenses WHERE  MONTH(Date) = '".$i."' AND YEAR(Date) = '".$year."' GROUP BY MONTH(Date)";
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
?>]}],chart:{height:370,type:"line"},stroke:{width:[2,3]},plotOptions:{bar:{columnWidth:"50%"}},colors:colors,dataLabels:{enabled:!0,enabledOnSeries:[1]},labels:["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],grid:{padding:{bottom:20}},fill:{type:"gradient",gradient:{shade:"light",type:"horizontal",shadeIntensity:.25,gradientToColors:void 0,inverseColors:!0,opacityFrom:.75,opacityTo:.75,stops:[0,0,0]}},yaxis:[{title:{text:""}},{opposite:!0,title:{text:""}}]};(chart=new ApexCharts(document.querySelector("#deal-analytics-ovarall"),options)).render();colors=["#1abc9c","#4a81d4"];(dataColors=$("#file_status_overall").data("colors"))&&(colors=dataColors.split(","));options={series:[{name:"Submitted",type:"column",data:[<?php
 $year = date("Y");
 $total_val = 0;
 $total_val1 = 0;
 for ($i=1; $i <= 12; $i++) {
    $total_val = 0;
    $select_query = "SELECT *,count(pi_id) as total FROM ssh_p_indoor where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_date != '0000-00-00' AND  MONTH(file_date) = '".$i."' AND YEAR(file_date) = '".$year."'  GROUP BY MONTH(file_date)";
    $select_query_ex = mysqli_query($con,$select_query);
    if (mysqli_num_rows($select_query_ex) != 0) {
        foreach($select_query_ex as $row){
            $total_val +=  $row['total'];
        }

    }
    else{
        $total_val +=  0;
    }
    $select_query = "SELECT *,count(pd_id) as total FROM ssh_p_dialysis where ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_date != '0000-00-00' AND  MONTH(file_date) = '".$i."' AND YEAR(file_date) = '".$year."'  GROUP BY MONTH(file_date)";
    $select_query_ex = mysqli_query($con,$select_query);
    if (mysqli_num_rows($select_query_ex) != 0) {
        foreach($select_query_ex as $row){

         $total_val +=  $row['total'];
     }
 }
 else{
    $total_val +=  0;
}
echo $total_val.",";
}
?>]},{name:"Paid",type:"line",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
    $total_val1 = 0;
  $select_query = "SELECT *,count(pi_id) as total FROM ssh_p_indoor where ssh_p_indoor.exit_date != '0000-00-00' AND ssh_p_indoor.admition_type = '1' AND ssh_p_indoor.file_status = '2' AND MONTH(ssh_p_indoor.file_date) = '".$i."' AND YEAR(ssh_p_indoor.file_date) = '".$year."' GROUP BY MONTH(ssh_p_indoor.file_date)";
  $select_query_ex = mysqli_query($con,$select_query);
  if (mysqli_num_rows($select_query_ex) != 0) {
     foreach($select_query_ex as $row){

         $total_val1 +=  $row['total'];
     }
 }
 else{
    $total_val1 +=  0;
}
$select_query = "SELECT *,count(pd_id) as total FROM ssh_p_dialysis where ssh_p_dialysis.admission_type = '1' AND ssh_p_dialysis.file_status = '2'  AND MONTH(file_date) = '".$i."' AND YEAR(file_date) = '".$year."' GROUP BY MONTH(file_date)";
$select_query_ex = mysqli_query($con,$select_query);
if (mysqli_num_rows($select_query_ex) != 0) {
 foreach($select_query_ex as $row){

         $total_val1 +=  $row['total'];
     }
}
else{
    $total_val1 +=  0;
}
echo $total_val1.",";
}
?>]}],chart:{height:370,type:"line"},stroke:{width:[2,3]},plotOptions:{bar:{columnWidth:"50%"}},colors:colors,dataLabels:{enabled:!0,enabledOnSeries:[1]},labels:["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],grid:{padding:{bottom:20}},fill:{type:"gradient",gradient:{shade:"light",type:"horizontal",shadeIntensity:.25,gradientToColors:void 0,inverseColors:!0,opacityFrom:.75,opacityTo:.75,stops:[0,0,0]}},yaxis:[{title:{text:""}},{opposite:!0,title:{text:""}}]};(chart=new ApexCharts(document.querySelector("#file_status_overall"),options)).render();var dataColors;colors=["#f1556c"];(dataColors=$("#deal-analytics2").data("colors"))&&(colors=dataColors.split(","));options={series:[{name:"Private  Income",type:"column",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
  $select_query = "SELECT *, 
  (SELECT SUM(Paid) FROM ssh_p_indoor WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."') - 
   (SELECT SUM(D_Fee) FROM ssh_p_indoor_doctors WHERE pi_id IN (SELECT pi_id FROM ssh_p_indoor WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."')) AS total 
   FROM ssh_p_indoor 
   WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'
   GROUP BY MONTH(admit_date)";

   $select_query_ex = mysqli_query($con, $select_query);


   if (mysqli_num_rows($select_query_ex) != 0) {
     foreach($select_query_ex as $month){
        echo $month['total'].",";
    }
}
else{
    echo "0,";
}
}
?>]},{name:"Private Patients",type:"column",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
    $select_query = "SELECT *,Count(pi_id) As total FROM ssh_p_indoor WHERE admition_type = '0' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'  GROUP BY MONTH(admit_date)";
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
?>]},{name:"Health Card Income",type:"column",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
  $select_query = "SELECT *, 
  (SELECT SUM(Paid) FROM ssh_p_indoor WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."') - 
   (SELECT SUM(D_Fee) FROM ssh_p_indoor_doctors WHERE pi_id IN (SELECT pi_id FROM ssh_p_indoor WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."')) AS total 
   FROM ssh_p_indoor 
   WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'
   GROUP BY MONTH(admit_date)";

   $select_query_ex = mysqli_query($con, $select_query);
   if (mysqli_num_rows($select_query_ex) != 0) {
     foreach($select_query_ex as $month){
        echo $month['total'].",";
    }
}
else{
    echo "0,";
}
}
?>]},{name:"Health Card Patients",type:"line",data:[<?php
 $year = date("Y");
 for ($i=1; $i <= 12; $i++) { 
   $select_query = "SELECT *,count(pi_id) As total FROM ssh_p_indoor WHERE admition_type = '1' AND MONTH(admit_date) = '".$i."' AND YEAR(admit_date) = '".$year."'  GROUP BY MONTH(admit_date)";
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
?>]}],chart:{height:370,type:"line"},stroke:{width:[2,3]},plotOptions:{bar:{columnWidth:"50%"}},colors:colors,dataLabels:{enabled:!0,enabledOnSeries:[1]},labels:["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],grid:{padding:{bottom:20}},fill:{type:"gradient",gradient:{shade:"light",type:"horizontal",shadeIntensity:.25,gradientToColors:void 0,inverseColors:!0,opacityFrom:.75,opacityTo:.75,stops:[0,0,0]}},yaxis:[{title:{text:""}},{opposite:!0,title:{text:""}}]};(chart=new ApexCharts(document.querySelector("#deal-analytics2"),options)).render();var dataColors;colors=["#f1556c"];(dataColors=$("#apex-column-1").data("colors"))&&(colors=dataColors.split(","));options={chart:{height:380,type:"bar",toolbar:{show:!1}},plotOptions:{bar:{horizontal:!1,endingShape:"rounded",columnWidth:"55%"}},dataLabels:{enabled:!1},stroke:{show:!0,width:2,colors:["transparent"]},colors:colors,series:[{name:"Health Card Income",data:[
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
]},{name:"Health Card Patients",data:[
<?php
$year = date("Y");
for ($i=1; $i <= 12; $i++) { 
    $select_query = "SELECT *,count(pd_id) As total FROM ssh_p_dialysis WHERE admission_type = '1' AND MONTH(date) = '".$i."' AND YEAR(date) = '".$year."'  GROUP BY MONTH(date)";
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
]},{name:"Private Income",data:[
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
]},{name:"Private  Patients",data:[
<?php
$year = date("Y");
for ($i=1; $i <= 12; $i++) { 
    $select_query = "SELECT *,count(pd_id) As total FROM ssh_p_dialysis WHERE admission_type = '0' AND MONTH(date) = '".$i."' AND YEAR(date) = '".$year."'  GROUP BY MONTH(date)";
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
  $select_query = "SELECT *,SUM(Amount) FROM ssh_expenses WHERE (Title Like '%Bicarb solution%' || Title Like '%Heparin%' || Title Like '%Dialysis Set%' || Title Like '%Erythropoietin%'  || Title Like '%BTL%'  || Title Like '%Dialyzer%' ) AND MONTH(Date) = '".$i."' AND services != '0' AND YEAR(Date) = '".$year."' GROUP BY MONTH(Date)";
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