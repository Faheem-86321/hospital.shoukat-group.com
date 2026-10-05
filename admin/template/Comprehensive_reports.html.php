<?php
$doctors_q = mysqli_query($con, "SELECT D_ID, Name FROM ssh_dr_reg ORDER BY Name");
$doc_rows = mysqli_fetch_all($doctors_q, MYSQLI_ASSOC);
$cases_q = mysqli_query($con, "SELECT S_ID, Title FROM ssh_cases_indoor ORDER BY Title");
$case_rows = mysqli_fetch_all($cases_q, MYSQLI_ASSOC);
$case_id = isset($_GET['case_id']) ? $_GET['case_id'] : '';
$admit_type = isset($_GET['admit_type']) ? $_GET['admit_type'] : '';
?>
<div class="container-fluid"><div class="card"><div class="card-body">
<form method="get" action="" class="mb-3">
<input type="hidden" name="page" value="Comprehensive_reports">
<div class="row align-items-end">
<div class="col-md-2">
<label><b>Report Type</b></label>
<select name="report_type" class="form-control" onchange="this.form.submit()">
<option value="opd" <?= $report_type=='opd'?'selected':'' ?>>OPD</option>
<option value="ipd" <?= $report_type=='ipd'?'selected':'' ?>>IPD</option>
<option value="dialysis" <?= $report_type=='dialysis'?'selected':'' ?>>Dialysis</option>
<option value="services" <?= $report_type=='services'?'selected':'' ?>>Services</option>
<option value="expense" <?= $report_type=='expense'?'selected':'' ?>>Expense</option>
<option value="summary" <?= $report_type=='summary'?'selected':'' ?>>Summary</option>
</select>
</div>
<div class="col-md-2">
<label><b>Date From</b></label>
<input type="date" name="date_from" class="form-control" value="<?= $date_from ?>">
</div>
<div class="col-md-2">
<label><b>Date To</b></label>
<input type="date" name="date_to" class="form-control" value="<?= $date_to ?>">
</div>
<?php if(in_array($report_type,['opd','ipd','dialysis'])): ?>
<div class="col-md-2">
<label><b>Doctor</b></label>
<select name="doc_id" class="form-control">
<option value="">-- All --</option>
<?php foreach($doc_rows as $d): ?>
<option value="<?= $d['D_ID'] ?>" <?= $doc_id==$d['D_ID']?'selected':'' ?>><?= htmlspecialchars($d['Name']) ?></option>
<?php endforeach; ?>
</select>
</div>
<?php endif; ?>
<?php if($report_type=='ipd'): ?>
<div class="col-md-2">
<label><b>Case Type</b></label>
<select name="case_id" class="form-control">
<option value="">-- All Cases --</option>
<?php foreach($case_rows as $c): ?>
<option value="<?= $c['S_ID'] ?>" <?= $case_id==$c['S_ID']?'selected':'' ?>><?= htmlspecialchars($c['Title']) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="col-md-2">
<label><b>Admission Type</b></label>
<select name="admit_type" class="form-control">
<option value="">-- All --</option>
<option value="0" <?= $admit_type=='0'?'selected':'' ?>>Private</option>
<option value="1" <?= $admit_type=='1'?'selected':'' ?>>Health Card</option>
</select>
</div>
<?php endif; ?>
<div class="col-md-2">
<button type="submit" class="btn btn-danger mt-4"><i class="fa fa-search"></i> Search</button>
<a href="?page=Comprehensive_reports" class="btn btn-secondary mt-4">Reset</a>
</div>
<div class="col-md-2 mt-4 d-flex" style="gap:5px;">
<button type="button" onclick="window.print()" class="btn btn-success"><i class="fa fa-print"></i> Print</button>
<button type="button" onclick="exportExcel()" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Excel</button>
</div>
</div>
</form>
<div id="report-area">
<?php if($report_type=='opd'):
$where_doc = $doc_id ? "AND ssh_p_dpr.D_ID='$doc_id'" : "";
$res = mysqli_query($con,"SELECT DATE(A_DATE) AS rdate, ssh_dr_reg.Name AS doctor, COUNT(MRN) AS patients, SUM(ssh_p_dpr.Paid) AS total_paid, SUM(D_Pay) AS doc_share, SUM(Charges-ssh_p_dpr.Paid) AS discount FROM ssh_p_dpr JOIN ssh_dr_reg ON ssh_p_dpr.D_ID=ssh_dr_reg.D_ID WHERE DATE(A_DATE) BETWEEN '$date_from' AND '$date_to' $where_doc GROUP BY DATE(A_DATE),ssh_p_dpr.D_ID ORDER BY rdate DESC");
$tp=0;$tpaid=0;$tdoc=0;$tdisc=0;
?>
<h5><b>OPD Report</b> — <?= $date_from ?> to <?= $date_to ?></h5>
<table id="export-table" class="table table-bordered table-striped table-sm">
<thead class="thead-dark"><tr><th>Date</th><th>Doctor</th><th>Patients</th><th>Total Paid</th><th>Doctor Share</th><th>Hospital Share</th><th>Discount</th></tr></thead>
<tbody>
<?php while($r=mysqli_fetch_assoc($res)): $tp+=$r['patients'];$tpaid+=$r['total_paid'];$tdoc+=$r['doc_share'];$tdisc+=$r['discount']; ?>
<tr><td><?= $r['rdate'] ?></td><td><?= htmlspecialchars($r['doctor']) ?></td><td><?= $r['patients'] ?></td><td><?= number_format($r['total_paid'],2) ?></td><td><?= number_format($r['doc_share'],2) ?></td><td><?= number_format($r['total_paid']-$r['doc_share'],2) ?></td><td><?= number_format($r['discount'],2) ?></td></tr>
<?php endwhile; ?>
</tbody>
<tfoot style="background:lightgrey;font-weight:bold;"><tr><td>Total</td><td></td><td><?= $tp ?></td><td><?= number_format($tpaid,2) ?></td><td><?= number_format($tdoc,2) ?></td><td><?= number_format($tpaid-$tdoc,2) ?></td><td><?= number_format($tdisc,2) ?></td></tr></tfoot>
</table>
<?php elseif($report_type=='ipd'):
$where_doc  = $doc_id    ? "AND pid.D_ID='$doc_id'"          : "";
$where_case = $case_id   ? "AND i.S_ID='$case_id'"           : "";
$where_type = $admit_type!=='' ? "AND i.admition_type='$admit_type'" : "";
$res = mysqli_query($con,"
    SELECT i.pi_id, i.admit_date, i.exit_date, i.Paid, i.admition_type, i.medicine_expenses,
           p.Name AS patient,
           c.Title AS case_type,
           r.room_no,
           COALESCE((SELECT SUM(D_Fee) FROM ssh_p_indoor_doctors WHERE pi_id=i.pi_id),0) AS doc_fee
    FROM ssh_p_indoor i
    JOIN ssh_p_reg p ON i.P_ID=p.P_ID
    LEFT JOIN ssh_cases_indoor c ON i.S_ID=c.S_ID
    LEFT JOIN indoor_room r ON i.room_id=r.ir_id
    LEFT JOIN ssh_p_indoor_doctors pid ON i.pi_id=pid.pi_id
    WHERE DATE(i.admit_date) BETWEEN '$date_from' AND '$date_to'
    $where_doc $where_case $where_type
    GROUP BY i.pi_id
    ORDER BY i.admit_date DESC");
$tpaid=0;$tdoc=0;$thosp=0;$cnt=0;
?>
<h5><b>IPD Report</b> — <?= $date_from ?> to <?= $date_to ?></h5>
<table id="export-table" class="table table-bordered table-striped table-sm">
<thead class="thead-dark"><tr><th>#</th><th>Admit Date</th><th>Patient</th><th>Case</th><th>Room</th><th>Exit Date</th><th>Type</th><th>Total Paid</th><th>Doctor Fee</th><th>Medicine Exp</th><th>Hospital Share</th></tr></thead>
<tbody>
<?php $sr=1; while($r=mysqli_fetch_assoc($res)):
    $hosp = $r['Paid'] - $r['doc_fee'] - $r['medicine_expenses'];
    $tpaid+=$r['Paid']; $tdoc+=$r['doc_fee']; $thosp+=$hosp; $cnt++;
?>
<tr>
<td><?= $sr++ ?></td>
<td><?= $r['admit_date'] ?></td>
<td><?= htmlspecialchars($r['patient']) ?></td>
<td><?= htmlspecialchars($r['case_type']) ?></td>
<td><?= $r['room_no'] ?></td>
<td><?= $r['exit_date']=='0000-00-00'?'<span class="badge badge-warning">Admitted</span>':$r['exit_date'] ?></td>
<td><?= $r['admition_type']=='0'?'Private':'Health Card' ?></td>
<td><?= number_format($r['Paid'],2) ?></td>
<td><?= number_format($r['doc_fee'],2) ?></td>
<td><?= number_format($r['medicine_expenses'],2) ?></td>
<td><?= number_format($hosp,2) ?></td>
</tr>
<?php endwhile; ?>
</tbody>
<tfoot style="background:lightgrey;font-weight:bold;">
<tr><td colspan="7">Total: <?= $cnt ?></td><td><?= number_format($tpaid,2) ?></td><td><?= number_format($tdoc,2) ?></td><td></td><td><?= number_format($thosp,2) ?></td></tr>
</tfoot>
</table>
<?php elseif($report_type=='dialysis'):
$res = mysqli_query($con,"SELECT ssh_p_dialysis.date, ssh_p_reg.Name AS patient, ssh_p_reg.phone, ssh_p_dialysis.Paid FROM ssh_p_dialysis JOIN ssh_p_reg ON ssh_p_dialysis.P_ID=ssh_p_reg.P_ID WHERE DATE(ssh_p_dialysis.date) BETWEEN '$date_from' AND '$date_to' ORDER BY ssh_p_dialysis.date DESC");
$tpaid=0;$cnt=0;
?>
<h5><b>Dialysis Report</b> — <?= $date_from ?> to <?= $date_to ?></h5>
<table id="export-table" class="table table-bordered table-striped table-sm">
<thead class="thead-dark"><tr><th>#</th><th>Date</th><th>Patient</th><th>Phone</th><th>Paid</th></tr></thead>
<tbody>
<?php $sr=1; while($r=mysqli_fetch_assoc($res)): $tpaid+=$r['Paid'];$cnt++; ?>
<tr><td><?= $sr++ ?></td><td><?= $r['date'] ?></td><td><?= htmlspecialchars($r['patient']) ?></td><td><?= $r['phone'] ?></td><td><?= number_format($r['Paid'],2) ?></td></tr>
<?php endwhile; ?>
</tbody>
<tfoot style="background:lightgrey;font-weight:bold;"><tr><td colspan="4">Total: <?= $cnt ?></td><td><?= number_format($tpaid,2) ?></td></tr></tfoot>
</table>
<?php elseif($report_type=='services'):
$res = mysqli_query($con,"SELECT ssh_p_services.Date, ssh_p_reg.Name AS patient, ssh_ser_cat.Name AS service, ssh_p_services.Paid FROM ssh_p_services JOIN ssh_p_reg ON ssh_p_services.P_ID=ssh_p_reg.P_ID JOIN ssh_ser_cat ON ssh_p_services.C_ID=ssh_ser_cat.C_ID WHERE DATE(ssh_p_services.Date) BETWEEN '$date_from' AND '$date_to' ORDER BY ssh_p_services.Date DESC");
$tpaid=0;$cnt=0;
?>
<h5><b>Services Report</b> — <?= $date_from ?> to <?= $date_to ?></h5>
<table id="export-table" class="table table-bordered table-striped table-sm">
<thead class="thead-dark"><tr><th>#</th><th>Date</th><th>Patient</th><th>Service</th><th>Paid</th></tr></thead>
<tbody>
<?php $sr=1; while($r=mysqli_fetch_assoc($res)): $tpaid+=$r['Paid'];$cnt++; ?>
<tr><td><?= $sr++ ?></td><td><?= $r['Date'] ?></td><td><?= htmlspecialchars($r['patient']) ?></td><td><?= htmlspecialchars($r['service']) ?></td><td><?= number_format($r['Paid'],2) ?></td></tr>
<?php endwhile; ?>
</tbody>
<tfoot style="background:lightgrey;font-weight:bold;"><tr><td colspan="4">Total: <?= $cnt ?></td><td><?= number_format($tpaid,2) ?></td></tr></tfoot>
</table>
<?php elseif($report_type=='expense'):
$res = mysqli_query($con,"SELECT Date, Title, Amount FROM ssh_expenses WHERE DATE(Date) BETWEEN '$date_from' AND '$date_to' ORDER BY Date DESC");
$total=0;$cnt=0;
?>
<h5><b>Expense Report</b> — <?= $date_from ?> to <?= $date_to ?></h5>
<table id="export-table" class="table table-bordered table-striped table-sm">
<thead class="thead-dark"><tr><th>#</th><th>Date</th><th>Title</th><th>Amount</th></tr></thead>
<tbody>
<?php $sr=1; while($r=mysqli_fetch_assoc($res)): $total+=$r['Amount'];$cnt++; ?>
<tr><td><?= $sr++ ?></td><td><?= $r['Date'] ?></td><td><?= htmlspecialchars($r['Title']) ?></td><td><?= number_format($r['Amount'],2) ?></td></tr>
<?php endwhile; ?>
</tbody>
<tfoot style="background:lightgrey;font-weight:bold;"><tr><td colspan="3">Total: <?= $cnt ?></td><td><?= number_format($total,2) ?></td></tr></tfoot>
</table>
<?php elseif($report_type=='summary'):
$opd = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS c, SUM(Paid) AS s FROM ssh_p_dpr WHERE DATE(A_DATE) BETWEEN '$date_from' AND '$date_to'"));
$ipd = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS c, SUM(Paid) AS s FROM ssh_p_indoor WHERE DATE(admit_date) BETWEEN '$date_from' AND '$date_to'"));
$dia = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS c, SUM(Paid) AS s FROM ssh_p_dialysis WHERE DATE(date) BETWEEN '$date_from' AND '$date_to'"));
$ser = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS c, SUM(Paid) AS s FROM ssh_p_services WHERE DATE(Date) BETWEEN '$date_from' AND '$date_to'"));
$exp = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS c, SUM(Amount) AS s FROM ssh_expenses WHERE DATE(Date) BETWEEN '$date_from' AND '$date_to'"));
$ipd_doc = mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(D_Fee) AS s FROM ssh_p_indoor_doctors pid JOIN ssh_p_indoor i ON pid.pi_id=i.pi_id WHERE DATE(i.admit_date) BETWEEN '$date_from' AND '$date_to'"));
$ti=($opd['s']??0)+($ipd['s']??0)+($dia['s']??0)+($ser['s']??0);
$te=($exp['s']??0)+($ipd_doc['s']??0);
$net=$ti-$te;
?>
<h5><b>Summary Report</b> — <?= $date_from ?> to <?= $date_to ?></h5>
<table id="export-table" class="table table-bordered table-sm" style="max-width:650px;">
<thead class="thead-dark"><tr><th>Category</th><th>Count</th><th>Amount</th></tr></thead>
<tbody>
<tr><td>OPD</td><td><?= $opd['c'] ?></td><td><?= number_format($opd['s']??0,2) ?></td></tr>
<tr><td>IPD</td><td><?= $ipd['c'] ?></td><td><?= number_format($ipd['s']??0,2) ?></td></tr>
<tr><td>Dialysis</td><td><?= $dia['c'] ?></td><td><?= number_format($dia['s']??0,2) ?></td></tr>
<tr><td>Services</td><td><?= $ser['c'] ?></td><td><?= number_format($ser['s']??0,2) ?></td></tr>
<tr class="table-success"><td><b>Total Income</b></td><td></td><td><b><?= number_format($ti,2) ?></b></td></tr>
<tr><td>Expenses</td><td><?= $exp['c'] ?></td><td><?= number_format($exp['s']??0,2) ?></td></tr>
<tr><td>IPD Doctor Fee</td><td></td><td><?= number_format($ipd_doc['s']??0,2) ?></td></tr>
<tr class="table-danger"><td><b>Total Expense</b></td><td></td><td><b><?= number_format($te,2) ?></b></td></tr>
<tr class="table-warning"><td><b>Net (Hospital Share)</b></td><td></td><td><b><?= number_format($net,2) ?></b></td></tr>
</tbody>
</table>
<?php endif; ?>
</div>
</div></div></div>
<style>
@media print { .left-side-menu,.navbar-custom,.card-widgets,form,.btn{display:none !important;} }
</style>
<script>
function exportExcel() {
    var table = document.getElementById('export-table');
    if (!table) { alert('Pehle search karo'); return; }
    var html = table.outerHTML;
    var blob = new Blob(["\ufeff" + html], {type: 'application/vnd.ms-excel'});
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'report_<?= $report_type ?>_<?= $date_from ?>_<?= $date_to ?>.xls';
    a.click();
}
</script>
