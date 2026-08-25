<?php
if (isset($_POST['psubmit'])) {
    date_default_timezone_set("Asia/Karachi");

    function clean_input($con, $data) {
        return mysqli_real_escape_string($con, preg_replace('/[^!<>@&.\/\sA-Za-z0-9_-]/', '', $data));
    }

    $pat_id = isset($_POST['pat_id']) ? clean_input($con, $_POST['pat_id']) : "";

    if (!empty($pat_id)) {
        // Updating existing patient
        $pat_Name_update = isset($_POST['pat_Name_update']) ? clean_input($con, $_POST['pat_Name_update']) : "";
        $pat_Age_update = isset($_POST['pat_Age_update']) ? clean_input($con, $_POST['pat_Age_update']) : "";
        $pat_Phone_update = isset($_POST['pat_Phone_update']) ? clean_input($con, $_POST['pat_Phone_update']) : "";
        $pat_gender_update = isset($_POST['pat_gender_update']) ? clean_input($con, $_POST['pat_gender_update']) : "";

        $update_data = "UPDATE ssh_p_reg SET Name='$pat_Name_update', Age='$pat_Age_update', Phone='$pat_Phone_update', Gender='$pat_gender_update' WHERE P_ID = '$pat_id'";
        $update_data_ex = mysqli_query($con, $update_data);

        if ($update_data_ex) {
            // Proceed with inserting dialysis info
            $visitor_id = isset($_POST['visitor_id']) ? clean_input($con, $_POST['visitor_id']) : "";
            $Paid = isset($_POST['Paid']) ? clean_input($con, $_POST['Paid']) : "";
            $injection = isset($_POST['injection']) ? clean_input($con, $_POST['injection']) : "";

            // Update dialysis_item stock
            $fetch_data = ($injection == 1)
                ? "SELECT * FROM dialysis_item"
                : "SELECT * FROM dialysis_item WHERE di_id != 5";
            
            $fetch_data_ex = mysqli_query($con, $fetch_data);
            foreach ($fetch_data_ex as $row) {
                $pr_id = $row['di_id'];
                $ser_count = $row['stock'] - 1;
                $update_data_12 = "UPDATE dialysis_item SET stock = '$ser_count' WHERE di_id = '$pr_id'";
                mysqli_query($con, $update_data_12);
            }

            $insert_data = "INSERT INTO ssh_p_dialysis(visitor_id, P_ID, injection, Paid, date, admission_type)
                            VALUES ('$visitor_id', '$pat_id', '$injection', '$Paid', '".date('Y-m-d')."', '1')";
            $insert_data_ex = mysqli_query($con, $insert_data);

            if ($insert_data_ex) {
                $last_id = $con->insert_id;
                echo "<script>window.open('print_slip_dialysis.html.php?slip=$last_id', '_blank');</script>";
            } else {
                echo "<div class='alert alert-danger'>Dialysis insert failed: " . mysqli_error($con) . "</div>";
            }

        } else {
            echo "<div class='alert alert-danger'>Patient update failed: " . mysqli_error($con) . "</div>";
        }

    } else {
        // Insert new patient
        $pat_Name = isset($_POST['pat_Name']) ? clean_input($con, $_POST['pat_Name']) : "";
        $pat_Age = isset($_POST['pat_Age']) ? clean_input($con, $_POST['pat_Age']) : "";
        $pat_Phone = isset($_POST['pat_Phone']) ? clean_input($con, $_POST['pat_Phone']) : "";
        $pat_gender = isset($_POST['pat_gender']) ? clean_input($con, $_POST['pat_gender']) : "";

        $insert1_data = "INSERT INTO ssh_p_reg(Name, Age, Phone, Gender) 
                         VALUES ('$pat_Name', '$pat_Age', '$pat_Phone', '$pat_gender')";
        $insert1_data_ex = mysqli_query($con, $insert1_data);

        if ($insert1_data_ex) {
            $last_p_id = $con->insert_id;
            $visitor_id = isset($_POST['visitor_id']) ? clean_input($con, $_POST['visitor_id']) : "";
            $Paid = isset($_POST['Paid']) ? clean_input($con, $_POST['Paid']) : "";
            $injection = isset($_POST['injection']) ? clean_input($con, $_POST['injection']) : "";

            // Update stock
            $fetch_data = ($injection == 1)
                ? "SELECT * FROM dialysis_item"
                : "SELECT * FROM dialysis_item WHERE di_id != 5";

            $fetch_data_ex = mysqli_query($con, $fetch_data);
            foreach ($fetch_data_ex as $row) {
                $pr_id = $row['di_id'];
                $ser_count = $row['stock'] - 1;
                $update_data_12 = "UPDATE dialysis_item SET stock = '$ser_count' WHERE di_id = '$pr_id'";
                mysqli_query($con, $update_data_12);
            }

            // ✅ FIXED: Correctly assign P_ID and injection
            $insert_data = "INSERT INTO ssh_p_dialysis(visitor_id, P_ID, injection, Paid, date, admission_type)
                            VALUES ('$visitor_id', '$last_p_id', '$injection', '$Paid', '".date('Y-m-d')."', '1')";
            $insert_data_ex = mysqli_query($con, $insert_data);

            if ($insert_data_ex) {
                $last_id = $con->insert_id;
                echo "<script>window.open('print_slip_dialysis.html.php?slip=$last_id', '_blank');</script>";
            } else {
                echo "<div class='alert alert-danger'>Dialysis insert failed: " . mysqli_error($con) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Patient insert failed: " . mysqli_error($con) . "</div>";
        }
    }
}
?>
