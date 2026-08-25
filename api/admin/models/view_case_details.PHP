<?php
ob_start();
session_start();
include_once("../../env/main_config.php");

// Handle viewing case details
if(isset($_POST['view_case_details'])) {
    $case_id = $_POST['case_id'] ?? '';
    $date_from = $_POST['date_from'] ?? '';
    $date_to = $_POST['date_to'] ?? '';
    
    if(empty($case_id) || empty($date_from) || empty($date_to)) {
        echo '<div class="alert alert-danger">Missing required parameters!</div>';
        exit();
    }
    
    // Get procedure name
    $procedure_query = "SELECT Title FROM ssh_cases_indoor WHERE S_ID = '$case_id'";
    $procedure_result = mysqli_query($con, $procedure_query);
    $procedure_row = mysqli_fetch_assoc($procedure_result);
    $procedure_name = $procedure_row['Title'] ?? 'Unknown Procedure';
    
    // Get all cases for this procedure
    $query = "
        SELECT 
            i.pi_id,
            p.Name AS patient_name,
            p.MR_No,
            i.admit_date,
            i.Paid,
            c.Title AS procedure_name,
            dr.Name AS doctor_name,
            d.D_Fee,
            (i.Paid - d.D_Fee) AS hospital_share
        FROM ssh_p_indoor i
        LEFT JOIN ssh_p_indoor_doctors d ON i.pi_id = d.pi_id
        LEFT JOIN ssh_dr_reg dr ON d.D_ID = dr.D_ID
        LEFT JOIN ssh_patient p ON i.MR_No = p.MR_No
        LEFT JOIN ssh_cases_indoor c ON i.S_ID = c.S_ID
        WHERE d.to_paid = '1'
          AND i.admition_type = '0'
          AND DATE(i.admit_date) BETWEEN '$date_from' AND '$date_to'
          AND i.S_ID = '$case_id'
        ORDER BY i.admit_date DESC
    ";
    
    $result = mysqli_query($con, $query);
    
    if(!$result) {
        echo '<div class="alert alert-danger">Database Error: ' . mysqli_error($con) . '</div>';
        exit();
    }
    ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-3">Case Details for: <?= htmlspecialchars($procedure_name) ?></h4>
                <h6 class="text-center mb-4">Date Range: <?= date('d-m-Y', strtotime($date_from)) ?> to <?= date('d-m-Y', strtotime($date_to)) ?></h6>
                
                <?php if(mysqli_num_rows($result) > 0): ?>
                <?php
                    $sr = 1;
                    $total_cases = 0;
                    $total_paid = 0;
                    $total_fee = 0;
                    $total_share = 0;
                ?>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr style="background: #f8f9fa;">
                                <th>Sr#</th>
                                <th>Case ID</th>
                                <th>MR No</th>
                                <th>Patient Name</th>
                                <th>Admission Date</th>
                                <th>Doctor</th>
                                <th>Paid (PKR)</th>
                                <th>Doctor Fee (PKR)</th>
                                <th>Hospital Share (PKR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): 
                                $total_cases++;
                                $total_paid += $row['Paid'];
                                $total_fee += $row['D_Fee'];
                                $total_share += $row['hospital_share'];
                            ?>
                            <tr>
                                <td><?= $sr++; ?></td>
                                <td><strong><?= htmlspecialchars($row['pi_id']); ?></strong></td>
                                <td><?= htmlspecialchars($row['MR_No'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($row['patient_name'] ?? 'N/A'); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['admit_date'])); ?></td>
                                <td><?= htmlspecialchars($row['doctor_name']); ?></td>
                                <td class="text-right"><?= number_format($row['Paid'], 2); ?></td>
                                <td class="text-right"><?= number_format($row['D_Fee'], 2); ?></td>
                                <td class="text-right"><?= number_format($row['hospital_share'], 2); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot style="background:#f2f2f2; font-weight: bold;">
                            <tr>
                                <td colspan="6" class="text-center"><b>Total Summary</b></td>
                                <td class="text-right"><b><?= number_format($total_paid, 2) ?></b></td>
                                <td class="text-right"><b><?= number_format($total_fee, 2) ?></b></td>
                                <td class="text-right"><b><?= number_format($total_share, 2) ?></b></td>
                            </tr>
                            <tr style="background:#e9ecef;">
                                <td colspan="9" class="text-center">
                                    <b>Summary:</b> <?= $total_cases ?> Cases | 
                                    Total Revenue: PKR <?= number_format($total_paid, 2) ?> | 
                                    Doctor Fees: PKR <?= number_format($total_fee, 2) ?> | 
                                    Net Hospital Income: PKR <?= number_format($total_share, 2) ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <?php else: ?>
                <div class="alert alert-warning text-center">
                    <i class="fa fa-exclamation-triangle mr-2"></i>
                    No individual cases found for this procedure in the selected date range.
                </div>
                <?php endif; ?>
                
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times mr-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
    exit();
}

// For AJAX dropdowns
if(isset($_POST['get_cases_list'])) {
    $cases = mysqli_query($con, "SELECT `S_ID`, `Title` FROM `ssh_cases_indoor` WHERE close = 1 ORDER BY `Title` ASC");
    while ($case = mysqli_fetch_assoc($cases)) {
        echo '<option value="'.$case['S_ID'].'">'.$case['Title'].'</option>';
    }
    exit;
}
?>